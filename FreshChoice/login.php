<?php
session_start();

$servername = "p-studmysql02.fontysict.net";
$dbname = "i579631_test1";
$username_db = "i579631_test1";
$password_db = "nq7ZadSaD4Qjtw8fKBm";

// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "project_1";

// Loginbeperkingen
$max_attempts = 5;
$lockout_seconds = 120;

// Forceer arrays voor pogingen en lockouts
if (!isset($_SESSION['wrong_attempts']) || !is_array($_SESSION['wrong_attempts'])) {
    $_SESSION['wrong_attempts'] = [];
}
if (!isset($_SESSION['lockout_time']) || !is_array($_SESSION['lockout_time'])) {
    $_SESSION['lockout_time'] = [];
}

// 1. Verbind met de database
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Database verbinding mislukt: " . $conn->connect_error);
}

// 2. Verwerk login formulier
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Check of de gebruiker tijdelijk geblokkeerd is
    if (isset($_SESSION['lockout_time'][$username]) && time() < $_SESSION['lockout_time'][$username]) {
        $remaining = $_SESSION['lockout_time'][$username] - time();
        header("Location: inlog.html?error=" . urlencode("Je bent tijdelijk geblokkeerd!") . "&lockout=$remaining");
        exit;
    }

    // Haal gebruiker uit de database
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Wachtwoord verifiëren
        if (password_verify($password, $user['password'])) {
            // Correct ingelogd
            $_SESSION['wrong_attempts'][$username] = 0;
            $_SESSION['lockout_time'][$username] = 0;

            $_SESSION['username'] = $user['username'];
            $_SESSION['first_name'] = $user['first_name'];

            header("Location: index.html");
            exit;
        } else {
            // Fout wachtwoord
            if (!isset($_SESSION['wrong_attempts'][$username])) {
                $_SESSION['wrong_attempts'][$username] = 0;
            }
            $_SESSION['wrong_attempts'][$username]++;

            if ($_SESSION['wrong_attempts'][$username] >= $max_attempts) {
                $_SESSION['lockout_time'][$username] = time() + $lockout_seconds;
                $remaining = $lockout_seconds;
                header("Location: inlog.html?error=" . urlencode("Te vaak fout ingelogd!") . "&lockout=$remaining");
                exit;
            } else {
                $remaining_attempts = $max_attempts - $_SESSION['wrong_attempts'][$username];
                header("Location: inlog.html?error=" . urlencode("Fout wachtwoord! Nog $remaining_attempts pogingen."));
                exit;
            }
        }
    } else {
        // Gebruiker bestaat niet
        header("Location: inlog.html?error=" . urlencode("Gebruiker niet gevonden!"));
        exit;
    }
}

$conn->close();
?>