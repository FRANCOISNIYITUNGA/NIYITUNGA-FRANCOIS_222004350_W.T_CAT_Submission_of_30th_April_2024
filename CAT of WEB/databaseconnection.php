<?php
// Connection details
$host = "localhost";
$user = "222004350";
$pass = "222004350";
$database = "smms";

// Creating connection
$connection = new mysqli($host, $user, $pass, $database);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}
?>