<?php

session_start();
require_once 'connect_db.php';
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    // Prepare and bind the INSERT statement
    $stmt = $conn->prepare("INSERT INTO contact_form (name, email, subject, message) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $subject, $message);

    // Set parameters and execute the statement
    $name = $_POST["name"];
    $email = $_POST["email"];
    $subject = $_POST["subject"];
    $message = $_POST["message"];
    $stmt->execute();

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<section id="headersection">
    <div>
      <ul id="navigationbar">
        <li><a href="index.php">Home</a></li>
        <li><a href="contact.php">Contact</a></li>
        <?php
    // Check if session is set to admin_id or if any user is logged in
    if (isset($_SESSION['admin_id']) || isset($_SESSION['user_id'])) {
        // Display the "Add Recipe" link
        echo '<li><a href="addrecipe.php">Add Recipe</a></li>';
    }
?>

<li><a href="topcontributor.php">Top Contributors</a></li>
        <?php
       
        if (isset($_SESSION['user_id']) || isset($_SESSION['admin_id'])) {
            echo '<li><a href="logout.php">Logout</a></li>';
        } else {
            echo '<li><a href="login.php">Login</a></li>';
        }
        ?>
        <li><a href="Register.php">Register</a></li> 
        <?php
        // Check if session is set to admin_id
        if (isset($_SESSION['admin_id'])) {
            // Display the "Admin Dashboard" link
            echo '<li><a href="admin_dashboard.php">Admin Dashboard</a></li>';
        }
        ?>
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

<div class="container">
        <h2>Contact Us</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="subject">Subject:</label>
            <input type="text" id="subject" name="subject" required>

            <label for="message">Message:</label>
            <textarea id="message" name="message" rows="4" required></textarea>

            <input type="submit" value="Submit">
        </form>
    </div>
    <footer class="footer-section">
    <h5 style="text-align: center; font-size: 24px; color: #333; margin-top: 20px;">Thank You For Your Visit</h5>
  </footer>
    <style>
        .container {
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
        }

        input[type="text"],
        input[type="email"],
        textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        textarea {
            resize: vertical;
            height: 100px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</body>
</html>
