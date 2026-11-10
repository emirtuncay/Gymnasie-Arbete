<?php
require_once __DIR__ . '/assets/auth-check.php';
require_once __DIR__ . '/assets/functions.php';

$exercises = getAllExercises();
$selectedId = $_GET['exercise_id'] ?? null;
$progress = [];

if ($selectedId) {
    $progress = getExerciseProgress($_SESSION['user_id'], $selectedId);
}
?>
<!DOCTYPE html>
<html lang="sv">

<head>
    <meta charset="UTF-8">
    <title>Progression</title>
</head>

<body>
    <h1>Din progression</h1>
    <!-- kod att visa progressionen gör klart snart. -->


</body>

</html>