<?php

$password = 'pizza123';
$hash = password_hash($password, PASSWORD_BCRYPT);

echo $hash;

?>