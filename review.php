<?php
session_start();
include 'db_connection.php';

$username = isset($_SESSION['username']) ? $_SESSION['username'] : null;
$profile_image = isset($_SESSION['profile_image']) ? $_SESSION['profile_image'] : './default-user.png';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['message'])) {
    $message = htmlspecialchars(trim($_POST['message']));
    $_SESSION['pending_review'] = $message;

    if (!$username) {
        header("Location: login.php?redirect=review.php");
        exit();
    }

    if (!empty($message)) {
        $stmt = $conn->prepare("INSERT INTO reviews (username, profile_image, message) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $profile_image, $message);
        $stmt->execute();
        $stmt->close();
        unset($_SESSION['pending_review']);
        header("Location: review.php");
        exit();
    }
}

$reviews = [];
$result = $conn->query("SELECT * FROM reviews ORDER BY created_at DESC");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $reviews[] = $row;
    }
}

$pending_review = isset($_SESSION['pending_review']) ? $_SESSION['pending_review'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Customer Reviews - Lustra Beauty</title>
  <link rel="stylesheet" href="css/review.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    html, body {
      height: 100%;
      font-family: 'Segoe UI', sans-serif;
    }

    body {
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    /* Navbar */
    .navbar {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      background-color: #E6C6D0;
      padding: 15px 30px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      z-index: 1000;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }

    .logo {
      font-size: 24px;
      font-weight: bold;
      color: #003366;
    }

    .logo span {
      color: #C19745;
    }
    

    .nav-links {
      list-style: none;
      display: flex;
      gap: 20px;
    }

    .nav-links li a {
      text-decoration: none;
      color: #25839b;
      font-weight: 500;
    }

    .nav-links li a:hover {
      color: #ebd8e1;
    }

    /* Space after navbar */
    .spacer {
      height: 80px;
    }

    /* Review Container with background */
    .review-wrapper {
      flex: 1;
      background: url('images/review_background2.jpg') no-repeat center center;
      background-size: cover;
      padding: 70px 0;
    }

    .review-container {
      max-width: 900px;
      margin: 0 auto;
      background: rgba(255, 255, 255, 0.9);
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 8px 24px rgba(0,0,0,0.2);
    }

    .review-box {
      display: flex;
      gap: 15px;
      padding: 15px;
      margin-bottom: 15px;
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .review-box img {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      object-fit: cover;
    }

    .review-box h4 {
      color: #F003C5;
      margin-bottom: 4px;
    }

    .review-form {
      margin-top: 40px;
    }

    .review-form textarea {
      width: 100%;
      padding: 10px;
      border-radius: 10px;
      border: 1px solid #ccc;
      resize: vertical;
      font-size: 14px;
    }

    .review-form button {
      margin-top: 10px;
      background: #F003C5;
      color: #fff;
      padding: 10px 20px;
      border-radius: 8px;
      border: none;
      cursor: pointer;
    }

    .review-form button:hover {
      background: #d002ae;
    }

    .no-reviews {
      text-align: center;
      font-style: italic;
      color: #777;
    }


     /* Footer Styles */


  .footer {
    background-color: #ffe0e9;
    padding: 20px;
    text-align: center;
    color: #c71585;
    border-top: 1px solid #ffc0cb;
    font-size: 14px;
  }

  .footer a {
    color: #c71585;
    text-decoration: none;
    margin: 0 5px;
  }

  .footer a:hover {
    color: #9b8e94;
  }


  .footer-top {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    gap: 30px;
    max-width: 1200px;
    margin: 0 auto 20px;
    text-align: center;
  }

  .trust-info p,
  .contact-info p {
    margin: 5px 0;
  }

  .contact-info h4 {
    margin-bottom: 10px;
    font-size: 18px;
    color: #003366;
  }

  .social-payments {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
  }

  .social-icons a img,
  .payment-icons img {
    width: 32px;
    height: 32px;
    margin: 0 5px;
    transition: transform 0.3s;
  }

  .social-icons a img:hover,
  .payment-icons img:hover {
    transform: scale(1.1);
  }

  .footer-bottom {
    text-align: center;
    border-top: 1px solid #d8aabe;
    padding-top: 10px;
    font-size: 14px;
  }



  </style>
</head>
<body>

<nav class="navbar">
      <div class="logo">Lustra <span>Beauty</span></div>
      <ul class="nav-links">
        <li><a href="index.php">Home</a></li>
        <li><a href="about.php">About Us</a></li>
        <li><a href="beautyland.php">Beauty Land</a></li>
        <li><a href="cart.php"> Cart</a></li>
        <?php if (isset($_SESSION['username'])): ?>
      <li>
   <a href="profile.php" style="
    display: inline-block;
    background-color: white;
    color: #C19745;
    font-weight: bold;
    padding: 2px 2px;
    border-radius: 6px;
    text-decoration: none;
    transition: 0.3s;
  ">
    Hi, <?php echo $_SESSION['username']; ?> 👋
  </a>
</li>
      <li><a href="logout.php" class="login-btn">Logout</a></li>
    <?php else: ?>
      <li><a href="signup.php" class="login-btn">Sign Up</a></li>
      <li><a href="login.php" class="login-btn">Login</a></li>
    <?php endif; ?>
      </ul>
    </nav>
<!-- Spacer for navbar -->
<div class="spacer"></div>

<!-- Review Section -->
<div class="review-wrapper">
  <div class="review-container">
    <h2>💬 What Our Customers Say</h2>

    <?php if (count($reviews) > 0): ?>
      <?php foreach ($reviews as $rev): ?>
        <div class="review-box">
          <img src="./uploads/<?= htmlspecialchars($rev['profile_image']) ?>" alt="User">
          <div>
            <h4><?= htmlspecialchars($rev['username']) ?></h4>
            <p><?= htmlspecialchars($rev['message']) ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p class="no-reviews">No reviews yet. Be the first to review!</p>
    <?php endif; ?>

    <!-- Submit Review -->
    <div class="review-form">
      <h3>📝 Write a Review</h3>
      <form method="POST">
        <textarea name="message" placeholder="Write your experience..." required><?= htmlspecialchars($pending_review) ?></textarea>
        <button onclick="window.location.href='index.php'" >Back</button>
        <button type="submit">Submit Review</button>
      </form>
    </div>
  </div>
</div>

<!-- Footer -->
    <footer class="footer">
      <div class="footer-top">
        <div class="info-box"><i class="fas fa-lock"></i> Secure Payments</div>
        <div class="info-box"><i class="fas fa-certificate"></i> 100% Authentic</div>
        <div class="info-box"><i class="fas fa-thumbs-up"></i> Trusted Online Store</div>
      </div>

      

      <div class="footer-contact">
        <p><strong>Lustra Beauty</strong></p>
        <p><strong>SHAHEEMA MADANI</strong></p>
        <p>96/A PARANAWATHTHA KANNATHTHOTA</p>
        <p>Email: contact@lustrabeauty.com</p>
        <p>Phone: +077-9508739</p>
      </div>

      <div class="footer-social">
        <a href="#"><i class="fab fa-facebook-f"></i></a>
        <a href="#"><i class="fab fa-instagram"></i></a>
        <a href="#"><i class="fab fa-twitter"></i></a>
        <a href="#"><i class="fab fa-youtube"></i></a>
      </div>

      <p class="copyright">&copy; 2025 Lustra Beauty. All rights reserved.</p>
    </footer>

</body>
</html>