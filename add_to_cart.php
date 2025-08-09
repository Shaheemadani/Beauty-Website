<?php
session_start();
$conn = new mysqli("localhost", "root", "", "Beauty_Website");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $price = floatval($_POST['price']);
    $quantity = intval($_POST['quantity']);
    $image = $_POST['image']; 

    $session_id = session_id();

    // Check if product already exists in cart
    $check = $conn->prepare("SELECT id, quantity FROM cart_items WHERE session_id = ? AND name = ?");
    $check->bind_param("ss", $session_id, $name);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        // Update quantity
        $row = $result->fetch_assoc();
        $newQty = $row['quantity'] + $quantity;
        $update = $conn->prepare("UPDATE cart_items SET quantity = ? WHERE id = ?");
        $update->bind_param("ii", $newQty, $row['id']);
        $update->execute();
        echo json_encode(['success' => true, 'message' => "$name quantity updated in cart!"]);
    } else {
        // Insert new item
        $insert = $conn->prepare("INSERT INTO cart_items (session_id, name, price, quantity, image) VALUES (?, ?, ?, ?, ?)");
        $insert->bind_param("ssdis", $session_id, $name, $price, $quantity, $image);
        $insert->execute();
        echo json_encode(['success' => true, 'message' => "$name added to cart!"]);
    }
} else {
    echo json_encode(['success' => false, 'message' => "Invalid request"]);
}
?>
