<?php
session_start();
if (isset($_SESSION['email'])) {
    $first_name = $_SESSION['first_name'];
} else {
    $first_name = "null";
}
include("index.html");
?>
