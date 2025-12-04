<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// $servername = "p-studmysql02.fontysict.net"; 
// $username = "i579631_test1"; 
// $password = "nq7ZadSaD4Qjtw8fKBmU"; 
// $dbname = "i579631_test1";

$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "project_1";

$ProductID = $_POST['ProductID'] ?? null;
$Checked = $_POST['Checked'] ?? null;

if ($ProductID === null) {
    die(json_encode(["success" => false, "error" => "ProductID missing"]));
}

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["success" => false, "error" => $conn->connect_error]));
}

if ($Checked == 1) {
    $stmt = $conn->prepare("
        INSERT INTO shoppinglistitems (ItemID, ListID, ProductID, Hoeveelheid, Afgevinkt)
        VALUES (NULL, 1, ?, 1, 0)
    ");
    $stmt->bind_param("i", $ProductID);
}

else if ($Checked == 0) {
    $stmt = $conn->prepare("
        DELETE FROM shoppinglistitems
        WHERE ProductID = ? AND ListID = 1
    ");
    $stmt->bind_param("i", $ProductID);
}

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "error" => $stmt->error]);
}

$stmt->close();
$conn->close();
