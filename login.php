<?php
require_once __DIR__ . '/assets/functions.php';
session_start();

$error = $_SESSION['login_error'] ?? '';
unset($_SESSION['login_error']);

if (isset($_POST['submit'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($user = login($username, $password)) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header('Location: dashboard.php');
        exit();
    }

    $_SESSION['login_error'] = 'Uppgifterna du skrev är fel.';
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Document</title>
</head>
<body>
<?php if ($error !== ''): ?>
<p><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
<?php endif; ?>
<form action="" method="post">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required>
    <br>
    <label for="password">Password:</label>
    <input type="password" name="password" id="password" required>
    <br>
    <input type="submit" name="submit" value="Login">
</form>

<p>Don't have an account? <a href="register.php">Register here</a>.</p>
</body>
</html>