<?php
namespace App\Models;
use CodeIgniter\Model;
class BookingAuth extends Model{
    function getDataAuthentication($id, $password){
        $db = \Config\Database::connect();
        // $id = md5($id);
        // $password = md5($password);
        $query = $db->query('SELECT count(*) FROM employee WHERE id = ? AND password = ?', [$id, $password]);
        return $query->getRow()->count;
    }
}