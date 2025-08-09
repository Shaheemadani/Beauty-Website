<?php
session_start();
include 'db_connection.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // ======================
    // 1. CUSTOMER LOGIN
    // ======================
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result1 = $stmt->get_result();

    if ($result1->num_rows > 0) {
        $row = $result1->fetch_assoc();

        if (password_verify($password, $row['password'])) {
            // Set session
            $_SESSION['username'] = $row['username'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['role'] = 'customer';
            $_SESSION['profile_image'] = $row['profile_image'];

            // Log activity
            $conn->query("INSERT INTO login_activity (username) VALUES ('$username')");

            // ================
            // Migrate cart
            // ================
            $session_id = session_id();

            $cartQ = $conn->prepare("SELECT name, price, quantity, image FROM cart_items WHERE session_id = ?");
            $cartQ->bind_param("s", $session_id);
            $cartQ->execute();
            $guestItems = $cartQ->get_result();

            while ($gi = $guestItems->fetch_assoc()) {
                $up = $conn->prepare("SELECT id, quantity FROM cart WHERE username = ? AND name = ?");
                $up->bind_param("ss", $username, $gi['name']);
                $up->execute();
                $res2 = $up->get_result();

                if ($res2->num_rows > 0) {
                    $r2 = $res2->fetch_assoc();
                    $newQ = $r2['quantity'] + $gi['quantity'];
                    $upd2 = $conn->prepare("UPDATE cart SET quantity = ? WHERE id = ?");
                    $upd2->bind_param("ii", $newQ, $r2['id']);
                    $upd2->execute();
                } else {
                    $ins2 = $conn->prepare("INSERT INTO cart (username, name, price, quantity, image) VALUES (?, ?, ?, ?, ?)");
                    $ins2->bind_param("ssdss", $username, $gi['name'], $gi['price'], $gi['quantity'], $gi['image']);
                    $ins2->execute();
                }
            }

            $del = $conn->prepare("DELETE FROM cart_items WHERE session_id = ?");
            $del->bind_param("s", $session_id);
            $del->execute();

            header("Location: index.php");
            exit();
        }
    }

    // ======================
    // 2. ADMIN LOGIN
    // ======================
    $stmt = $conn->prepare("SELECT * FROM admins WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result2 = $stmt->get_result();

    if ($result2->num_rows > 0) {
        $row = $result2->fetch_assoc();
        $_SESSION['username'] = $row['username'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['role'] = 'admin';

        $conn->query("INSERT INTO login_activity (username) VALUES ('$username')");

        header("Location: admin_dashboard.php");
        exit();
    }

    // ======================
    // INVALID CREDENTIALS
    // ======================
    echo "<script>alert('Invalid username or password!'); window.location.href='login.php';</script>";
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Login | Lustra Beauty</title>
  <link rel="stylesheet" href="login.css" />
</head>

<style>
    * {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Segoe UI', sans-serif;
}


.login-body {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;

  background: url("images/backround.jpg") no-repeat center center;
  background-size: cover;
}

.login-box {
  background: rgba(255, 255, 255, 0.1); /* transparent white */
  padding: 40px 30px;
  border-radius: 15px;
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
  backdrop-filter: blur(2px);
  -webkit-backdrop-filter: blur(12px); /* Safari support */
  border: 1px solid rgba(255, 255, 255, 0.2);
  text-align: center;
  width: 340px;
  color: #fff;
}

.login-box h2,
.login-box .subtitle,
.login-box .signup-text {
  color: #bd4f4fad;
}

.login-box input {
  background-color: rgba(255, 255, 255, 0.9);
  color: #333;
}

.login-box button {
  background-color: #c71585;
  color: white;
}

.subtitle {
  color: #7e5a63;
  margin-bottom: 25px;
  font-size: 14px;
}

.login-box input {
  width: 100%;
  padding: 10px 12px;
  margin-bottom: 15px;
  border: 1px solid #ffc0cb;
  border-radius: 5px;
  font-size: 14px;
}

.login-box button {
  width: 100%;
  padding: 10px;
  background-color: #6d465f;

  color: white;
  border: none;
  border-radius: 5px;
  font-weight: 500;
  cursor: pointer;
  transition: background-color 0.3s;
}

.login-box button:hover {
  background-color: #e7549c;
}

.signup-text {
  margin-top: 15px;
  font-size: 13px;
  color: #666;
}

.signup-text a {
  color: #c71585;
  text-decoration: none;
}

.signup-text a:hover {
  text-decoration: underline;
}

.back-to-home-btn {
  display: inline-block;
  margin-top: 10px;
  padding: 10px 20px;
  font-size: 14px;
  color: #fff;
  background: rgba(255, 255, 255, 0.1); /* Glassy effect */
  border: 1px solid rgba(255, 255, 255, 0.3);
  border-radius: 5px;
  backdrop-filter: blur(8px);
  -webkit-backdrop-filter: blur(8px);
  text-decoration: none;
  transition: background-color 0.3s, color 0.3s;
}

.back-to-home-btn:hover {
  background-color: #c71585; /* Your theme pink */
  color: #fff;
}
</style>
<body class="login-body">
  <div class="login-box">
    <h2>Welcome Back!</h2>
    <p class="subtitle">Login to Lustra Beauty</p>
    <form method="POST" action="">
      <input type="text" name="username" placeholder="Username" required />
      <input type="password" name="password" placeholder="Password" required />
      <button type="submit">Login</button>
      <p class="signup-text">Don't have an account? <a href="signup.php">Sign up</a></p>
      <a href="index.php" class="back-btn">← Back to Home</a>
    </form>
  </div>
</body>
</html>