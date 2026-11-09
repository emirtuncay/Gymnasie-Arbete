<?php
require_once __DIR__ . '/assets/auth-check.php';
require_once __DIR__ . '/assets/functions.php';

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header('Location: dashboard.php');
    exit();
}

$workoutId = $_POST['workout_id'] ?? null;

if ($workoutId) {
    deleteWorkout($workoutId, $_SESSION['user_id']);
}

header('Location: dashboard.php');
exit();
