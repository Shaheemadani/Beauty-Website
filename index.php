  <?php
  session_start();
  include 'db_connection.php';
  ?>

  <!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Lustra Beauty - Home</title>
    <link rel="stylesheet" href="css/index.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
  </head>
  <body>
    <style>
      .mini-reviews {
    background: linear-gradient(rgba(255, 255, 255, 0.85), rgba(255, 255, 255, 0.85)),
                url('images/backround.jpg') center/cover no-repeat;
    padding: 10px 10px;
    text-align: center;
  }

    </style>

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


    
  </ul>


    <!-- Hero Section with Slideshow -->
    <section class="hero">
      <div class="slideshow-container">
        <div class="slide fade">
          <img src="images/heroimg1.jpg" alt="Slide 1" />
        </div>
        <div class="slide fade">
          <img src="images/heroimg2.jpg" alt="Slide 2" />
        </div>
        <div class="slide fade">
          <img src="images/heropic2.avif" alt="Slide 3" />
        </div>
        <div class="overlay-text">
          <h1>Welcome to Lustra Beauty</h1>
          <p>Discover your inner glow</p>
        </div>
      </div>
    </section>

    <!-- Feature Section -->
    <section class="features">
      <h2>Our Featured Products</h2>

      
      <div class="product-grid">
        <?php include 'featured_products.php'; ?>
  </div>

    </section>

  <!-- Customer Reviews Mini Section -->
<section class="mini-reviews">
  <div class="container">
    <h2>What our customers are saying?</h2>
    <div class="reviews-row">
      <?php
        include 'db_connection.php';
        $query = "SELECT * FROM reviews ORDER BY created_at DESC LIMIT 3";
        $result = $conn->query($query);

        if ($result->num_rows > 0):
          while ($row = $result->fetch_assoc()):
      ?>
        <div class="review-card">
          <img src="./uploads/<?php echo htmlspecialchars($row['profile_image']); ?>" alt="<?php echo htmlspecialchars($row['username']); ?>">
          <h4><?php echo htmlspecialchars($row['username']); ?></h4>
          <p>"<?php echo htmlspecialchars($row['message']); ?>"</p>
        </div>
      <?php
          endwhile;
        else:
          echo "<p>No reviews yet. Be the first to review!</p>";
        endif;
      ?>
    </div>
    <a href="review.php" class="write-review-btn">Share Your Experience</a>
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

    <script src="js/index.js"></script>
  </body>
  </html>
  </body>
  </html>