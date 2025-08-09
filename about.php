<?php
session_start();

include 'db_connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>About Us | Lustra Beauty</title>
  <link rel="stylesheet" href="css/about.css"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
</head>
<body>

  
<!-- Navigation Bar -->
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

  <section class="about-section">
    <div class="about-content">
      <div class="about-image">
        <img src="images/aboutimg.jpg" alt="About Us Image">
      </div>
      <div class="about-text">
        <h2>About Lustra Beauty</h2>
        <p>
          At Lustra Beauty, we believe in empowering individuals to express their unique beauty. Our curated selection of premium beauty products ensures that everyone finds something that resonates with their personal style. From timeless classics to the latest trends, we are committed to bringing you the best in beauty.
        </p>
      </div>
    </div>
  </section>

  <!-- Brand Logos Section -->
  <section class="brands-section">
    <h2>Our Featured Brands</h2>
    <div class="brands-logos">
      <a href="beautyland.html" class="brand-logo"><img src="images/dior1.jpg" alt="Dior"></a>
      <a href="beautyland.html" class="brand-logo"><img src="images/anua.jpg" alt="Anua"></a>
      <a href="beautyland.html" class="brand-logo"><img src="images/hudabeauty.jpg" alt="Huda Beauty"></a>
      <a href="beautyland.html" class="brand-logo"><img src="images/fenty beauty.jpg" alt="Fenty"></a>
      <a href="beautyland.html" class="brand-logo"><img src="images/estee.jpg" alt="Estee Lauder"></a>
      <a href="beautyland.html" class="brand-logo"><img src="images/mac.jpg" alt="MAC"></a>
    </div>
  </section>

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