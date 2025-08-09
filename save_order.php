<?php
session_start();
include 'db.php';

$session_id = session_id();
$username = isset($_SESSION['username']) ? $_SESSION['username'] : null;

// 1. Get Data from Checkout Form
$fullName = $_POST['fullName'];
$city = $_POST['city'];
$district = $_POST['district'];
$street = $_POST['street'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$paymentMethod = $_POST['paymentMethod'];

// ✅ 2. Fetch Cart Items and calculate totalAmount
if ($username) {
    $cart_stmt = $conn->prepare("SELECT * FROM cart WHERE username = ?");
    $cart_stmt->bind_param("s", $username);
} else {
    $cart_stmt = $conn->prepare("SELECT * FROM cart_items WHERE session_id = ?");
    $cart_stmt->bind_param("s", $session_id);
}
$cart_stmt->execute();
$cart_result = $cart_stmt->get_result();

$totalAmount = 0;
$cart_items = [];

while ($item = $cart_result->fetch_assoc()) {
    $quantity = $item['quantity'];
    $price = $item['price'];
    $totalAmount += $quantity * $price;

    // Store for later use
    $cart_items[] = $item;
}

// ✅ 3. Insert into 'orders' Table with correct totalAmount
$order_sql = $conn->prepare("INSERT INTO orders 
    (username, full_name, city, district, street, phone, email, payment_method, total_amount)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

$order_sql->bind_param("ssssssssd", $username, $fullName, $city, $district, $street, $phone, $email, $paymentMethod, $totalAmount);

if ($order_sql->execute()) {
    $order_id = $conn->insert_id;

    // ✅ 4. Save order_items and sold_products using cart_items
    foreach ($cart_items as $item) {
        $productName = $item['name'];
        $quantity = $item['quantity'];
        $price = $item['price'];

        $item_stmt = $conn->prepare("INSERT INTO order_items (order_id, product_name, quantity, price) VALUES (?, ?, ?, ?)");
        $item_stmt->bind_param("isid", $order_id, $productName, $quantity, $price);
        $item_stmt->execute();

        $sold_stmt = $conn->prepare("INSERT INTO sold_products (product_name, quantity, price) VALUES (?, ?, ?)");
        $sold_stmt->bind_param("sid", $productName, $quantity, $price);
        $sold_stmt->execute();
    }

    // ✅ 5. Clear the Cart
    if ($username) {
        $clear_stmt = $conn->prepare("DELETE FROM cart WHERE username = ?");
        $clear_stmt->bind_param("s", $username);
    } else {
        $clear_stmt = $conn->prepare("DELETE FROM cart_items WHERE session_id = ?");
        $clear_stmt->bind_param("s", $session_id);
    }
    $clear_stmt->execute();

    // ✅ 6. Redirect to Thank You Page
    header("Location: thankyou.php");
    exit();
} else {
    echo "Failed to place order. Please try again.";
}
?>