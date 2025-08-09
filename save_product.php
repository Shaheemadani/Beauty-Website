<?php
$conn = new mysqli("localhost", "root", "", "Beauty_Website");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $category_id = $_POST['category_id'];
    $subcategory_id = $_POST['subcategory_id'];

    $image = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];
    $path = "product_images/" . basename($image);

    if (move_uploaded_file($tmp, $path)) {
        $sql = "INSERT INTO products (name, price, category_id, subcategory_id, image) 
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sdiis", $name, $price, $category_id, $subcategory_id, $image);

        if ($stmt->execute()) {
            echo "<script>alert('✅ Product Added Successfully!'); window.location.href='add_product.php';</script>";
        } else {
            echo "❌ Error saving product: " . $stmt->error;
        }
    } else {
        echo "❌ Failed to upload image.";
    }
} else {
    echo "Invalid Access.";
}