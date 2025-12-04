<?php
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "project_1";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) die("Database verbinding mislukt: " . $conn->connect_error);

if (isset($_GET['code']) && isset($_GET['email'])) {
    $code = $_GET['code'];
    $email = $_GET['email'];

    $stmt = $conn->prepare("UPDATE users SET is_verified = 1 WHERE email = ? AND verification_code = ?");
    $stmt->bind_param("ss", $email, $code);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Account succesvol geverifieerd! Je kunt nu inloggen.<br>";
        echo "<a href='login.php'>Inloggen</a>";
    } else {
        echo "Verificatie mislukt. Controleer de link.";
    }
} else {
    echo "Ongeldige verificatiegegevens.";
}

$conn->close();
?>


