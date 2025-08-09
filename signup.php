<?php
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Encrypt password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Handle image upload
    $targetDir = "uploads/";
    $profileImage = $_FILES["profile_image"]["name"];
    $targetFile = $targetDir . basename($profileImage);
    move_uploaded_file($_FILES["profile_image"]["tmp_name"], $targetFile);

    // Connect to database
    $conn = new mysqli("localhost", "root", "", "Beauty_Website");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert user data
    $sql = "INSERT INTO users (fullname, email, username, password, profile_image)
            VALUES ('$fullname', '$email', '$username', '$hashedPassword', '$profileImage')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Account created successfully!'); window.location.href='login.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!-- Signup HTML Form -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Sign Up | Lustra Beauty</title>
  <link rel="stylesheet" href="css/login.css" />
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
    <h2>Create Account</h2>
    <p class="subtitle">Join Lustra Beauty and shine with us</p>
    <form action="signup.php" method="POST" enctype="multipart/form-data">
      <input type="text" name="fullname" placeholder="Full Name" required />
      <input type="email" name="email" placeholder="Email Address" required />
      <input type="text" name="username" placeholder="Username" required />
      <input type="password" name="password" placeholder="Password" required />
      <input type="file" name="profile_image" accept="image/*" required />
      <button type="submit">Sign Up</button>
      <p class="signup-text">Already have an account? <a href="login.php">Login</a></p>
    </form>
  </div>
</body>
</html>