<?php
session_start();

$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "project_1";

$max_attempts    = 5;
$lockout_seconds = 120;

if (!isset($_SESSION['wrong_attempts'])) $_SESSION['wrong_attempts'] = 0;
if (!isset($_SESSION['lockout_time'])) $_SESSION['lockout_time'] = 0;

// LOCKOUT CHECK
if (time() < $_SESSION['lockout_time']) {
    $remaining = $_SESSION['lockout_time'] - time();
    header("Location: inlog.html?msg=" . urlencode("⚠️ Je bent tijdelijk geblokkeerd!") . "&lockout=$remaining");
    exit;
}

// VERBINDING MET DATABASE
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) die("Database verbinding mislukt: " . $conn->connect_error);

$login_error = "";
$show_verify_button = false;
$verification_code = "";
$email_for_verify = "";

// Als er GET email/code is (van test link of na registratie)
if (isset($_GET['email'])) {
    $email_for_verify = $_GET['email'];
    $stmt = $conn->prepare("SELECT is_verified, verification_code FROM users WHERE email = ?");
    $stmt->bind_param("s", $email_for_verify);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 1) {
        $user_verify = $result->fetch_assoc();
        if ($user_verify['is_verified'] == 0) {
            $show_verify_button = true;
            $verification_code = $user_verify['verification_code'];
        }
    }
}

// POST LOGIN VERWERKING
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    $login_success = false;

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if ($user['is_verified'] == 0) {
            $login_error = "⚠️ Je moet eerst je account verifiëren via de knop hier rechts.";
            $show_verify_button = true;
            $verification_code = $user['verification_code'];
            $email_for_verify = $email;
        } elseif (password_verify($password, $user['password'])) {
            $login_success = true;
        }
    } else {
        $login_error = "Gebruiker niet gevonden!";
    }

    if ($login_success) {
        $_SESSION['wrong_attempts'] = 0;
        $_SESSION['lockout_time']   = 0;
        $_SESSION['email']          = $user['email'];
        $_SESSION['first_name']     = $user['first_name'];

        header("Location: index.html");
        exit;
    } else {
        $_SESSION['wrong_attempts']++;
        if ($_SESSION['wrong_attempts'] >= $max_attempts) {
            $_SESSION['lockout_time'] = time() + $lockout_seconds;
            $_SESSION['wrong_attempts'] = 0;
            $login_error = "⚠️ Te vaak fout ingelogd! Je bent $lockout_seconds seconden geblokkeerd.";
        } else {
            if (!$login_error) $login_error = "Fout wachtwoord! Pogingen over: " . ($max_attempts - $_SESSION['wrong_attempts']);
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="nl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login - FreshChoice</title>
<link rel="stylesheet" href="static/style.css">
<style>
    header {
        display: flex;
        flex-direction: column;
        background-color: #6FB23E;
    }
    .home a {
        display: flex;
        justify-content: flex-start;
        background-color: white; 
        color: black;
        padding: 10px;
        width: 70px;
        border-radius: 8px;
        font-weight: bold;
        transition: background-color 0.3s;
        text-align: center;
        text-decoration: none;
        margin-left: 10px;
    }
    .home a:hover { background-color: darkgray; }

    .verify-btn {
        display: inline-block;
        margin-top: 10px;
        padding: 10px 15px;
        background-color: #FFA500;
        color: white;
        text-decoration: none;
        border-radius: 8px;
        font-weight: bold;
    }
    .verify-btn:hover { background-color: darkorange; }
</style>
</head>
<body>
<header>
    <h1>FreshChoice</h1>
    <p>Log in om je account en boodschappenlijst te bekijken</p>
    <div class="home">
        <a href="index.html">Home</a>
    </div>
</header>

<main>
    <form method="POST" action="login.php">
        <h2>Login</h2>

        <input type="email" name="email" placeholder="E-mail" required>
        <input type="password" name="password" placeholder="Wachtwoord" required>

        <button type="submit">Inloggen</button>

        <?php if ($login_error) echo "<p style='color:red;'>$login_error</p>"; ?>

        <a href="register2.html">Nog geen account? Registreer hier!</a>
    </form>

    <?php if ($show_verify_button): ?>
        <a href="verify.php?code=<?= $verification_code ?>&email=<?= urlencode($email_for_verify) ?>" class="verify-btn">Verifieer je account</a>
    <?php endif; ?>
</main>
</body>
</html>


























