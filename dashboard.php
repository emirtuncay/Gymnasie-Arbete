<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/assets/auth-check.php';
require_once __DIR__ . '/assets/functions.php';
?>
<!DOCTYPE html>
<html lang="sv">

<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>

<body>
    <h1>Välkommen, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
    <p>Du är inloggad.</p>
    <a href="logout.php">Logga ut</a>
    <a href="log-workout.php">Logga nytt pass</a>

    <h2>Dina pass</h2>
    <a href="log-workout.php">+ Logga nytt pass</a>

    <?php
    $workouts = getWorkoutsForUser($_SESSION['user_id']);

    if (empty($workouts)) {
        echo "<p>Inga pass loggade än.</p>";
    } else {
        echo "<ul>";
        foreach ($workouts as $w) {
            echo "<li>";
            echo htmlspecialchars($w['date']) . " — " . htmlspecialchars($w['name']);
            echo " <a href='workout-detail.php?workout_id=" . $w['id'] . "'>Visa</a>";
            echo "</li>";
        }
        echo "</ul>";
    }
    ?>
</body>

</html>