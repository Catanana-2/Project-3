<?php
session_start();

if(!isset($_SESSION['email'])) {
    header("Location: inlog.html");
    exit;
}

$first_name = $_SESSION['first_name'];
$email = $_SESSION['email'];
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profiel - FreshChoice</title>
    <link rel="stylesheet" href="static/style.css">
</head>
<body>
<header>
    <h1>Welkom, <?= htmlspecialchars($first_name) ?>!</h1>
</header>

<main>
    <p>E-mail: <?= htmlspecialchars($email) ?></p>
    <p><a href="logout.php">Uitloggen</a></p>
</main>
</body>
</html>