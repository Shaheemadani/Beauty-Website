<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "Beauty_Website");

// Fetch sold products
$soldProducts = $conn->query("SELECT * FROM sold_products ORDER BY sold_date DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Sold Products | Lustra Beauty</title>
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
  …
[3:13 am, 13/06/2025] Shaheema: <?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "Beauty_Website");

// Fetch sold products
$soldProducts = $conn->query("SELECT * FROM sold_products ORDER BY sold_date DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Sold Products | Lustra Beauty</title>
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
    <h2>Sold Products</h2>
    <a href="admin_dashboard.php" class="action-btn">← Back to Dashboard</a>
  </div>

  <div class="table-container">
    <h3>All Sold Products</h3>
    <table>
      <tr>
        <th>ID</th>
        <th>Product Name</th>
        <th>Quantity</th>
        <th>Price (LKR)</th>
        <th>Sold Date</th>
      </tr>
      <?php while ($row = $soldProducts->fetch_assoc()) { ?>
      <tr>
        <td><?= $row['id']; ?></td>
        <td><?= htmlspecialchars($row['product_name']); ?></td>
        <td><?= $row['quantity']; ?></td>
        <td><?= number_format($row['price'], 2); ?></td>
        <td><?= $row['sold_date']; ?></td>
      </tr>
      <?php } ?>
    </table>
  </div>
</div>

</body>
</html>