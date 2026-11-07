<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\Airport;

class AirportAPI extends ResourceController
{
    public function getAllAirport()
    {
        $model = model(Airport::class);
        $result = $model->getAirport();
        if ($result) {
            $data = [
                'message' => 'success',
                'airports' => $result
            ];
        } else {
            $data = [
                'message' => 'failed',
                'airports' => []
            ];
        }
        return $this->respond($data);
    }
}
