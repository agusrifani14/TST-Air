<?php

namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;
use App\Models\Booking;
use App\Models\BookingAuth;
use App\Models\Flight;
use App\Models\Airport;

class BookingAPI extends ResourceController
{
    private function getData($url, $data = [])
    {
        $url = rtrim($url, '?'); // Remove trailing question mark if it exists
        $url .= '?' . http_build_query($data);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 2); // 2 second timeout

        $output = curl_exec($ch);

        curl_close($ch);

        return $output;
    }

    public function create()
    {
        $model = model(Booking::class);

        // --- API Key Authentication ---
        $apiKey = $this->request->getHeaderLine('X-API-KEY')
                  ?: $this->request->getVar('api_key');
        $expectedKey = env('BOOKING_API_KEY', '');

        if (empty($expectedKey) || !hash_equals($expectedKey, (string)$apiKey)) {
            return $this->failUnauthorized('Invalid or missing API key.');
        }

        $flight_id = $this->request->getVar('flight_id');
        $pnr       = $this->request->getVar('pnr');

        // Basic input validation
        if (empty($flight_id) || empty($pnr)) {
            return $this->fail('flight_id and pnr are required.');
        }

        $result = $model->createBooking($flight_id, $pnr);
        if ($result) {
            $data = [
                'message' => 'success',
                'booking' => $result
            ];
        } else {
            $data = [
                'message' => 'failed',
                'booking' => []
            ];
        }
        
        return $this->respond($data);
    }

    // public function testAuth()
    // {
    //     $seg1 = $this->request->getVar('seg1');
    //     $seg2 = $this->request->getVar('seg2');
    //     $authModel = model(BookingAuth::class);
    //     $checksum = 0;
    //     $checksum = $authModel->getDataAuthentication($seg1, $seg2);
    //     var_dump($checksum);
    // }

    // public function pay($pnr, $seg1=null, $seg2=null)
    // {
    //     $model = model(Booking::class);
    //     $authModel = model(BookingAuth::class);
    //     $checksum = $authModel->getDataAuthentication($seg1, $seg2);
    //     if ($checksum == 0){
    //         return("Invalid authentication!");
    //     } else {
    //         $result = $model->payBooking($pnr);
    //         if ($result) {
    //             $data = [
    //                 'message' => 'success',
    //                 'booking' => $result
    //             ];
    //         } else {
    //             $data = [
    //                 'message' => 'failed',
    //                 'booking' => []
    //             ];
    //         }
    //         return $this->respond($data);
    //     }
    // }

    public function checkinForm()
    {
        return view('checkin_form');
    }

    public function checkinResult()
    {
        $model = model(Booking::class);
        $flightModel = model(Flight::class);
        $airportModel = model(Airport::class);

        // Sanitize user-supplied inputs before forwarding to internal service
        $booking_id = preg_replace('/[^A-Za-z0-9\-]/', '', (string)$this->request->getVar('booking_id'));
        $last_name  = preg_replace('/[^A-Za-z\s\'\-]/', '', (string)$this->request->getVar('last_name'));

        $getData = [ 
            'booking_id' => $booking_id,
            'last_name'  => $last_name
        ];
        $response = $this->getData('localhost:3000/pnrAPI', $getData);
        
        if (!$response) {
            return view('checkin_result', ['checkin_result' => null, 'error' => 'Ticketing service (localhost:3000) is currently offline. Please ensure the ticket system is running and try again.']);
        }
        
        $response = json_decode($response);
        if (!$response || !isset($response->message)) {
            return view('checkin_result', ['checkin_result' => null, 'error' => 'Invalid response received from ticketing service.']);
        }
        
        $message = $response->message;
        $status = isset($response->status[0]->status) ? $response->status[0]->status : null;
        if ($message === 'success' && $status === 'Success') {    
            $pnr = $response->data[0]->id;
            $resultDump = $model->payBooking($pnr);
            $fid = $response->data[0]->flight_id;
            $result = $model->getCheckin($pnr);
            $flight_result = $flightModel->getFlight($fid);
            if (!$flight_result) {
                return view('checkin_result', ['checkin_result' => null, 'error' => 'Associated flight record was not found in OnlyFlights database.']);
            }
            $origin = $airportModel->getSpecificAirport($flight_result->origin_id);
            $destination = $airportModel->getSpecificAirport($flight_result->destination_id);
            
            $checkin_result = [
                'booking_id' => $response->data[0]->booking_id,
                'honorifics' => $response->data[0]->honorifics,
                'first_name' => $response->data[0]->first_name,
                'last_name' => $response->data[0]->last_name,
                'flight_id' => $response->data[0]->flight_id,
                'departure_airport' => $origin ? $origin[0]->name : 'Unknown Airport',
                'origin_iata' => $flight_result->origin_id,
                'arrival_airport' => $destination ? $destination[0]->name : 'Unknown Airport',
                'dest_iata' => $flight_result->destination_id,
                'departure_date' => $flight_result->schedule,
                'seat_num' => $result ? $result->seat_num : 'N/A'
            ];
            return view('checkin_result', ['checkin_result' => $checkin_result]);
        } else {
            return view('checkin_result', ['checkin_result' => null]);
        }   
    }
}
