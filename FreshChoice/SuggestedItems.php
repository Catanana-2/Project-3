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

$stmt = $conn->prepare("SELECT * FROM orderitems WHERE UserID = ?");
$stmt->bind_param("i", $userId);
$userId = 1;
$stmt->execute();

$result = $stmt->get_result();
$orderItems = $result->fetch_all(MYSQLI_ASSOC);

foreach($orderItems as $item) {
    $productId = $item['ProductID'];

    $stmt2 = $conn->prepare("SELECT * FROM products WHERE ProductID = ?");
    $stmt2->bind_param("i", $productId);
    $stmt2->execute();

    $product = $stmt2->get_result()->fetch_assoc();

    $orderedproducts[] = $product;
}

$categories = array_unique(array_column($orderedproducts, 'Categorie'));

foreach($categories as $category) {
    $stmt3 = $conn->prepare("SELECT * FROM products WHERE Categorie = ? LIMIT 5");
    $stmt3->bind_param("s", $category);
    $stmt3->execute();

    $result3 = $stmt3->get_result();
    while ($row = $result3->fetch_assoc()) {
        $productsByCategory[$category][] = $row;
    }
}

echo json_encode($productsByCategory);

$conn->close();
?>