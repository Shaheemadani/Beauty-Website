<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Beauty_Website";

// Connect to MySQL
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Get products
$sql = "SELECT * FROM featured_products";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  echo '<div class="product-grid">';
  while($row = $result->fetch_assoc()) {
    echo '<div class="product-card">';
    echo '<img src="' . $row["image_path"] . '" alt="' . $row["product_name"] . '">';
    echo '<h3>' . $row["product_name"] . '</h3>';
    echo '</div>';
  }
  echo '</div>';
} else {
  echo "No products found.";
}
$conn->close();

?>