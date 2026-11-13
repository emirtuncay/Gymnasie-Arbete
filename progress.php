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
    <form method="GET" action="progress.php">
        <label for="exercise_id">Övning:</label>
        <select name="exercise_id" id="exercise_id" required>
            <?php foreach ($exercises as $ex): ?>
                <option value="<?php echo (int)$ex['id']; ?>"
                    <?php if ($ex['id'] == $selectedId) echo 'selected'; ?>>
                    <?php echo htmlspecialchars($ex['name']); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Visa</button>
    </form>

    <?php if ($selectedId): ?>
        <?php if (empty($progress)): ?>
            <p>Inga loggade pass för den här övningen än.</p>
        <?php else: ?>
            <table border="1" cellpadding="5">
                <tr>
                    <th>Datum</th>
                    <th>Tyngsta vikt (kg)</th>
                    <th>Total volym (kg)</th>
                </tr>
                <?php foreach ($progress as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['date']); ?></td>
                        <td><?php echo htmlspecialchars($row['top_weight']); ?></td>
                        <td><?php echo htmlspecialchars($row['volume']); ?></td>
                    </tr>
                    <canvas id="progressChart" style="max-width: 700px;"></canvas>

                    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>

                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    <?php endif; ?>

    <br>


    <a href="dashboard.php">Tillbaka till dashboard</a>
</body>

</html>