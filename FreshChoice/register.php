<?php

$servername = "p-studmysql02.fontysict.net";
$dbname = "i579631_test1";
$username = "i579631_test1";
$password = "nq7ZadSaD4Qjtw8fKBm";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Database verbinding mislukt: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{

    $username   = htmlspecialchars($_POST['username']);
    $password   = $_POST['password']; 
    $confirm    = $_POST['confirmPassword'];
    $first_name = htmlspecialchars($_POST['first_name']);
    $last_name  = htmlspecialchars($_POST['last_name']);
    $city       = htmlspecialchars($_POST['city']);
    $adress     = htmlspecialchars($_POST['adress']);
    $zip_code   = htmlspecialchars($_POST['zip_code']);
    $captcha    = strtolower(trim($_POST['captcha']));

    if ($captcha !== 'kat') {
        $error = urlencode("De naam van het dier is fout!! Probeer het opnieuw");
        header("Location: register2.html?error=$error");
        exit;
    }

    
    if ($password !== $confirm) {
        $error = urlencode("De wachtwoorden komen niet overeen!");
        header("Location: register2.html?error=$error");
        exit;
    }



  
    $hash = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, password, first_name, last_name, city, adress, zip_code);
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $username, $hash, $first_name, $last_name, $city, $adress, $zip_code);

    if ($stmt->execute()) 
    {
        header("Location: index.html?registered=1");
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
