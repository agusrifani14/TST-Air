<?php

namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;
use App\Models\Flight;

class FlightAPI extends ResourceController
{
    public function getFlight()
    {
        $model = model(Flight::class);
        $origin = $this->request->getVar('origin');
        $destination = $this->request->getVar('destination');
        $date = $this->request->getVar('date');
        $capacity = $this->request->getVar('capacity');

        $result = $model->getFlights($origin, $destination, $date, $capacity);
        if ($result) {
            $data = [
                'message' => 'success',
                'flights' => $result
            ];  
        } else {
            $data = [
                'message' => 'failed',
                // 'flights' => [$origin, $destination, $date, $capacity]
                'flights' => []
            ];
        }
        return $this->respond($data);
    }

    public function getAllFLights()
    {
        $model = model(Flight::class);
        $result = $model->getAllFlights();
        if ($result) {
            $data = [
                'message' => 'success',
                'flights' => $result
            ];
        } else {
            $data = [
                'message' => 'failed',
                'flights' => []
            ];
        }
        return $this->respond($data);
    }

    public function getByID(){ 
        $model = model(Flight::class);
        $flight_id = $this->request->getVar('flight_id');
        $result = $model->getFlight($flight_id);
        if ($result) {
            $data = [
                'message' => 'success',
                'flight' => $result
            ];
        } else {
            $data = [
                'message' => 'failed',
                'flight' => []
            ];
        }
        return $this->respond($data);
    }
}
