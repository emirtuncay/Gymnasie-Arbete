<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once __DIR__ . '/assets/auth-check.php';
require_once __DIR__ . '/assets/functions.php';

$error = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $date = $_POST['date'];
    $name = $_POST['name'];
    $userId = $_SESSION['user_id'];

    $workoutId = createWorkout($userId, $date, $name);

    if ($workoutId) {
        header('Location: add-exercises.php?workout_id=' . $workoutId);
        exit();
    } else {
        $error = 'Något gick fel, försök igen.';
    }
}
?>
<!DOCTYPE html>
<html lang="sv">

<head>
    <meta charset="UTF-8">
    <title>Logga nytt pass</title>
</head>

<body>
    <h1>Logga nytt pass</h1>

    <?php if ($error !== ''): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form method="POST" action="log-workout.php">
        <label for="date">Datum:</label>
        <input type="date" name="date" id="date" required>
        <br>
        <label for="name">Passnamn:</label>
        <input type="text" name="name" id="name" placeholder="t.ex. Push day" required>
        <br>
        <button type="submit">Skapa pass</button>
    </form>

    <a href="dashboard.php">Tillbaka</a>
</body>

</html>