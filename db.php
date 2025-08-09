<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "Beauty_Website"; // <- change to your real DB name

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>