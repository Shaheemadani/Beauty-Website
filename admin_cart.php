<?php
session_start();
include 'db_connection.php';

// Allow only admins
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$result = $conn->query("SELECT * FROM cart_items ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin - View Carts | Lustra Beauty</title>
  <style>
    body {
      background: url('images/admin1.jpg') no-repeat center center fixed;
      background-size: cover;
      font-family: 'Segoe UI', sans-serif;
      color: black;
      padding: 30px;
    }

    .container {
      max-width: 1100px;
      margin: auto;
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(8px);
      border-radius: 12px;
      padding: 30px;
      border: 1px solid rgba(255, 255, 255, 0.2);
      box-shadow: 0 8px 32px rgba(0,0,0,0.2);
    }

    h2 {
      color: #a15187;
      margin-bottom: 20px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background: rgba(255, 255, 255, 0.85);
      margin-bottom: 30px;
    }

    th, td {
      padding: 12px;
      border: 1px solid #ccc;
      text-align: center;
    }

    th {
      background-color: #a15187;
      color: white;
    }

    img {
      width: 60px;
      height: 60px;
      object-fit: cover;
      border-radius: 6px;
    }

    .back-btn {
      display: inline-block;
      background-color: #f08dbb;
      color: white;
      padding: 10px 16px;
      text-decoration: none;
      border-radius: 8px;
      font-weight: bold;
    }

    .back-btn:hover {
      background-color: #c7448e;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>🛒 All Customer Cart Items</h2>

    <table>
      <thead>
        <tr>
          <th>Session ID</th>
          <th>Product</th>
          <th>Image</th>
          <th>Price (LKR)</th>
          <th>Quantity</th>
          <th>Total (LKR)</th>
          <th>Date Added</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($result->num_rows > 0): ?>
          <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?= htmlspecialchars($row['session_id']) ?></td>
              <td><?= htmlspecialchars($row['name']) ?></td>
              <td>
                <?php if (!empty($row['image'])): ?>
                  <img src="product_images/<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['name']) ?>">
                <?php else: ?>
                  N/A
                <?php endif; ?>
              </td>
              <td><?= number_format($row['price'], 2) ?></td>
              <td><?= $row['quantity'] ?></td>
              <td><?= number_format($row['price'] * $row['quantity'], 2) ?></td>
              <td><?= $row['created_at'] ?></td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr><td colspan="7">No items in any cart.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>

    <a href="admin_dashboard.php" class="back-btn">← Back to Dashboard</a>
  </div>
</body>
</html>
