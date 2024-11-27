<?php
session_start();
require_once 'connect_db.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if the email exists in users table
    $sql = "SELECT * FROM users WHERE Email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Email exists in users table, verify password
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['Password'])) {
            // Password is correct, set user_id to session and redirect to user dashboard
            $_SESSION['user_id'] = $row['UserID'];
            $_SESSION['role'] = 'user';
            header("Location: index.php");
            exit();
        } else {
            echo "Incorrect password";
            exit();
        }
    }

    // Check if the email exists in admins table
    $sql = "SELECT * FROM admins WHERE Email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Email exists in admins table, verify password
        $row = $result->fetch_assoc();
        echo $row['Password'];
        echo $password;
        if ($password = $row['Password']) {
            // Password is correct, set admin_id to session and redirect to admin dashboard
            $_SESSION['admin_id'] = $row['AdminID'];
            $_SESSION['role'] = 'admin';
            header("Location: admin_dashboard.php");
            exit();
        } else {
            echo "Incorrect password";
            exit();
        }
    }

    // If email is not found in users or admins table
    echo "Email not found";
}

// Close database connection
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="style.css"> 
</head>
<body>
<section id="headersection">
    <div>
      <ul id="navigationbar">
        <li><a href="index.php">Home</a></li>
        <li><a href="contact.php">Contact</a></li>
        <li><a href="topcontributor.php">Top Contributors</a></li>
        <li><a href="login.php">Login</a></li>
        <li><a href="Register.php">Register</a></li> 
      </ul>
    </div>
  </section>

  <div class="background">
  <h2 style="font-size: 30px; 
  width:140px; 
  color: #fff; 
  margin-top: 10px; 
  margin-bottom: 20px; 
  margin-left: 32px; 
  font-weight: bold; 
  padding: 10px 20px; 
  border: 2px solid #000; 
  background-color:rgba(0, 0, 0, 0.5);">Cuisine</h2>
    <section id="categorybox" class="section-p1">
    </section>
    </div>

    <form action="login.php" method="post" style="background-color: white; border: 1px solid #ddd; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); padding: 20px; border-radius: 5px; width: 300px; margin: 100px auto;">
        <label for="email" style="font-weight: bold; margin-bottom: 5px;">Email:</label><br>
        <input type="email" id="email" name="email" required style="width: 100%; padding: 8px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;"><br>
        
        <label for="password" style="font-weight: bold; margin-bottom: 5px;">Password:</label><br>
        <input type="password" id="password" name="password" required style="width: 100%; padding: 8px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;"><br>
        
        <input type="submit" value="Login" style="background-color: #4CAF50; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; width: 100%;">
    </form>

  <footer class="footer-section">
    <h5 style="text-align: center; font-size: 24px; color: #333; margin-top: 20px;">Thank You For Your Visit</h5>
  </footer>
</body>

</html>
