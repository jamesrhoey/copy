<?php
$host = "localhost";
$username = "root";
$password = "";  // Use the correct password if you have one
$database = "employee_service";  // Your database name
$socket = "/data/data/com.termux/files/usr/var/run/mysqld.sock";  // Correct socket path

// Create connection
$conn = new mysqli($host, $username, $password, $database, null, $socket);

// Check connection
if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Database connection failed: " . $conn->connect_error]));
}
?>
