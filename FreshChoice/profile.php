<?php
session_start();

// Check of gebruiker ingelogd is
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}

// Uitloggen
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_destroy();
    header("Location: login.php");
    exit;
}

// Huidige gebruiker ophalen uit sessie
$first_name = $_SESSION['first_name'];
$last_name  = $_SESSION['last_name'] ?? '';
$email      = $_SESSION['email'];
?>

<!DOCTYPE html>
<html lang="nl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Profielpagina</title>
<link rel="stylesheet" href="static/style.css">
<style>
body {
    font-family: Arial, sans-serif;
    background-color: #f2f2f2;
    margin: 0;
    padding: 0;
}

header {
    background-color: #6FB23E;
    color: white;
    padding: 20px;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
}

header h1 {
    margin: 0 0 10px 0;
}

header .nav {
    display: flex;
    gap: 10px;
}

header .nav a {
    background-color: white;
    color: black;
    padding: 10px 15px;
    border-radius: 8px;
    font-weight: bold;
    text-decoration: none;
    transition: background-color 0.3s;
}

header .nav a:hover {
    background-color: darkgray;
}

main {
    max-width: 500px;
    margin: 40px auto;
    background-color: white;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    display: flex;
    flex-direction: column;
    gap: 15px;
}

main p {
    margin: 0;
    font-size: 16px;
}
</style>
</head>
<body>

<header>
    <h1>Welkom, <?= htmlspecialchars($first_name) ?>!</h1>
    <div class="nav">
        <a href="profile.php?action=logout">Uitloggen</a>
        <a href="index.html">Home</a>
    </div>
</header>

<main>
    <p><strong>E-mail:</strong> <?= htmlspecialchars($email) ?></p>
    <p><strong>First name:</strong> <?= htmlspecialchars($first_name) ?></p>
</main>

</body>
</html>

