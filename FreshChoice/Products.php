<?php

// $servername = "p-studmysql02.fontysict.net"; 
// $username = "i579631_test1"; 
// $password = "nq7ZadSaD4Qjtw8fKBmU"; 
// $dbname = "i579631_test1";

$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "project_1";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql    = "SELECT * FROM products";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    echo json_encode($result->fetch_all(MYSQLI_ASSOC));
}

$conn->close();
?>