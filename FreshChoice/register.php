<?php

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

   
    header("Location: index.html");
    exit;
}
?>
