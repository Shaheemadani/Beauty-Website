<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "Beauty_Website");

foreach ($_POST['quantity'] as $cartId => $qty) {
    $qty = max(1, intval($qty)); // prevent 0 or negative
    $conn->query("UPDATE cart SET quantity=$qty WHERE id=$cartId AND username='{$_SESSION['username']}'");
}

header("Location: cart.php");
exit();
?>