<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['order_id'])) {
    echo "Order ID not specified.";
    exit();
}

$conn = new mysqli("localhost", "root", "", "Beauty_Website");

$order_id = $_GET['order_id'];

// Fetch order items
$stmt = $conn->prepare("SELECT * FROM order_items WHERE order_id = ?");
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Order Items</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #fff6fa;
      padding: 30px;
    }
    h2 {
      text-align: center;
      color: #c037a7;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 30px;
      background: #fff;
      box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }
    th, td {
      padding: 10px 14px;
      border: 1px solid #ddd;
    }
    th {
      background: #fdd3e5;
      color: #8e2e63;
    }
  </style>
</head>
<body>

<h2>Order #<?= htmlspecialchars($order_id) ?> - Items</h2>

<table>
  <tr>
    <th>Item ID</th>
    <th>Product Name</th>
    <th>Price</th>
    <th>Qty</th>
    <th>Image</th>
  </tr>
  <?php while ($item = $result->fetch_assoc()): ?>
  <tr>
    <td><?= $item['id'] ?></td>
    <td><?= htmlspecialchars($item['product_name']) ?></td>
    <td>৳<?= number_format($item['price'], 2) ?></td>
    <td><?= $item['quantity'] ?></td>
    <td><img src="<?= $item['image'] ?>" style="width: 60px; height: 60px; object-fit: cover;"></td>
  </tr>
  <?php endwhile; ?>
</table>

</body>
</html>
