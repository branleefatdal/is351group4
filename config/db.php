<?php
$host = "localhost";
$dbname = "ecommerce_secure";
$user = "root";
$pass = "";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>