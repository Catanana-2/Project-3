<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $password = isset($_POST['password']) ? $_POST['password'] : '';

   
    $hash = password_hash($password, PASSWORD_BCRYPT);

  
    echo $hash;
}
?>


