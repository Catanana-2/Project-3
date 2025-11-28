<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project_1";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Database verbinding mislukt: " . $conn->connect_error);
}

if (isset($_GET['code'], $_GET['email'])) {
    $code = $_GET['code'];
    $email = $_GET['email'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND verification_code = ?");
    $stmt->bind_param("ss", $email, $code);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $update = $conn->prepare("UPDATE users SET is_verified = 1, verification_code='' WHERE email = ?");
        $update->bind_param("s", $email);
        $update->execute();

        echo "<h2>Je account is succesvol geverifieerd!</h2>";
        echo "<p>Je kunt nu <a href='inlog.html'>inloggen</a> op FreshChoice.</p>";
    } else {
        echo "<h2>Verificatie mislukt!</h2>";
        echo "<p>Ongeldige link of het account is al geverifieerd.</p>";
    }

} else {
    echo "<h2>Verificatie mislukt!</h2>";
    echo "<p>Ongeldige aanvraag.</p>";
}

$conn->close();
?>