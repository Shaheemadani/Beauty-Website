<?php
session_start();
$conn = new mysqli("localhost", "root", "", "Beauty_Website");

// Get filters
$categoryId = isset($_GET['category']) ? intval($_GET['category']) : 0;
$subcategoryId = isset($_GET['subcategory']) ? intval($_GET['subcategory']) : 0;

// Fetch categories
$categoryRes = $conn->query("SELECT * FROM categories");
$categories = [];
while ($row = $categoryRes->fetch_assoc()) {
    $categories[] = $row;
}

// Fetch subcategories
$subcategoryRes = $conn->query("SELECT * FROM subcategories");
$subcategories = [];
while ($row = $subcategoryRes->fetch_assoc()) {
    $subcategories[] = $row;
}

// Build query
$query = "SELECT * FROM products";
if ($subcategoryId > 0) {
    $query .= " WHERE subcategory_id = $subcategoryId";
} elseif ($categoryId > 0) {
    $query .= " WHERE category_id = $categoryId";
}
$products = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Beauty Land | Lustra Beauty</title>
  <link rel="stylesheet" href="css/beautyland.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>
<body>
  <style>
    /* Remove text decorations from all elements */
    `* {
      text-decoration: none !important;
    }
    
    a {
      text-decoration: none !important;
    }
    
    a:hover {
      text-decoration: none !important;
    }
    
    a:visited {
      text-decoration: none !important;
    }
    
    a:active {
      text-decoration: none !important;
    }
    
    .search-bar {
      margin-bottom: 20px;
      display: flex;
      gap: 10px;
      justify-content: center;
      align-items: center;
    }

    .search-bar input {
      padding: 10px;
      width: 300px;
      border-radius: 5px;
      border: 1px solid #ccc;
    }

    .search-bar button {
      padding: 10px 15px;
      border: none;
      background-color:rgb(192, 55, 167);
      color: white;
      border-radius: 5px;
      cursor: pointer;
    }
  </style>
<div class="Page-wrapper">

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


  <!-- Content Layout -->
  <div class="beauty-container">

    <!-- Sidebar -->
    <aside class="sidebar">
      <h3>Categories</h3>
      <ul>
        <li><a href="beautyland.php">All</a></li>
        <?php foreach ($categories as $cat): ?>
          <li><a href="beautyland.php?category=<?= $cat['id'] ?>"><?= $cat['name'] ?></a></li>
        <?php endforeach; ?>
      </ul>
    </aside>
    

    <!-- Main Content -->
    <main class="product-section">
      <div class="search-bar">
  <input type="text" id="searchInput" onkeyup="searchProducts()" placeholder="Search by name or subcategory...">
  <button onclick="searchProducts()"><i class="fas fa-search"></i></button>
</div>
      
      <!-- Subcategory Tags -->
      <?php if ($categoryId > 0): ?>
        <div class="subcategory-container" id="subcategoryContainer">
          <?php foreach ($subcategories as $sub): ?>
            <?php if ($sub['category_id'] == $categoryId): ?>
              <a href="beautyland.php?subcategory=<?= $sub['id'] ?>" class="tag"><?= $sub['name'] ?></a>
            <?php endif; ?>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

      <!-- Product Grid -->
      <div class="product-grid" id="productGrid">
        <?php while ($p = $products->fetch_assoc()): ?>
          <div class="product-card">
            
            <img src="product_images/<?= htmlspecialchars($p['image']) ?>" alt="<?= htmlspecialchars($p['name']) ?>" />

            <h4><?= htmlspecialchars($p['name']) ?></h4>
            <p><?= htmlspecialchars($p['price']) ?> LKR</p>
            <div class="button-group">
              <button class="add-to-cart" onclick="addToCart('<?= $p['name'] ?>', <?= $p['price'] ?>, '<?= $p['image'] ?>')"><i class="fas fa-cart-plus"></i></button>
            </div>
          </div>
        <?php endwhile; ?>
      </div>
    </main>
  </div>

  <script>
function addToCart(name, price, image, quantity = 1) {
  fetch('add_to_cart.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: `name=${encodeURIComponent(name)}&price=${price}&quantity=${quantity}&image=${encodeURIComponent(image)}`
  })
  .then(response => response.json())
  .then(data => {
    alert(data.message);
  })
  .catch(err => {
    alert('Failed to add product to cart');
  });
}

function buyNow(name, price, quantity = 1) {
  fetch('add_to_cart.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: `name=${encodeURIComponent(name)}&price=${price}&quantity=${quantity}`
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      window.location.href = "cart.php";
    } else {
      alert(data.message);
    }
  });
}

function searchProducts() {
  const input = document.getElementById('searchInput').value.toLowerCase();
  const cards = document.querySelectorAll('.product-card');

  cards.forEach(card => {
    const name = card.querySelector('h4').textContent.toLowerCase();
    const classes = card.className.toLowerCase();

    if (name.includes(input) || classes.includes(input)) {
      card.style.display = 'block';
    } else {
      card.style.display = 'none';
    }
  });
}
</script>

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