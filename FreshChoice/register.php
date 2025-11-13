<?php
if(isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirmPassword'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $city = $_POST['city'];
    $adress = $_POST['adress'];
    $zip_code = $_POST['zip_code'];

}
?>

<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $hash = password_hash($password, PASSWORD_BCRYPT);

    $file = __DIR__ . '/users.json';

    $users = [];
    if (file_exists($file)) {
        $users = json_decode(file_get_contents($file), true);
    
    }

    $users[$username] = ['password_hash' => $hash];

    file_put_contents($file, json_encode($users, JSON_PRETTY_PRINT));

    echo "Account aangemaakt voor $username. Wachtwoord is veilig gehasht";

}
?>