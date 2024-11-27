<?php
session_start();
require_once 'connect_db.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id']) && !isset($_SESSION['admin_id'])) {
  // Redirect to the login page if not logged in
  header("Location: login.php");
  exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
  // Check if cuisineName is set in the POST data
  if (isset($_POST['cuisineName'])) {
      // Sanitize the cuisine name to prevent SQL injection
      $cuisineName = $conn->real_escape_string($_POST['cuisineName']);
      
      // Query to find CuisineID by CuisineName
      $sql = "SELECT CuisineID FROM cuisines WHERE CuisineName = ?";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("s", $cuisineName);
      $stmt->execute();
      $result = $stmt->get_result();
      
      if ($result->num_rows > 0) {
          $row = $result->fetch_assoc();
          // Extract the CuisineID
          $cuisineID = $row['CuisineID'];
      } else {
          // Handle case where cuisine is not found
          echo "Cuisine not found.";
          exit();
      }
  } else {
      // Handle case where cuisineName is not set
      echo "Cuisine name is missing.";
      exit();
  }

  // Get form data
  $userID = $_SESSION['user_id'];
  $recipeName = isset($_POST['recipeName']) ? $conn->real_escape_string($_POST['recipeName']) : '';
  $ingredients = isset($_POST['ingredients']) ? $conn->real_escape_string($_POST['ingredients']) : '';
  $procedure = isset($_POST['procedure']) ? $conn->real_escape_string($_POST['procedure']) : '';
  $recipeImage = '';

  // Check if recipeImage is set in $_FILES array and move it to the uploads directory
  if (isset($_FILES['recipeImage']) && $_FILES['recipeImage']['error'] === 0) {
      $uploadDir = 'uploads/';
      $filename = uniqid() . '_' . $_FILES['recipeImage']['name'];
      $targetPath = $uploadDir . $filename;
      if (move_uploaded_file($_FILES['recipeImage']['tmp_name'], $targetPath)) {
          $recipeImage = $filename;
      } else {
          echo "Error uploading file.";
          exit();
      }
  }

  // Prepare SQL statement
  $sql = "INSERT INTO recipes (UserID, CuisineID, RecipeName, Ingredients, `Procedure`, Recipe_Image, ApprovalStatus, DateSubmitted) 
          VALUES (?, ?, ?, ?, ?, ?, 'Pending', NOW())";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("iissss", $userID, $cuisineID, $recipeName, $ingredients, $procedure, $recipeImage);
  if ($stmt->execute()) {
    echo "<script>alert('Recipe added successfully.');</script>";
} else {
    echo "<script>alert('Error adding recipe.');</script>";
}

}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Recipe</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<section id="headersection">
    <div>
      <ul id="navigationbar">
        <li><a href="index.php">Home</a></li>
        <li><a href="contact.php">Contact</a></li>
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

<form action="addrecipe.php" method="post" enctype="multipart/form-data">
        <h2>Add Recipe</h2>
        <label for="recipeName">Recipe Name:</label>
        <input type="text" id="recipeName" name="recipeName" required>

        <label for="cuisineName">Cuisine Name:</label>
        <select id="cuisineName" name="cuisineName" required>
            <?php
            // Fetch available cuisine IDs and names from the database
            $sql = "SELECT CuisineID, CuisineName FROM cuisines";
            $result = $conn->query($sql);

            // Check if there are any cuisines available
            if ($result->num_rows > 0) {
                // Output each cuisine as an option in the dropdown menu
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['CuisineName'] . "'>" . $row['CuisineName'] . "</option>";
                }
            } else {
                echo "<option value=''>No cuisines available</option>";
            }

            // Free the result set
            $result->free_result();
            ?>
        </select>

        <!-- Hidden input field to store the selected cuisine ID -->
        <input type="hidden" id="cuisineID" name="cuisineID">

        <label for="ingredients">Ingredients:</label>
        <textarea id="ingredients" name="ingredients" rows="4" required></textarea>

        <label for="procedure">Procedure:</label>
        <textarea id="procedure" name="procedure" rows="6" required></textarea>

        <label for="recipeImage">Recipe Image:</label>
        <input type="file" id="recipeImage" name="recipeImage" required>

        <input type="submit" value="Add Recipe">
    </form>

    <style>
        /* body {
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        } */

        form {
            background-color: white;
            border: 1px solid #ddd;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            border-radius: 5px;
            width: 800px;
            margin: 50px auto;
        }

        h2 {
            text-align: center;
            font-family: Arial, sans-serif;
            color: #333;
            margin-bottom: 20px;
        }

        label {
            font-family: Arial, sans-serif;
            color: #555;
            font-size: 16px;
        }

        input[type="text"],
        input[type="file"],
        select,
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 3px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }
    </style>
     <footer class="footer-section">
    <h5 style="text-align: center; font-size: 24px; color: #333; margin-top: 20px;">Thank You For Your Visit</h5>
  </footer>
</body>
</html>