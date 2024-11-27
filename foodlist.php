<?php 
require_once 'connect_db.php';
session_start();
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
  background-color:rgba(0, 0, 0, 0.5);">
    <?php
      // Check if cuisine_id is set in the URL
      if(isset($_GET['cuisine_id'])) {
        $cuisine_id = $_GET['cuisine_id'];

        // Fetch cuisine name for the specified cuisine_id
        $sql = "SELECT CuisineName FROM Cuisines WHERE CuisineID = $cuisine_id";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
          $row = $result->fetch_assoc();
          echo $row['CuisineName'];
        } else {
          echo "Cuisine not found";
        }
      } 
    ?>
    </h2>
    <section id="categorybox" class="section-p1">
    </section>
  </div>

  <div style="display: flex; align-items: center; flex-wrap: wrap; justify-content: space-between;">
    <div class="category">
      <?php

      // Check if cuisine_id is set in the URL
      if(isset($_GET['cuisine_id'])) {
        $cuisine_id = $_GET['cuisine_id'];

        // Fetch recipes for the specified cuisine_id
        $sql = "SELECT RecipeID, RecipeName, Recipe_Image FROM Recipes WHERE CuisineID = $cuisine_id AND ApprovalStatus = 'Approved'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
          // Output data of each row
          while ($row = $result->fetch_assoc()) {
            $imageData = $row['Recipe_Image']; // Get the image data from the database
            $imageSrc = 'data:image/jpeg;base64,' . base64_encode($imageData); // Convert binary image data to base64 format
      ?>
            <div style="margin: 0px 10px; border: solid black;">
              <a href="recipe.php?recipe_id=<?php echo $row['RecipeID']; ?>" style="text-decoration: none;">
                <img src="<?php echo $imageSrc; ?>" alt="<?php echo $row['RecipeName']; ?> photo">
                <div id="category-text">
                  <h5 class="textcolor"><?php echo $row['RecipeName']; ?></h5>
                </div>
              </a>
            </div>
      <?php
          }
        } else {
          echo "0 results";
        }
      } else {
        echo "Cuisine ID not provided.";
      }

      $conn->close();
      ?>
    </div>
  </div>

  <footer class="footer-section">
    <h5 style="text-align: center; font-size: 24px; color: #333; margin-top: 20px;">Thank You For Your Visit</h5>
  </footer>
</body>

</html>
