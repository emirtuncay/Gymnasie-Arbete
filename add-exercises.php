<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/assets/auth-check.php';
require_once __DIR__ . '/assets/functions.php';

$workoutId = $_GET['workout_id'] ?? $_POST['workout_id'] ?? null;

if (!$workoutId) {
    die("Inget pass valt.");
}

if (!userOwnsWorkout($workoutId, $_SESSION['user_id'])) {
    http_response_code(403);
    die("Du har inte tillgång till det här passet.");
}

$error = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $exerciseId = $_POST['exercise_id'];
    $weights = $_POST['weight'];
    $reps = $_POST['reps'];

    $valid = true;
    foreach ($weights as $i => $weight) {
        if (
            !is_numeric($weight) || $weight < 0 || $weight > 999.99
            || !is_numeric($reps[$i]) || $reps[$i] < 1 || $reps[$i] > 1000
        ) {
            $valid = false;
        }
    }

    if (!$valid) {
        $error = 'Ogiltiga värden. Vikten ska vara mellan 0 och 999,99 kg och reps minst 1.';
    } else {
        $weId = addExerciseToWorkout($workoutId, $exerciseId);

        foreach ($weights as $i => $weight) {
            $setNumber = $i + 1;
            addSet($weId, $setNumber, $weight, $reps[$i]);
        }
    }
}

$exercises = getAllExercises();
?>
<!DOCTYPE html>
<html lang="sv">

<head>
    <meta charset="UTF-8">
    <title>Lägg till övningar</title>
</head>

<body>
    <h1>Lägg till övning i passet</h1>

    <?php if ($error !== ''): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form method="POST" action="add-exercises.php">
        <input type="hidden" name="workout_id" value="<?php echo htmlspecialchars($workoutId); ?>">

        <label for="exercise_id">Övning:</label>
        <select name="exercise_id" id="exercise_id" required>
            <?php foreach ($exercises as $ex): ?>
                <option value="<?php echo $ex['id']; ?>"><?php echo htmlspecialchars($ex['name']); ?></option>
            <?php endforeach; ?>
        </select>
        <br><br>

        <div id="sets-container">
            <div class="set-row">
                <label>Set 1 — Vikt (kg):</label>
                <input type="number" step="0.5" name="weight[]" required>
                <label>Reps:</label>
                <input type="number" name="reps[]" required>
            </div>
        </div>

        <button type="button" onclick="addSetRow()">+ Lägg till set</button>
        <br><br>

        <button type="submit">Spara övning</button>
    </form>

    <br>
    <a href="workout-detail.php?workout_id=<?php echo htmlspecialchars($workoutId); ?>">Klar, visa passet</a>

    <script>
        let setCount = 1;

        function addSetRow() {
            setCount++;
            const container = document.getElementById('sets-container');
            const div = document.createElement('div');
            div.className = 'set-row';
            div.innerHTML = `
                <label>Set ${setCount} — Vikt (kg):</label>
                <input type="number" step="0.5" name="weight[]" required>
                <label>Reps:</label>
                <input type="number" name="reps[]" required>
            `;
            container.appendChild(div);
        }
    </script>
</body>

</html>