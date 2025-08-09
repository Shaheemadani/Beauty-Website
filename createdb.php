<?php
$conn = new mysqli("localhost", "root", "", "Beauty_Website");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>