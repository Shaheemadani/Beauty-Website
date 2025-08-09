<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "Beauty_Website");

// Total registered customers
$customerCountResult = $conn->query("SELECT COUNT(*) AS total FROM users");
$customerCount = $customerCountResult->fetch_assoc()['total'];

// All customers
$customers = $conn->query("SELECT * FROM users");

// Login activity
$logins = $conn->query("SELECT * FROM login_activity ORDER BY login_time DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard | Lustra Beauty</title>
  <link rel="stylesheet" href="admin_dashboard.css">
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
  color: black ;
  padding: 30px;
}

.dashboard-container {
  max-width: 1100px;
  margin: auto;
  box-shadow
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
  color:rgb(161, 81, 135);
}

.logout-btn {
  display: inline-block;
  margin-top: 15px;
  padding: 8px 16px;
  background: #ff69b4;
  color: #fff;
  border: none;
  border-radius: 6px;
  text-decoration: none;
  font-weight: 500;
  transition: background 0.3s;
}

.logout-btn:hover {
  background: #ff3399;
}

.action-btn {
  display: inline-block;
  margin: 10px 10px 0 0;
  padding: 10px 16px;
  background-color:rgba(255, 51, 153, 0.66);
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
  color:rgb(41, 28, 36);
}

/* Transparent Glassy Table */
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
  color:rgba(175, 55, 111, 0.91) ;
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
    <h2>Welcome, <?php echo $_SESSION['username']; ?></h2>
    <p>Total Registered Customers: <strong><?php echo $customerCount; ?></strong></p>
    <a href="logout.php" class="logout-btn">Logout</a>

    <div style="margin-top: 20px;">
  <a href="add_product.php" class="action-btn"> Add Product</a>
  <a href="view_products.php" class="action-btn"> View Products</a>
  <a href="admin_reviews.php" class="action-btn">View Reviews</a>
  <a href="admin_cart.php" class="action-btn">View Carts</a>
  <a href="admin_orders.php" class="action-btn">View Orders</a>
  <a href="admin_sold_products.php" class="action-btn">View Sold Products</a>
</div>
  </div>

  <div class="table-container">
    <h3>All Registered Customers</h3>
    <table>
      <tr>
        <th>ID</th>
        <th>Full Name</th>
        <th>Email</th>
        <th>Username</th>
      </tr>
      <?php while ($row = $customers->fetch_assoc()) { ?>
      <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['fullname']; ?></td>
        <td><?php echo $row['email']; ?></td>
        <td><?php echo $row['username']; ?></td>
      </tr>
      <?php } ?>
    </table>
  </div>

  <div class="table-container">
    <h3>Login Activity</h3>
    <table>
      <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Login Time</th>
      </tr>
      <?php while ($row = $logins->fetch_assoc()) { ?>
      <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['username']; ?></td>
        <td><?php echo $row['login_time']; ?></td>
      </tr>
      <?php } ?>
    </table>
  </div>
</div>

</body>
</html>