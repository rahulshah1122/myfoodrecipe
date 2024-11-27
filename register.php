<?php 
session_start();

// Check if either user_id or admin_id is set
if (isset($_SESSION['user_id']) || isset($_SESSION['admin_id'])) {
    // Redirect to a page indicating no access
    header("Location: index.php");
    exit();
}

require_once 'connect_db.php';
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset='utf-8'>
  <meta http-equiv='X-UA-Compatible' content='IE=edge'>
  <title>Recipe Book</title>
  <meta name='viewport' content='width=device-width, initial-scale=1.0'>
  <link rel='stylesheet' type='text/css' media='screen' href='style.css'>
  <script src='script.js'></script>
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
        <li><a href="login.php">Login</a></li>
      </ul>
    </div>
  </section>

  <div class="background">
    <section id="categorybox" class="section-p1">
    </section>
    </div>


    <form action="acceptregister.php" method="post">
    <h2>Register YourSelf</h2>

  <label for="username">Username:</label><br>
  <input type="text" id="username" name="username" required><br>
  
  <label for="email">Email:</label><br>
  <input type="email" id="email" name="email" required><br>
  
  <label for="password">Password:</label><br>
  <input type="password" id="password" name="password" required><br>
  
  <label for="contact">Contact:</label><br>
  <input type="tel" id="contact" name="contact"><br>
  
  <input type="submit" value="Register">
</form>




  

  <footer class="footer-section">
    <h5 style="text-align: center; font-size: 24px; color: #333; margin-top: 20px;">Thank You For Your Visit</h5>
  </footer>
</body>

<style>

form {
  width: 300px;
  margin: auto;
}

label {
  font-weight: bold;
}

input[type="text"],
input[type="email"],
input[type="password"] {
  width: 100%;
  padding: 8px;
  margin-bottom: 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}

input[type="submit"] {
  background-color: #007bff;
  color: white;
  padding: 10px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-size: 16px;
}

input[type="submit"]:hover {
  background-color:  #0056b3;
}

/* Optional: Style for the contact field */
input[type="tel"] {
  width: 100%;
  padding: 8px;
  margin-bottom: 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}
</style>

</html>
