<?php
session_start();
// Check if the user is an admin
if (!isset($_SESSION['admin_id'])) {
    // Redirect to login page or any other page
    header("Location: login.php");
    exit();
}

require_once 'connect_db.php';

// Function to fetch all recipes
function getAllRecipes($conn) {
    $sql = "SELECT * FROM recipes";
    $result = $conn->query($sql);
    $recipes = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $recipes[] = $row;
        }
    }
    return $recipes;
}

// Function to update recipe status
function updateRecipeStatus($conn, $recipeID, $status) {
    $sql = "UPDATE recipes SET ApprovalStatus = '$status' WHERE RecipeID = $recipeID";
    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }
}

// Check if the form is submitted to update status
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['recipe_id'], $_POST['status'])) {
    $recipeID = $_POST['recipe_id'];
    $status = $_POST['status'];
    // Update the recipe status
    if (updateRecipeStatus($conn, $recipeID, $status)) {
        echo '<script>alert("Status updated successfully.");</script>';
    } else {
        echo "Error updating status.";
    }
}

// Fetch all recipes
$recipes = getAllRecipes($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
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
        <li><a href="logout.php">Logout</a></li> 
      </ul>
    </div>
  </section>

  <div class="background">
  <h2 style="font-size: 30px; 
  width:240px; 
  color: #fff; 
  margin-top: 10px; 
  margin-bottom: 20px; 
  margin-left: 32px; 
  font-weight: bold; 
  padding: 10px 20px; 
  border: 2px solid #000; 
  background-color:rgba(0, 0, 0, 0.5);">Admin Dashboard</h2>
    <section id="categorybox" class="section-p1">
    </section>

  </div>
    <table style="width:80%; border-collapse: collapse; margin:50px auto;">
  <tr>
    <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Recipe Name</th>
    <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Ingredients</th>
    <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Procedure</th>
    <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Approval Status</th>
    <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Action</th>
  </tr>
  <?php foreach ($recipes as $recipe): ?>
  <tr>
    <td style="border: 1px solid #ddd; padding: 8px;"><?php echo $recipe['RecipeName']; ?></td>
    <td style="border: 1px solid #ddd; padding: 8px;"><?php echo $recipe['Ingredients']; ?></td>
    <td style="border: 1px solid #ddd; padding: 8px;"><?php echo $recipe['Procedure']; ?></td>
    <td style="border: 1px solid #ddd; padding: 8px;"><?php echo $recipe['ApprovalStatus']; ?></td>
    <td style="border: 1px solid #ddd; padding: 8px;">
      <form action="" method="post">
        <input type="hidden" name="recipe_id" value="<?php echo $recipe['RecipeID']; ?>">
        <select name="status" style="padding: 6px;">
          <option value="Pending">Pending</option>
          <option value="Approved">Approved</option>
          <option value="Rejected">Rejected</option>
        </select>
        <input type="submit" value="Update" style="padding: 6px;">
      </form>
    </td>
  </tr>
  <?php endforeach; ?>
</table>

    
 

  <footer class="footer-section">
    <h5 style="text-align: center; font-size: 24px; color: #333; margin-top: 20px;">Thank You For Your Visit</h5>
  </footer>
</body>
</html>
