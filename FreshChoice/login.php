<?php
session_start();

$servername = "p-studmysql02.fontysict.net";
$dbname = "i579631_test1";
$username = "i579631_test1";
$password = "nq7ZadSaD4Qjtw8fKBm";

// DATABASE INSTELLINGEN
// $servername = "localhost";
// $username   = "root";
// $password   = "";
// $dbname     = "project_1";

// LOGIN BEVEILIGING
$max_attempts    = 5;     // totaalpogingen
$lockout_seconds = 120;   // blokkade tijd in seconden

// Zet default waarden als ze nog niet bestaan
if (!isset($_SESSION['wrong_attempts'])) $_SESSION['wrong_attempts'] = 0;
if (!isset($_SESSION['lockout_time'])) $_SESSION['lockout_time'] = 0;

// ========== LOCKOUT CHECK ==========
// zolang lockout actief is, geen nieuwe pogingen verwerken
if (time() < $_SESSION['lockout_time']) {
    $remaining = $_SESSION['lockout_time'] - time();
    header("Location: inlog.html?msg=" . urlencode("⚠️ Je bent tijdelijk geblokkeerd!") . "&lockout=$remaining");
    exit;
}

// VERBINDING MET DATABASE
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) die("Database verbinding mislukt: " . $conn->connect_error);

// VERWERK POST LOGIN
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // FETCH USER UIT DATABASE
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    $login_success = false;

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $login_success = true;
        }
    }

    if ($login_success) {
        // SUCCESS → reset pogingen en lockout
        $_SESSION['wrong_attempts'] = 0;
        $_SESSION['lockout_time']   = 0;
        $_SESSION['email']       = $user['email'];
        $_SESSION['first_name']     = $user['first_name'];

        header("Location: index.html");
        exit;
    } else {
        // FOUT → verhoog totaalpogingen
        $_SESSION['wrong_attempts']++;

        if ($_SESSION['wrong_attempts'] >= $max_attempts) {
            // MAX bereikt → blokkeer
            $_SESSION['lockout_time'] = time() + $lockout_seconds;
            $remaining = $lockout_seconds;
            $_SESSION['wrong_attempts'] = 0; // reset teller na lockout

            header("Location: inlog.html?msg=" . urlencode("⚠️ Te vaak fout ingelogd! Je bent $remaining seconden geblokkeerd.") . "&lockout=$remaining");
            exit;
        } else {
            $remaining_attempts = $max_attempts - $_SESSION['wrong_attempts'];
            $msg = $result->num_rows === 1 ? "Fout wachtwoord!" : "Gebruiker niet gevonden!";
            header("Location: inlog.html?msg=" . urlencode("$msg Pogingen over: $remaining_attempts"));
            exit;
        }
    }
}

$conn->close();
?>







