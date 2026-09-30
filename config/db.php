<?php
$host = "localhost";
$dbname = "gym_tracker";
$username = "admin";
$password = "admin";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Anslutningen misslyckades: " . $e->getMessage());
}