<?php
session_start();

$max_attempts = 5;
$lockout_seconds = 120;

if (!isset($_SESSION['wrong_attempts'])) {
    $_SESSION['wrong_attempts'] = 0;
}
if (!isset($_SESSION['lockout_time'])) {
    $_SESSION['lockout_time'] = 0;
}

// 1. Check of de gebruiker momenteel geblokkeerd is
if (time() < $_SESSION['lockout_time']) {
    $remaining = $_SESSION['lockout_time'] - time();
    header("Location: inlog.html?error=" . urlencode("Je bent tijdelijk geblokkeerd!") . "&lockout=$remaining");
    exit;
}

// 2. Verwerk login formulier
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = htmlspecialchars($_POST['username']);
    $password = $_POST['password'];

    // tijdelijk hardcoded account
    $correct_user = "test";
    $correct_password = "1234";

    if ($username === $correct_user && $password === $correct_password) {
        $_SESSION['wrong_attempts'] = 0;
        $_SESSION['lockout_time'] = 0;
        header("Location: index.html");
        exit;
    } else {
        $_SESSION['wrong_attempts']++;

        if ($_SESSION['wrong_attempts'] >= $max_attempts) {
            $_SESSION['lockout_time'] = time() + $lockout_seconds;
            $remaining = $lockout_seconds;
            header("Location: inlog.html?error=" . urlencode("Te vaak fout ingelogd!") . "&lockout=$remaining");
            exit;
        } else {
            $remaining_attempts = $max_attempts - $_SESSION['wrong_attempts'];
            header("Location: inlog.html?error=" . urlencode("Fout wachtwoord! Nog $remaining_attempts pogingen."));
            exit;
        }
    }
}





header("Location: index.html");

?>