<?php

namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;
use App\Models\Airport;
use App\Models\Countries;

class AirportController extends ResourceController
{
    public function addAirportPage()
    {
        if (!session()->get('log')) {
            return redirect()->to('/login');
        }
        $model = model(Airport::class);
        $countryModel = model(Countries::class);
        $countries = $countryModel->getCountries();
        return view('navbar').view('add_airport', ['countries' => $countries]);
    }

    public function add()
    {
        if (!session()->get('log')) {
            return $this->failUnauthorized('Not authorized.');
        }
        $model = model(Airport::class);
        
        $iata = $this->request->getVar('iata');
        $name = $this->request->getVar('name');
        $city = $this->request->getVar('city');
        $country = $this->request->getVar('country');

        $result = $model->addAirport($iata, $name, $city, $country);
        
        if ($result) {
            $data = [
                'message' => 'success',
                'airport' => $result
            ];
        } else {
            $data = [
                'message' => 'failed',
                'airport' => []
            ];
        }
        
        return $this->respond($data);
    }

    public function viewAirportPage()
    {
        if (!session()->get('log')) {
            return redirect()->to('/login');
        }
        $airportModel = model(Airport::class);
        $airports = $airportModel->getAirport();

        $countryModel = model(Countries::class);
        $countries = $countryModel->getCountries();

        return view('navbar').view('view_airport', ['airports' => $airports, 'countries' => $countries]);
    }


    public function fetchAirport($iata)
    {
        $model = model(Airport::class);
        $airport = $model->getSpecificAirport($iata);
        return $this->respond($airport);
    }

    public function editAirport($iata)
    {
        if (!session()->get('log')) {
            return $this->failUnauthorized('Not authorized.');
        }
        $airportModel = model(Airport::class);

        $country_id = $this->request->getVar('country_id');
        $name = $this->request->getVar('name');
        $city = $this->request->getVar('city');

        $airportModel->editAirport($iata, $name, $city, $country_id);
    }

    public function deleteAirport($iata)
    {
        if (!session()->get('log')) {
            return $this->failUnauthorized('Not authorized.');
        }
        $airportModel = model(Airport::class);
        $airportModel->deleteAirport($iata);
    }
}