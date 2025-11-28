<?php

$servername = "p-studmysql02.fontysict.net";
$dbname = "i579631_test1";
$username = "i579631_test1";
$password = "nq7ZadSaD4Qjtw8fKBm";

// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "project_1";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Database verbinding mislukt: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{

    $email   = htmlspecialchars($_POST['email']);
    $password   = $_POST['password']; 
    $confirm    = $_POST['confirmPassword'];
    $first_name = htmlspecialchars($_POST['first_name']);
    $last_name  = htmlspecialchars($_POST['last_name']);
    $city       = htmlspecialchars($_POST['city']);
    $adress     = htmlspecialchars($_POST['adress']);
    $zip_code   = htmlspecialchars($_POST['zip_code']);


    
    if ($password !== $confirm) {
        $error = urlencode("De wachtwoorden komen niet overeen!");
        header("Location: register2.html?error=$error");
        exit;
    }


    $verification_code = bin2hex(random_bytes(16));
  
    $hash = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (email, password, first_name, last_name, city, adress, zip_code, is_verified, verification_code)
            VALUES (?, ?, ?, ?, ?, ?, ?, 0, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssss", $email, $hash, $first_name, $last_name, $city, $adress, $zip_code, $verification_code);

    if ($stmt->execute()) 
    {
        $verify_link = "http://i579631.hera.fontysict.net/verify.php?code=$verification_code&email=" . urlencode($email);
        $subject = "Bevestig je FreshChoice account!";
        $message = "Hallo $first_name, \n\nBedankt voor je registratie bij FreshChoice!\n\nKlik op de volgende link om je account te bevestigen:\n$verify_link\nGroeten,\nHet FreshChoice Team";
        $headers = "From: no-reply@FreshChoice.nl\r\n";

        mail($email, $subject, $message, $headers);

        header("Location: inlog.html?verify=1");
        exit;

    } else {
        $error = urlencode("Fout bij opslaan in database: " . $conn->error);
        header("Location: register2.html?error=$error");
        exit;
    }




   
    header("Location: index.html");
    exit;
}

$conn->close();
?>
