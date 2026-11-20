<?php
ini_set('pcre.jit', '0');
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/assets/functions.php';
session_start();

$error = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'];
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'];

    if (trim($username) === '') {
        $error = 'Skriv ett användarnamn.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Skriv en giltig e-postadress.';
    } elseif (mb_strlen($password, 'UTF-8') < 8) {
        $error = 'Lösenordet måste vara minst 8 tecken långt.';
    } else {
        $result = addUser($username, $email, $password);

        if ($result === true) {
            $user = login($username, $password);

            if ($user) {
                session_regenerate_id(true);
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                header('Location: dashboard.php');
                exit();
            }

            $error = 'Kontot skapades, men du behöver logga in via länken nedan.';
        } elseif ($result === 'duplicate') {
            $error = 'Användarnamnet eller e-posten är redan registrerad.';
        } else {
            $error = 'Något gick fel, försök igen.';
        }
    }
}
?>

<?php if ($error !== ''): ?>
    <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
<?php endif; ?>

<form method="POST" action="register.php">
    <p>Har du redan ett konto? <a href="login.php">Logga in här</a>.</p>
    <input type="text" name="username" placeholder="Användarnamn" required>
    <input type="email" name="email" placeholder="E-post" required>
    <input type="password" name="password" placeholder="Lösenord" required>
    <button type="submit">Registrera</button>
</form>
