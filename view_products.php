<?php
session_start();
$conn = new mysqli("localhost", "root", "", "Beauty_Website");
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$query = "
    SELECT p.*, c.name AS category_name, s.name AS subcategory_name
    FROM products p
    LEFT JOIN categories c ON p.category_id = c.id
    LEFT JOIN subcategories s ON p.subcategory_id = s.id
";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Products - Admin</title>
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
      padding: 30px;
      color: black;
    }

    .container {
      max-width: 1100px;
      margin: auto;
    }
    h1 {
      font-size: 24px;
      color: rgb(161, 81, 135);
      margin-bottom: 20px;
    }

    h2 {
      font-size: 24px;
      color: rgb(161, 81, 135);
      margin-bottom: 20px;
      background: rgba(255,255,255,0.1);
      backdrop-filter: blur(6px);
      padding: 12px 18px;
      border-radius: 10px;
      border: 1px solid rgba(255,255,255,0.2);
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(8px);
      -webkit-backdrop-filter: blur(8px);
      border: 1px solid rgba(255, 255, 255, 0.2);
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 8px 32px rgba(0,0,0,0.25);
      margin-bottom: 30px;
    }

    th, td {
      padding: 12px;
      text-align: left;
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
      color: black;
    }

    th {
      background: rgba(240, 92, 160, 0.2);
      color: rgba(175, 55, 111, 0.91);
    }

    tr:hover {
      background: rgba(240, 92, 160, 0.1);
    }

    img {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 5px;
        }

    .back-btn {
      display: inline-block;
      margin-top: 20px;
      padding: 10px 20px;
      background: #ff69b4;
      color: white;
      text-decoration: none;
      border-radius: 6px;
      font-weight: bold;
    }

    .back-btn:hover {
      background: #ff3399;
    }

    .btn-edit {
    background-color:rgb(176, 39, 158);
    border: none;
    color: white;
    padding: 8px 14px;
    border-radius: 6px;
    cursor: pointer;
    font-size: 14px;
    text-decoration: none;
    transition: background-color 0.3s ease;
    margin-right: 8px;
}

    .btn-edit:hover {
    background-color:rgb(162, 31, 103);
  }

  .btn-delete {
    background-color: #e53935;
    border: none;
    color: white;
    padding: 8px 14px;
    border-radius: 6px;
    cursor: pointer;
    font-size: 14px;
    text-decoration: none;
    transition: background-color 0.3s ease;
}

.btn-delete:hover {
    background-color: #c62828;
}
    </style>
</head>
<body>

<h1>View All Products</h1>

<?php if ($result->num_rows > 0): ?>
<table>
    <tr>
        <th>Image</th>
        <th>Name</th>
        <th>Price (Rs)</th>
        <th>Category</th>
        <th>Subcategory</th>
        <th> Edit</th>
        <th>Delete</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td><img src=product_images/<?= $row['image']; ?> alt="product_images"></td>
        <td><?= htmlspecialchars($row['name']); ?></td>
        <td><?= number_format($row['price'], 2); ?></td>
        <td><?= htmlspecialchars($row['category_name']); ?></td>
        <td><?= htmlspecialchars($row['subcategory_name']); ?></td>
        <td>
          <a href="edit_product.php?id=<?= $row['id'] ?>" class="btn-edit">Edit</a>
        </td>
        <td>
          <a href="delete_product.php?id=<?= $row['id'] ?>" class="btn-delete" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>
<?php else: ?>
    <p style="color: white; text-align: center;">No products found.</p>
<?php endif; ?>

<a href="admin_dashboard.php" class="back">🔙 Back to Dashboard</a>

</body>
</html>