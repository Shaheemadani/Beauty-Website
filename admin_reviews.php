<?php
session_start();

// Only allow access to admins
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "Beauty_Website");

// Handle delete
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['delete_id'])) {
    $id = intval($_POST['delete_id']);
    $conn->query("DELETE FROM reviews WHERE id = $id");
    header("Location: admin_reviews.php");
    exit();
}

// Get all reviews
$reviews = $conn->query("SELECT * FROM reviews ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin - Customer Reviews | Lustra Beauty</title>
  <link rel="stylesheet" href="admin_dashboard.css">
  <style>
    body {
      background: url('images/admin1.jpg') no-repeat center center fixed;
      background-size: cover;
      font-family: 'Segoe UI', sans-serif;
      color: black;
      padding: 30px;
    }

    .review-container {
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

    .review-card {
      display: flex;
      align-items: center;
      background: rgba(255, 255, 255, 0.6);
      border-radius: 12px;
      margin-bottom: 15px;
      padding: 15px;
      box-shadow: 0 4px 16px rgba(0,0,0,0.1);
    }

    .review-card img {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      margin-right: 15px;
      object-fit: cover;
    }

    .review-text {
      flex: 1;
    }

    .review-text h4 {
      margin: 0;
      color: #F003C5;
    }

    .review-text p {
      margin: 4px 0;
    }

    .review-text small {
      color: #666;
    }

    form button {
      background-color: #ff4d88;
      color: white;
      border: none;
      padding: 6px 12px;
      border-radius: 6px;
      cursor: pointer;
    }

    form button:hover {
      background-color: #e60073;
    }

    .back-btn {
      margin-top: 20px;
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

<div class="review-container">
  <h2>📝 Customer Reviews</h2>

  <?php while ($row = $reviews->fetch_assoc()): ?>
    <div class="review-card">
      <img src="./uploads/<?= htmlspecialchars($row['profile_image']) ?>" alt="User">
      <div class="review-text">
        <h4><?= htmlspecialchars($row['username']) ?></h4>
        <p><?= htmlspecialchars($row['message']) ?></p>
        <small>Posted on <?= $row['created_at'] ?></small>
      </div>
      <form method="POST">
        <input type="hidden" name="delete_id" value="<?= $row['id'] ?>">
        <button type="submit">Delete</button>
      </form>
    </div>
  <?php endwhile; ?>

  <a href="admin_dashboard.php" class="back-btn">← Back to Dashboard</a>
</div>

</body>
</html>
