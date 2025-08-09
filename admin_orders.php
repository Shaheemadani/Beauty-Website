<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "Beauty_Website");

// Fetch orders
$ordersResult = $conn->query("
    SELECT id, username, full_name, city, district, street, phone, email, payment_method, total_amount, order_date
    FROM orders
    ORDER BY order_date DESC
");

// Fetch order items
$orderItemsResult = $conn->query("
    SELECT oi.id, oi.order_id, oi.product_name, oi.quantity, oi.price, o.order_date
    FROM order_items oi
    JOIN orders o ON oi.order_id = o.id
    ORDER BY o.order_date DESC, oi.id ASC
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Orders | Lustra Beauty</title>
</head>
<body>

<style>
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Segoe UI', sans-serif;
  }

  body {
    background: url('images/admin1.jpg') no-repeat center center fixed;
    background-size: cover;
    color: black;
    padding: 30px;
  }

  .dashboard-container {
    max-width: 1100px;
    margin: auto;
  }

  .welcome-box {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(8px);
    border-radius: 12px;
    padding: 25px 30px;
    margin-bottom: 30px;
    border: 1px solid rgba(255, 255, 255, 0.2);
    box-shadow: 0 8px 32px rgba(0,0,0,0.2);
  }

  .welcome-box h2 {
    font-size: 26px;
    margin-bottom: 10px;
    color: rgb(161, 81, 135);
  }

  .action-btn {
    display: inline-block;
    margin: 10px 10px 0 0;
    padding: 10px 16px;
    background-color: rgba(255, 51, 153, 0.66);
    color: white;
    text-decoration: none;
    border-radius: 8px;
    font-weight: bold;
    transition: 0.3s;
  }

  .action-btn:hover {
    background-color: #ff3399;
  }

  .table-container {
    margin-top: 30px;
  }

  .table-container h3 {
    margin-bottom: 12px;
    color: rgb(41, 28, 36);
  }

  table {
    width: 100%;
    border-collapse: collapse;
    background: rgba(139, 35, 122, 0.1);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    border: 1px solid rgba(126, 38, 126, 0.4);
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 8px 32px rgba(0,0,0,0.25);
    color: black;
  }

  th {
    background: rgba(240, 92, 160, 0.2);
    color: rgba(175, 55, 111, 0.91);
    padding: 12px;
    text-align: left;
  }

  td {
    padding: 10px 12px;
    border-bottom: 1px solid rgba(214, 21, 188, 0.1);
  }

  tr:hover {
    background: rgba(240, 92, 160, 0.1);
  }
</style>

<div class="dashboard-container">
  <div class="welcome-box">
    <h2>All Customer Orders</h2>
    <a href="admin_dashboard.php" class="action-btn">← Back to Dashboard</a>
  </div>

  <div class="table-container">
    <h3>Orders Overview</h3>
    <table>
      <tr>
        <th>Order ID</th>
        <th>Username</th>
        <th>Name</th>
        <th>Address</th>
        <th>Phone</th>
        <th>Email</th>
        <th>Payment</th>
        <th>Total (LKR)</th>
        <th>Date</th>
      </tr>
      <?php while ($order = $ordersResult->fetch_assoc()) { ?>
      <tr>
        <td><?= $order['id']; ?></td>
        <td><?= htmlspecialchars($order['username'] ?? 'Guest'); ?></td>
        <td><?= htmlspecialchars($order['full_name']); ?></td>
        <td><?= htmlspecialchars("{$order['street']}, {$order['district']}, {$order['city']}"); ?></td>
        <td><?= htmlspecialchars($order['phone']); ?></td>
        <td><?= htmlspecialchars($order['email']); ?></td>
        <td><?= htmlspecialchars($order['payment_method']); ?></td>
        <td><?= number_format($order['total_amount'], 2); ?></td>
        <td><?= $order['order_date']; ?></td>
      </tr>
      <?php } ?>
    </table>
  </div>

  <div class="table-container">
    <h3>Order Items</h3>
    <table>
      <tr>
        <th>Item ID</th>
        <th>Order ID</th>
        <th>Product</th>
        <th>Quantity</th>
        <th>Price (LKR)</th>
        <th>Order Date</th>
      </tr>
      <?php while ($item = $orderItemsResult->fetch_assoc()) { ?>
      <tr>
        <td><?= $item['id']; ?></td>
        <td><?= $item['order_id']; ?></td>
        <td><?= htmlspecialchars($item['product_name']); ?></td>
        <td><?= $item['quantity']; ?></td>
        <td><?= number_format($item['price'], 2); ?></td>
        <td><?= $item['order_date']; ?></td>
      </tr>
      <?php } ?>
    </table>
  </div>
</div>

</body>
</html>