<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/assets/functions.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (addUser($username, $email, $password)) {
        header('Location: login.php');
        exit();
    } else {
        echo "Något gick fel vid registreringen.";
    }
}
?>

<form method="POST" action="register.php">
    <input type="text" name="username" placeholder="Användarnamn" required>
    <input type="email" name="email" placeholder="E-post" required>
    <input type="password" name="password" placeholder="Lösenord" required>
    <button type="submit">Registrera</button>
</form>