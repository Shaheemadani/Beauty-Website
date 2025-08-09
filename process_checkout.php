<?php
session_start();
$conn = new mysqli("localhost", "root", "", "Beauty_Website");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if user is logged in and cart is not empty
if (!isset($_SESSION['username']) || !isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<script>alert('Please login and add items to cart first.'); window.location.href='login.php';</script>";
    exit();
}

// Get form data
$fullname = $_POST['fullname'];
$address = $_POST['address'];
$payment_method = $_POST['payment_method'];
$username = $_SESSION['username'];

$total = 0;
foreach ($_SESSION['cart'] as $item) {
    $total += $item['price'] * $item['quantity'];
}

// Insert into orders table
$stmt = $conn->prepare("INSERT INTO orders (customer_username, total_amount, payment_method, shipping_address) VALUES (?, ?, ?, ?)");
$stmt->bind_param("sdss", $username, $total, $payment_method, $address);
$stmt->execute();
$order_id = $stmt->insert_id;

// Insert each cart item into order_items table
foreach ($_SESSION['cart'] as $item) {
    $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_name, product_price, quantity) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isdi", $order_id, $item['name'], $item['price'], $item['quantity']);
    $stmt->execute();
}

// Clear cart session
unset($_SESSION['cart']);

// Redirect to thank you page
header("Location: thank_you.php");
exit();
?>
