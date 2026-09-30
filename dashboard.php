<?php
require_once __DIR__ . '/assets/auth-check.php';
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
</body>
</html>