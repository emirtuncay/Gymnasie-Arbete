<?php
require_once __DIR__ . '/../config/db.php';

function addUser($username, $email, $password)
{
    global $conn;

    $checkSql = "SELECT id FROM users WHERE username = :username OR email = :email";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->execute([':username' => $username, ':email' => $email]);

    if ($checkStmt->fetch()) {
        return 'duplicate';
    }

    $sql = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
    $stmt = $conn->prepare($sql);

    return $stmt->execute([
        ':username' => $username,
        ':email' => $email,
        ':password' => password_hash($password, PASSWORD_DEFAULT)
    ]);
}

function login($username, $password)
{
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

function createWorkout($userId, $date, $name)
{
    global $conn;

    $sql = "INSERT INTO workouts (user_id, date, name) VALUES (:user_id, :date, :name)";
    $stmt = $conn->prepare($sql);

    $success = $stmt->execute([
        ':user_id' => $userId,
        ':date' => $date,
        ':name' => $name
    ]);

    if ($success) {
        return $conn->lastInsertId();
    }

    return false;
}

function getAllExercises()
{
    global $conn;
    $stmt = $conn->prepare("SELECT id, name FROM exercises ORDER BY name");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function addExerciseToWorkout($workoutId, $exerciseId)
{
    global $conn;
    $sql = "INSERT INTO workout_exercises (workout_id, exercise_id) VALUES (:workout_id, :exercise_id)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':workout_id' => $workoutId, ':exercise_id' => $exerciseId]);
    return $conn->lastInsertId(); // ger workout_exercise_id, behövs för sets
}

function addSet($workoutExerciseId, $setNumber, $weight, $reps)
{
    global $conn;
    $sql = "INSERT INTO sets (workout_exercise_id, set_number, weight, reps) 
            VALUES (:we_id, :set_number, :weight, :reps)";
    $stmt = $conn->prepare($sql);
    return $stmt->execute([
        ':we_id' => $workoutExerciseId,
        ':set_number' => $setNumber,
        ':weight' => $weight,
        ':reps' => $reps
    ]);
}

function getWorkoutDetails($workoutId)
{
    global $conn;

    $sql = "SELECT w.id, w.date, w.name FROM workouts w WHERE w.id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':id' => $workoutId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getExercisesForWorkout($workoutId)
{
    global $conn;

    $sql = "SELECT we.id AS we_id, e.name AS exercise_name
            FROM workout_exercises we
            JOIN exercises e ON we.exercise_id = e.id
            WHERE we.workout_id = :workout_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':workout_id' => $workoutId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getSetsForWorkoutExercise($weId)
{
    global $conn;

    $sql = "SELECT set_number, weight, reps FROM sets WHERE workout_exercise_id = :we_id ORDER BY set_number";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':we_id' => $weId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getWorkoutsForUser($userId)
{
    global $conn;

    $sql = "SELECT id, date, name FROM workouts WHERE user_id = :user_id ORDER BY date DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':user_id' => $userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function userOwnsWorkout($workoutId, $userId)
{
    global $conn;

    $sql = "SELECT id FROM workouts WHERE id = :id AND user_id = :user_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':id' => $workoutId, ':user_id' => $userId]);

    return $stmt->fetch() !== false;
}
