<?php
namespace App\Models;
use CodeIgniter\Model;

class Countries extends Model{
    public function getCountries()
    {
        $db = \Config\Database::connect();
        $query = $db->query('SELECT * FROM countries');
        return $query->getResult();
    }
}