<?php
session_start();

// Check admin login
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

include 'db.php';

// Get product ID
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // First get the image path to delete the image file too (optional cleanup)
    $image_query = "SELECT image FROM products WHERE id = $id";
    $image_result = mysqli_query($conn, $image_query);
    $image = mysqli_fetch_assoc($image_result)['image'];

    // Delete from DB
    $delete_query = "DELETE FROM products WHERE id = $id";
    if (mysqli_query($conn, $delete_query)) {
        // Optionally delete the image file (if not used elsewhere)
        if ($image && file_exists($image)) {
            unlink($image); // delete the file from server
        }
        header("Location: view_products.php");
        exit();
    } else {
        echo "Error deleting product: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request.";
}
?>