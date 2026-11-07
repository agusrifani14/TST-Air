<?php
namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;

class FinanceController extends ResourceController{
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

    public function viewDashboard(){
        $response_finance = $this->getData('http://localhost:3000/bookingAPI');
        $decoded = $response_finance ? json_decode($response_finance, true) : null;

        if (!$decoded || !isset($decoded['sales'])) {
            $bookingModel = model(\App\Models\Booking::class);
            $localSales = $bookingModel->getLocalSales();
            $decoded = [
                'message' => 'success (Local Database Fallback)',
                'sales' => $localSales
            ];
        }
        return view('navbar').view('finance_dashboard', ['response_finance' => $decoded]);
    }
}
