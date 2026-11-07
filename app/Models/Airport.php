<?php
namespace App\Models;
use CodeIgniter\Model;

class Airport extends Model{
    public function addAirport($iata, $name, $city, $country)
    {
        $db = \Config\Database::connect();
        $query = $db->query('INSERT INTO airport (iata, name, city, country_id) VALUES (?, ?, ?, ?)', [$iata, $name, $city, $country]);
        return $query;
    }

    public function getAirport()
    {
        $db = \Config\Database::connect();
        $query = $db->query('SELECT * FROM airport');
        return $query->getResult();
    }

    public function getSpecificAirport($iata)
    {
        $db = \Config\Database::connect();
        $query = $db->query('SELECT * FROM airport WHERE iata = ?', [$iata]);
        return $query->getResult();
    }

    public function editAirport($iata, $name, $city, $country)
    {
        $db = \Config\Database::connect();
        $query = $db->query('UPDATE airport SET name = ?, city = ?, country_id = ? WHERE iata = ?', [$name, $city, $country, $iata]);
        return $query;
    }

    public function deleteAirport($iata)
    {
        $db = \Config\Database::connect();
        $query = $db->query('DELETE FROM airport WHERE iata = ?', [$iata]);
        return $query;
    }
}