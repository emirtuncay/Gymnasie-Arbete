<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/assets/auth-check.php';
require_once __DIR__ . '/assets/functions.php';

$workoutId = $_GET['workout_id'] ?? null;

if (!$workoutId) {
    die("Inget pass valt.");
}

$workout = getWorkoutDetails($workoutId);
$exercises = getExercisesForWorkout($workoutId);
?>
<!DOCTYPE html>
<html lang="sv">

<head>
    <meta charset="UTF-8">
    <title>Pass: <?php echo htmlspecialchars($workout['name']); ?></title>
</head>

<body>
    <h1><?php echo htmlspecialchars($workout['name']); ?></h1>
    <p>Datum: <?php echo htmlspecialchars($workout['date']); ?></p>

    <?php foreach ($exercises as $ex): ?>
        <h3><?php echo htmlspecialchars($ex['exercise_name']); ?></h3>
        <table border="1" cellpadding="5">
            <tr>
                <th>Set</th>
                <th>Vikt (kg)</th>
                <th>Reps</th>
            </tr>
            <?php
            $sets = getSetsForWorkoutExercise($ex['we_id']);
            foreach ($sets as $set):
            ?>
                <tr>
                    <td><?php echo $set['set_number']; ?></td>
                    <td><?php echo $set['weight']; ?></td>
                    <td><?php echo $set['reps']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endforeach; ?>

    <br>
    <a href="dashboard.php">Tillbaka till dashboard</a>
</body>

</html>