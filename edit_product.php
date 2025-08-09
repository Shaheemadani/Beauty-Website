<?php
include 'db.php';

// Get product ID from URL
$id = $_GET['id'];

// Fetch product data
$product_query = "SELECT * FROM products WHERE id = $id";
$product_result = mysqli_query($conn, $product_query);
$product = mysqli_fetch_assoc($product_result);

// Fetch categories and subcategories
$categories = mysqli_query($conn, "SELECT * FROM categories");
$subcategories = mysqli_query($conn, "SELECT * FROM subcategories");

// Update logic
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $category_id = $_POST['category'];
    $subcategory_id = $_POST['subcategory'];

    // Handle new image
    if ($_FILES['image']['name']) {
        $image_name = 'uploads/' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $image_name);
    } else {
        $image_name = $product['image']; // keep old image
    }

    // Update query
    $update = "UPDATE products SET 
        name='$name',
        price='$price',
        category_id='$category_id',
        subcategory_id='$subcategory_id',
        image='$image_name'
        WHERE id=$id";

    if (mysqli_query($conn, $update)) {
        header("Location: view_products.php");
        exit();
    } else {
        echo "Error updating: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>
    <link rel="stylesheet" href="admin_styles.css">
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
      padding: 30px;
      color: black;
    }
        .form-container {
    width: 400px;
    margin: 50px auto;
    padding: 25px;
    background:rgb(237, 240, 199);
    border-radius: 10px;
    box-shadow: 0 0 10px #d0cbdb;
    font-family: sans-serif;
}
    form label {
    display: block;
    margin-top: 15px;
    }
    form input[type="text"],
    form input[type="number"],
    form select,
    form input[type="file"] {
    width: 100%;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 5px;
    }
    form button {
    margin-top: 20px;
    padding: 10px 15px;
    background-color: #f003c5;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    }
    form button:hover {
    background-color: #d002b5;
    }
    </style>

    <div class="form-container">
        <h2>Edit Product</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <label>Product Name:</label>
            <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>

            <label>Price:</label>
            <input type="number" step="0.01" name="price" value="<?= htmlspecialchars($product['price']) ?>" required>

            <label>Category:</label>
            <select name="category" required>
                <?php while ($cat = mysqli_fetch_assoc($categories)) { ?>
                    <option value="<?= $cat['id'] ?>" <?= $cat['id'] == $product['category_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cat['name']) ?>
                    </option>
                <?php } ?>
            </select>

            <label>Subcategory:</label>
            <select name="subcategory" required>
                <?php while ($sub = mysqli_fetch_assoc($subcategories)) { ?>
                    <option value="<?= $sub['id'] ?>" <?= $sub['id'] == $product['subcategory_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($sub['name']) ?>
                    </option>
                <?php } ?>
            </select>

            <label>Product Image:</label>
            <input type="file" name="image">
            <p>Current: <img src="<?= $product['image'] ?>" width="80"></p>

            <button type="submit">Update Product</button>
            <button href="admin_dashboard.php" class="back-btn"> Back to </button>
        </form>
    </div>
</body>
</html>