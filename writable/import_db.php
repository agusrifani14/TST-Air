<?php
$host = '127.0.0.1';
$port = 3305;
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, '', $port);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database
if ($conn->query("CREATE DATABASE IF NOT EXISTS onlyflights") === TRUE) {
    echo "Database onlyflights created successfully\n";
} else {
    die("Error creating database: " . $conn->error);
}

$conn->select_db('onlyflights');

// Import sql file
$sqlFile = dirname(__DIR__) . '/onlyflights.sql';
if (!file_exists($sqlFile)) {
    die("SQL file not found at " . $sqlFile);
}

$sql = file_get_contents($sqlFile);

// Execute multi query
if ($conn->multi_query($sql)) {
    do {
        // Store first result set
        if ($result = $conn->store_result()) {
            $result->free();
        }
    } while ($conn->more_results() && $conn->next_result());
    echo "Database imported successfully\n";
} else {
    echo "Error importing database: " . $conn->error . "\n";
}

$conn->close();
