<?php
session_start();
include 'db.php'; // database connection

$session_id = session_id();
$username = isset($_SESSION['username']) ? $_SESSION['username'] : null;

// ===== Move guest cart to user cart on login =====
if ($username) {
    $check = $conn->prepare("SELECT * FROM cart_items WHERE session_id = ?");
    $check->bind_param("s", $session_id);
    $check->execute();
    $result = $check->get_result();

    while ($row = $result->fetch_assoc()) {
        $stmt = $conn->prepare("INSERT INTO cart (username, name, price, quantity, image) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdis", $username, $row['name'], $row['price'], $row['quantity'], $row['image']);
        $stmt->execute();
    }

    $del = $conn->prepare("DELETE FROM cart_items WHERE session_id = ?");
    $del->bind_param("s", $session_id);
    $del->execute();
}

// ===== Remove Item =====
if (isset($_GET['remove'])) {
    $item_id = $_GET['remove'];
    if ($username) {
        $stmt = $conn->prepare("DELETE FROM cart WHERE id = ? AND username = ?");
        $stmt->bind_param("is", $item_id, $username);
    } else {
        $stmt = $conn->prepare("DELETE FROM cart_items WHERE id = ? AND session_id = ?");
        $stmt->bind_param("is", $item_id, $session_id);
    }
    $stmt->execute();
    header("Location: cart.php");
    exit();
}

// ===== Update Quantities =====
//if (isset($_POST['update_cart'])) {
//    foreach ($_POST['quantities'] as $id => $qty) {
//        if ($qty < 1) $qty = 1;
 //       if ($username) {
//            $stmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE id = ? AND username = ?");
 //           $stmt->bind_param("iis", $qty, $id, $username);
//        } else {
//            $stmt = $conn->prepare("UPDATE cart_items SET quantity = ? WHERE id = ? AND session_id = ?");
          //  $stmt->bind_param("iis", $qty, $id, $session_id);
        //}
      //  $stmt->execute();
    //}
    //header("Location: cart.php");
  //  exit();
//}
// In the quantity update section of cart.php
if (isset($_POST['update_cart'])) {
    $new_total = 0;
    foreach ($_POST['quantities'] as $id => $qty) {
        $qty = max(1, intval($qty));
        if ($username) {
            $stmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE id = ? AND username = ?");
            $stmt->bind_param("iis", $qty, $id, $username);
        } else {
            $stmt = $conn->prepare("UPDATE cart_items SET quantity = ? WHERE id = ? AND session_id = ?");
            $stmt->bind_param("iis", $qty, $id, $session_id);
        }
        $stmt->execute();
        
        // Calculate new total as we update
        $item_result = $conn->query("SELECT price FROM ".($username ? "cart" : "cart_items")." WHERE id = $id");
        if ($item = $item_result->fetch_assoc()) {
            $new_total += $item['price'] * $qty;
        }
    }
    
    // Store the updated total in session if needed
    $_SESSION['cart_total'] = $new_total;
    
    header("Location: cart.php");
    exit();
}

// ===== Fetch Cart Items =====
if ($username) {
    $stmt = $conn->prepare("SELECT * FROM cart WHERE username = ?");
    $stmt->bind_param("s", $username);
} else {
    $stmt = $conn->prepare("SELECT * FROM cart_items WHERE session_id = ?");
    $stmt->bind_param("s", $session_id);
}
$stmt->execute();
$cart_items = $stmt->get_result();

$total_price = 0;
?>

<!-- === HTML Starts Below === -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Your Cart | Lustra Beauty</title>
  <link rel="stylesheet" href="css/cart.css" />
  <style>
    body {
      display: flex;
      flex-direction: column;
      min-height: 100vh;
      font-family: 'Segoe UI', sans-serif;
    }
    table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
    th, td { padding: 10px; border-bottom: 1px solid #ddd; text-align: center; }
    th { background-color: rgb(201, 60, 175); color: white; }
    input[type=number] { width: 60px; padding: 5px; }
    .remove-btn {
      background: #e74c3c; color: white; border: none;
      padding: 6px 12px; cursor: pointer; border-radius: 4px;
      text-decoration: none;
    }
    .update-btn, .checkout-btn {
      background: #c037a7; color: white; border: none;
      padding: 10px 20px; cursor: pointer; border-radius: 4px;
      margin-right: 10px;
    }
    .checkout-btn { float: right; text-decoration: none; }
    .empty-message { font-size: 1.2em; color: #555; margin-top: 30px; text-align: center; }
    img.cart-img { width: 60px; height: 60px; object-fit: cover; border-radius: 6px; }
    nav.navbar {
      background: #f8e3f0; padding: 10px 30px;
      display: flex; justify-content: space-between; align-items: center;
    }
    .logo { font-size: 1.5em; font-weight: bold; }
    .logo span { color: #c037a7; }
    .nav-links li { display: inline-block; margin-left: 20px; }
    .nav-links a { text-decoration: none; color: #444; font-weight: bold; }
    .login-btn { color: #c037a7; }
    .footer { padding: 30px; background: #f0e4f7; text-align: center; margin-top: auto; }
    .footer-contact p { margin: 5px; }
  </style>
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



<h1 style="text-align:center;">Your Shopping Cart</h1>

<?php if ($cart_items->num_rows == 0): ?>
  <p class="empty-message">Your cart is empty. <a href="beautyland.php">Continue shopping</a>.</p>
<?php else: ?>
  <form method="POST" action="cart.php">
    <table id=tttt>
      <thead>
        <tr>
          <th>Image</th>
          <th>Product Name</th>
          <th>Price (LKR)</th>
          <th>Quantity</th>
          <th>Subtotal (LKR)</th>
          <th>Remove</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($item = $cart_items->fetch_assoc()): ?>
          <tr>
            <td>
              <?php if (!empty($item['image'])): ?>
                <img src="product_images/<?= htmlspecialchars($item['image']) ?>" class="cart-img" alt="">
              <?php endif; ?>
            </td>
            <td><?= htmlspecialchars($item['name']) ?></td>
            <td><?= number_format($item['price'], 2) ?></td>
            <td>
              <input type="number" name="quantities[<?= $item['id'] ?>]" value="<?= $item['quantity'] ?>" min="1" />
            </td>
            <td><?= number_format($item['price'] * $item['quantity'], 2) ?></td>
            <td>
              <a href="cart.php?remove=<?= $item['id'] ?>" onclick="return confirm('Remove this item?');" class="remove-btn">X</a>
            </td>
            <?php 
            $total_price += $item['price'] * $item['quantity']; 
            $_SESSION['totalAmount'] = $total_price;
            ?>
        <?php endwhile; ?>
      </tbody>
    </table>

    <p><strong>Total Price: LKR <?= number_format($total_price, 2) ?></strong></p>

    <button type="submit" name="update_cart" class="update-btn">Update Cart</button>

    <?php if ($username): ?>
      <a href="checkout.php" class="checkout-btn">Proceed to Checkout</a>
    <?php else: ?>
      <a href="login.php" class="checkout-btn">Login to Checkout</a>
    <?php endif; ?>
  </form>
<?php endif; ?>

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