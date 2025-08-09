<?php
session_start();
$conn = new mysqli("localhost", "root", "", "Beauty_Website");
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Fetch categories and subcategories
$categoryQuery = $conn->query("SELECT * FROM categories");
$subcategoryQuery = $conn->query("SELECT * FROM subcategories");

$categories = [];
while ($row = $categoryQuery->fetch_assoc()) {
    $categories[] = $row;
}

$subcategories = [];
while ($row = $subcategoryQuery->fetch_assoc()) {
    $subcategories[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Product | Lustra Beauty</title>
  <link rel="stylesheet" href="admin_dashboard.css">
</head>
<body>

<style>
body {
  background: url('images/admin1.jpg') no-repeat center center fixed;
  background-size: cover;
  font-family: 'Segoe UI', sans-serif;
  padding: 30px;
  color: #333;
}
.form-container {
  max-width: 500px;
  margin: auto;
  background: rgba(255, 255, 255, 0.1);
  backdrop-filter: blur(10px);
  border: 1px solid rgba(255, 255, 255, 0.3);
  padding: 25px;
  border-radius: 12px;
  box-shadow: 0 8px 32px rgba(0,0,0,0.2);
}
h2 {
  text-align: center;
  margin-bottom: 20px;
  color: #c71585;
}
input, select {
  width: 100%;
  padding: 10px;
  margin-bottom: 15px;
  border-radius: 6px;
  border: 1px solid #ccc;
}
button, .back-btn {
  margin-top: 20px;
  padding: 10px 15px;
  border: none;
  border-radius: 8px;
  background-color:rgb(199, 71, 160);
  color: white;
  font-weight: bold;
  cursor: pointer;
  transition: 0.3s;
  text-decoration: none;
}
button:hover {
  background-color: #ff1493;
}
.back-btn {
  display: inline-block;
  margin-top: 15px;
  text-align: center;
  background:  rgb(199, 71, 160);
  color: #fff;
  padding: 10px;
  border-radius: 6px;
  text-decoration: none;
}
</style>

<div class="form-container">
  <h2> Add New Product</h2>
  <form action="save_product.php" method="POST" enctype="multipart/form-data">
    <input type="text" name="name" placeholder="Product Name" required>
    <input type="number" name="price" step="0.01" placeholder="Price" required>

    <select name="category_id" required>
      <option value="">-- Select Category --</option>
      <?php foreach ($categories as $cat): ?>
        <option value="<?= $cat['id'] ?>"><?= $cat['name'] ?></option>
      <?php endforeach; ?>
    </select>

    <select name="subcategory_id" required>
      <option value="">-- Select Subcategory --</option>
      <?php foreach ($subcategories as $sub): ?>
        <option value="<?= $sub['id'] ?>"><?= $sub['name'] ?></option>
      <?php endforeach; ?>
    </select>

    <input type="file" name="image" accept="image/*" required>
    <button type="submit"> Add Product</button>
  </form>
  <a href="admin_dashboard.php" class="back-btn"> Back to Dashboard</a>
  <a href="beautyland.php"class="back-btn">product</a>
</div>

</body>
</html>