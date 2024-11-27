<?php
require_once 'connect_db.php';
session_start();
// Fetch recipe details based on recipe_id from the URL
if(isset($_GET['recipe_id'])) {
    $recipe_id = $_GET['recipe_id'];
    // Fetch recipe details
    $recipe_query = "SELECT r.*, u.Username, u.user_contact FROM recipes r INNER JOIN users u ON r.UserID = u.UserID WHERE r.RecipeID = $recipe_id";

    $recipe_result = $conn->query($recipe_query);
    if (!$recipe_result) {
        die("Error fetching recipe details: " . $conn->error);
    }
    

    if ($recipe_result->num_rows > 0) {
        $recipe_row = $recipe_result->fetch_assoc();
        $recipe_name = $recipe_row['RecipeName'];
        $recipe_image = $recipe_row['Recipe_Image'];
        $username = $recipe_row['Username'];
        $updated_date = $recipe_row['DateSubmitted'];
        $contact_number = $recipe_row['user_contact'];
        $ingredients = $recipe_row['Ingredients'];
        $procedure = $recipe_row['Procedure'];
    } else {
        echo "Recipe not found";
        exit; // Terminate script
    }

    // Fetch average rating
    $rating_query = "SELECT AVG(Rating) AS avg_rating FROM ratings WHERE RecipeID = $recipe_id";
    $rating_result = $conn->query($rating_query);
    $avg_rating = ($rating_result->num_rows > 0) ? $rating_result->fetch_assoc()['avg_rating'] : 0;

    // Fetch comments
    $comment_query = "SELECT c.*, u.Username FROM comments c INNER JOIN users u ON c.UserID = u.UserID WHERE c.RecipeID = $recipe_id";
    $comment_result = $conn->query($comment_query);
} else {
    echo "Recipe ID not provided";
    exit; // Terminate script
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe Book - <?php echo $recipe_name; ?></title>
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
    <section id="categorybox" class="section-p1">
    </section>
  </div>

    <div class="container">
        <!-- Recipe Image -->
        <div class="recipe-image">
            <img src="data:image/jpeg;base64,<?php echo base64_encode($recipe_image); ?>" alt="<?php echo $recipe_name; ?> Image">
        </div>

       <!-- Recipe Name -->
<h2 class="recipe-name"><?php echo $recipe_name; ?></h2>


        <!-- User Information -->
        <div class="user-info">
            <p>By: <?php echo $username; ?></p>
            <p>Contact: <?php echo $contact_number; ?></p>
            <p>Updated Date: <?php echo $updated_date; ?></p>
            
        </div>

<!-- Ingredients -->
<div style="margin-top: 10px;">
    <h3 style="margin-bottom: 5px;">Ingredients:</h3>
    <p><?php echo $ingredients; ?></p>
</div>

<!-- Procedure -->
<div style="margin-top: 20px;">
    <h3 style="margin-bottom: 5px;">Procedure:</h3>
    <p><?php echo $procedure; ?></p>
</div>


        <!-- Ratings and Comments -->
        <div class="ratings-comments">
            <h3>Ratings and Comments</h3>
            <p>Average Rating: <?php echo number_format($avg_rating, 1); ?></p>
            
            <div class="comments">
                <?php
                if ($comment_result->num_rows > 0) {
                    while ($comment_row = $comment_result->fetch_assoc()) {
                        echo '<div class="comment">';
                        echo '<p><strong>' . $comment_row['Username'] . ':</strong> ' . $comment_row['Comment'] . '</p>';
                        echo '</div>';
                    }
                } else {
                    echo "<p>No comments yet</p>";
                }
                ?>
            </div>
        </div>

        <!-- Rating and Comment Form -->
        <div class="rating-comment-form">
            <h3>Rate and Comment</h3>
            <form action="submit_comment.php" method="post">
                <label for="rating">Rating:</label>
                <input type="number" name="rating" id="rating" min="1" max="5" required>
                <br>
                <label for="comment">Comment:</label>
                <textarea name="comment" id="comment" cols="30" rows="5" required></textarea>
                <br>
                <input type="hidden" name="recipe_id" value="<?php echo $recipe_id; ?>">
                <input type="submit" value="Submit">
            </form>
        </div>
    </div>
</body>
<footer class="footer-section">
    <h5 style="text-align: center; font-size: 24px; color: #333; margin-top: 20px;">Thank You For Your Visit</h5>
  </footer>

<style>


body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #fff;
}

.container {
    max-width: 800px;
    margin: 20px auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.recipe-image img {
    width: 100%;
    height: auto;
    border-radius: 8px;
    margin-bottom: 20px;
}

.recipe-name {
    color: #333;
}

.user-info p, p{
    margin: 5px 0;
    color: #666;
}

.ratings-comments {
    margin-top: 30px;
}

.comments {
    margin-top: 10px;
}

.comment {
    background-color: #f9f9f9;
    padding: 10px;
    margin-bottom: 10px;
    border-radius: 5px;
}

.comment p {
    margin: 0;
}

.comment-actions {
    margin-top: 5px;
}

.edit-comment,
.delete-comment {
    cursor: pointer;
    color: #007bff;
    margin-right: 10px;
}

.rating-comment-form {
    margin-top: 30px;
}

.rating-comment-form h3 {
    color: #333;
    margin-bottom: 10px;
}

.rating-comment-form label {
    display: block;
    margin-bottom: 5px;
    color: #333;
}

.rating-comment-form input[type="number"],
.rating-comment-form textarea {
    width: 100%;
    padding: 8px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.rating-comment-form input[type="submit"] {
    background-color: #007bff;
    color: #fff;
    border: none;
    padding: 10px 20px;
    cursor: pointer;
    border-radius: 5px;
}

.rating-comment-form input[type="submit"]:hover {
    background-color: #0056b3;
}
</style>
</html>
