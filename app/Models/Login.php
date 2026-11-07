<?php
namespace App\Models;
use CodeIgniter\Model;
class Login extends Model{
    /**
     * Find employee by email and return the full row for password_verify().
     * Returns null if not found.
     */
    public function findByEmail($email)
    {
        $db = \Config\Database::connect();
        $query = $db->query("SELECT * FROM employee WHERE email = ?", [$email]);
        return $query->getRow();
    }
}