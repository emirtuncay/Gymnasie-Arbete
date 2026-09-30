<?php
require_once __DIR__ . '/../config/db.php';

function addUser($username, $email, $password) {
    global $conn;

    // Kolla om username eller email redan finns
    $checkSql = "SELECT id FROM users WHERE username = :username OR email = :email";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->execute([':username' => $username, ':email' => $email]);

    if ($checkStmt->fetch()) {
        return 'duplicate'; // redan upptaget
    }

    $sql = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
    $stmt = $conn->prepare($sql);

    return $stmt->execute([
        ':username' => $username,
        ':email' => $email,
        ':password' => password_hash($password, PASSWORD_DEFAULT)
    ]);
}

function login($username, $password) {
    global $conn;

    $sql = "SELECT id, username, password FROM users WHERE username = :username";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        return $user;
    }

    return false;
}