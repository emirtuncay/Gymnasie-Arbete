<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/assets/functions.php';

$error = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $result = addUser($username, $email, $password);

    if ($result === true) {
        header('Location: login.php');
        exit();
    } elseif ($result === 'duplicate') {
        $error = 'Användarnamnet eller e-posten är redan registrerad.';
    } else {
        $error = 'Något gick fel, försök igen.';
    }
}
?>

<?php if ($error !== ''): ?>
    <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
<?php endif; ?>

<form method="POST" action="register.php">
    <input type="text" name="username" placeholder="Användarnamn" required>
    <input type="email" name="email" placeholder="E-post" required>
    <input type="password" name="password" placeholder="Lösenord" required>
    <button type="submit">Registrera</button>
</form>