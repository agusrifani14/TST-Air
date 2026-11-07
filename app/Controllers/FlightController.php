<?php
namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;
use App\Models\Flight;
use App\Models\Airport;

class FlightController extends ResourceController
{
    public function addFlightPage()
    {
            if (!session()->get('log')) {
                return redirect()->to('/login');
            }
        $model = model(Flight::class);
        $airportModel = model(Airport::class);
        $airports = $airportModel->getAirport();
        return view('navbar').view('add_flight', ['airports' => $airports]);
    }

    public function add()
    {
        if (!session()->get('log')) {
            return $this->failUnauthorized('Not authorized.');
        }
        // insert OF- to the flight number
        $flight_id = 'OF-'.$this->request->getPost('flight_number');
        $model = model(Flight::class);
        $model->addFlight($flight_id, $this->request->getPost('origin_id'), $this->request->getPost('destination_id'), $this->request->getPost('schedule'), $this->request->getPost('capacity'), $this->request->getPost('duration'), $this->request->getPost('price'));
        return redirect()->to('/flight');
    }

    public function viewFlightPage()
    {
        if (!session()->get('log')) {
            return redirect()->to('/login');
        }
        $model = model(Flight::class);
        $airportModel = model(Airport::class);
        $flights = $model->getAllFlights();
        $airports = $airportModel->getAirport();
        return view('navbar').view('view_flight', ['flights' => $flights, 'airports' => $airports]);
    }

    public function fetchFlight($id)
    {
        $model = model(Flight::class);
        $flight = $model->getFlight($id);
        return json_encode($flight);
    }

    public function editFlight($id)
    {
        if (!session()->get('log')) {
            return $this->failUnauthorized('Not authorized.');
        }
        $model = model(Flight::class);
        $model->editFlight($id, $this->request->getPost('origin_id'), $this->request->getPost('destination_id'), $this->request->getPost('schedule'), $this->request->getPost('capacity'), $this->request->getPost('duration'), $this->request->getPost('price'));
        return redirect()->to('/flight');
    }

    public function deleteFlight($id)
    {
        if (!session()->get('log')) {
            return $this->failUnauthorized('Not authorized.');
        }
        $model = model(Flight::class);
        $model->deleteFlight($id);
        return redirect()->to('/flight');
    }
}