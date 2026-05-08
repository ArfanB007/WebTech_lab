<?php
$host = "localhost";
$user = "root";
$password = "";
$dbName = "hospital_management_db";

$conn = mysqli_connect($host, $user, $password, $dbName);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>