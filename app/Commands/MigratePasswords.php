<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

/**
 * One-time command to migrate MD5 passwords to bcrypt.
 *
 * Usage:
 *   php spark migrate:passwords <plaintext_password> [<employee_email>]
 *
 * If you know each admin's original plaintext password, run this once per user.
 * The command will re-hash the password securely.
 *
 * Example:
 *   php spark migrate:passwords "admin123" "admin@onlyflights.18s"
 */
class MigratePasswords extends BaseCommand
{
    protected $group       = 'Security';
    protected $name        = 'migrate:passwords';
    protected $description = 'Re-hash MD5 passwords to bcrypt for all or a specific employee.';
    protected $usage       = 'migrate:passwords <plaintext_password> [email]';
    protected $arguments   = [
        'plaintext_password' => 'The known plaintext password to re-hash.',
        'email'              => '(Optional) Target a specific employee by email.',
    ];

    public function run(array $params)
    {
        $plaintext = $params[0] ?? null;
        $email     = $params[1] ?? null;

        if (empty($plaintext)) {
            CLI::error('Please provide the plaintext password as the first argument.');
            return;
        }

        $db = \Config\Database::connect();
        $md5Hash = md5($plaintext);

        if ($email) {
            $query = $db->query("SELECT id, email, password FROM employee WHERE email = ?", [$email]);
        } else {
            $query = $db->query("SELECT id, email, password FROM employee");
        }

        $employees = $query->getResult();

        if (empty($employees)) {
            CLI::error('No employees found matching the criteria.');
            return;
        }

        $migrated = 0;
        foreach ($employees as $emp) {
            // Only migrate if the stored password matches the provided MD5
            if ($emp->password === $md5Hash) {
                $bcryptHash = password_hash($plaintext, PASSWORD_BCRYPT);
                $db->query("UPDATE employee SET password = ? WHERE id = ?", [$bcryptHash, $emp->id]);
                CLI::write("✔ Migrated: {$emp->email}", 'green');
                $migrated++;
            } else {
                CLI::write("⚠ Skipped (MD5 mismatch): {$emp->email}", 'yellow');
            }
        }

        CLI::write("Done. {$migrated} password(s) migrated.", 'green');
    }
}

