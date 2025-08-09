<?php
session_start();
include("db.php");

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

// Fetch user details
$user_stmt = $conn->prepare("SELECT fullname, email, profile_image FROM users WHERE username = ?");
$user_stmt->bind_param("s", $username);
$user_stmt->execute();
$user_result = $user_stmt->get_result();
$user = $user_result->fetch_assoc();

// Fetch orders
$order_stmt = $conn->prepare("SELECT * FROM orders WHERE username = ?");
$order_stmt->bind_param("s", $username);
$order_stmt->execute();
$order_result = $order_stmt->get_result();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Profile</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: url('images/profile_back.jpg') no-repeat center center fixed;
            background-size: cover;
        }

        .container {
            max-width: 800px;
            margin: 40px auto;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(12px);
            border-radius: 16px;
            padding: 30px;
            color: #333;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .profile-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .profile-header img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.3);
        }

        h2 {
            margin: 10px 0 5px;
        }
        .h3 {
            font color: #d002b0;
        }

        .orders {
            margin-top: 40px;
        }

        .order-box {
            background: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .order-box h4 {
            margin-bottom: 10px;
        }

        .item {
            font-size: 15px;
            margin-left: 15px;
        }

        .buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }

        .buttons a {
            padding: 10px 18px;
            background-color: #F003C5;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            transition: 0.3s;
        }

        .buttons a:hover {
            background-color: #d002b0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="profile-header">
            <img src=./uploads/<?php echo htmlspecialchars($user['profile_image']); ?> alt="Profile Image">
            <h2><?php echo htmlspecialchars($user['fullname']); ?></h2>
            <p><?php echo htmlspecialchars($user['email']); ?></p>
        </div>

        <div class="orders">
            <h3>Your Order History</h3>
            <?php while ($order = $order_result->fetch_assoc()): ?>
                <div class="order-box">
                    <h4>Order ID: <?php echo $order['id']; ?> | Date: <?php echo $order['order_date']; ?></h4>
                    <p><strong>Address:</strong> <?php echo $order['street'] . ", " . $order['district'] . ", " . $order['city']; ?></p>
                    <p><strong>Phone:</strong> <?php echo $order['phone']; ?> | <strong>Payment:</strong> <?php echo $order['payment_method']; ?> | <strong>Total:</strong> Rs.<?php echo number_format($order['total_amount'], 2); ?></p>
                    <p><strong>Items:</strong></p>
                    <?php
                    $order_id = $order['id'];
                    $item_stmt = $conn->prepare("SELECT product_name, quantity, price FROM order_items WHERE order_id = ?");
                    $item_stmt->bind_param("i", $order_id);
                    $item_stmt->execute();
                    $item_result = $item_stmt->get_result();
                    while ($item = $item_result->fetch_assoc()):
                    ?>
                        <div class="item">• <?php echo $item['product_name']; ?> (x<?php echo $item['quantity']; ?>) - Rs.<?php echo number_format($item['price'], 2); ?></div>
                    <?php endwhile; ?>
                </div>
            <?php endwhile; ?>
        </div>

        <div class="buttons">
            <a href="index.php">← Back to Home</a>
            <a href="logout.php">Logout</a>
        </div>
    </div>
</body>
</html>