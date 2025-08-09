<?php
$servername = "localhost";
$username = "root";      // usually root in XAMPP
$password = "";          // usually empty in XAMPP
$dbname = "beauty_website";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>