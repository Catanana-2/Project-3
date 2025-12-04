<?php
session_start();
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "project_1";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) die("Database verbinding mislukt");

$email = $_GET['email'] ?? '';
$email = trim($email);

$response = ['exists' => false];

if ($email !== '') {
    $stmt = $conn->prepare("SELECT is_verified FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if ($user['is_verified'] == 1) {
            $response['exists'] = true;
        }
    }
}

echo json_encode($response);
$conn->close();
?>
