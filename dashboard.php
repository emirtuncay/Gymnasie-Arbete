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

    <?php $workouts = getWorkoutsForUser($_SESSION['user_id']); ?>

    <?php if (empty($workouts)): ?>
        <p>Inga pass loggade än.</p>
    <?php else: ?>
        <ul>
            <?php foreach ($workouts as $w): ?>
                <li>
                    <?php echo htmlspecialchars($w['date']); ?> — <?php echo htmlspecialchars($w['name']); ?>
                    <a href="workout-detail.php?workout_id=<?php echo (int)$w['id']; ?>">Visa</a>
                    <form method="POST" action="delete-workout.php" style="display:inline" onsubmit="return confirm('Ta bort passet?');">
                        <input type="hidden" name="workout_id" value="<?php echo (int)$w['id']; ?>">
                        <button type="submit">Ta bort</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    <br>
    <a href="progress.php">Se progression</a>
</body>

</html>