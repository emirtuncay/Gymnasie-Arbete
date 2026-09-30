<?php
$host = "localhost";
$dbname = "gym_tracker";
$username = "admin";   
$password = "admin";     

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Anslutningen misslyckades: " . $conn->connect_error);
}