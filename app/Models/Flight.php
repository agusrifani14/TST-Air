<?php
namespace App\Models;
use CodeIgniter\Model;

class Flight extends Model{
    public function getFlights($origin, $destination, $date, $capacity)
{
    $db = \Config\Database::connect();

    $query = $db->query('SELECT * FROM flight WHERE origin_id = ? AND destination_id = ? AND DATE(schedule) = ?', [$origin, $destination, $date]);

    $row = $query->getRow();

    if ($row !== null) {
        $id = $row->id;

        $isEmpty = $db->query('SELECT COUNT(*) as count FROM booking WHERE flight_id = ?', [$id])->getRow()->count;

        if ($isEmpty < $capacity) {
            return $query->getResult();
        } else {
            return false;
        }
    } else {
        // Handle the case when no rows are returned
        return false;
    }
}


    public function getAllFlights()
    {
        $db = \Config\Database::connect();
        $query = $db->query('SELECT * FROM flight');
        return $query->getResult();
    }

    public function addFlight($flight_id, $origin_id, $destination_id, $schedule, $capacity, $duration, $price)
    {
        $db = \Config\Database::connect();

        $query = $db->query('INSERT INTO flight (id, origin_id, destination_id, schedule, capacity, duration, price) VALUES (?, ?, ?, ?, ?, ?, ?)', [$flight_id, $origin_id, $destination_id, $schedule, $capacity, $duration, $price]);

        return $query;
    }

    public function getFlight($id)
    {
        $db = \Config\Database::connect();

        $query = $db->query('SELECT * FROM flight WHERE id = ?', [$id]);

        return $query->getRow();
    }

    public function editFlight($id, $origin_id, $destination_id, $schedule, $capacity, $duration, $price)
    {
        $db = \Config\Database::connect();

        $query = $db->query('UPDATE flight SET origin_id = ?, destination_id = ?, schedule = ?, capacity = ?, duration = ?, price = ? WHERE id = ?', [$origin_id, $destination_id, $schedule, $capacity, $duration, $price, $id]);

        return $query;
    }

    public function deleteFlight($id)
    {
        $db = \Config\Database::connect();

        $query = $db->query('DELETE FROM flight WHERE id = ?', [$id]);

        return $query;
    }
}
