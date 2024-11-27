<?php 
require_once 'connect_db.php';
session_start();
if (isset($_SESSION['admin_id'])) {
    echo '<script>alert("You are logged in as admin.");</script>';
}else{
$user_id= isset($_SESSION['user_id']);
}
?>

<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];
    $recipe_id = $_POST['recipe_id'];

    // Validate and sanitize input data (you might want to add more validation)
    $rating = intval($rating); // Convert rating to integer
    $comment = htmlspecialchars($comment); // Sanitize comment

    // Insert rating into ratings table
    $stmt_rating = $conn->prepare("INSERT INTO ratings (RecipeID, UserID, Rating, RatingDate) VALUES (?, ?, ?, NOW())");
    $stmt_rating->bind_param("iii", $recipe_id, $user_id, $rating);

    // Execute rating insertion
    if ($stmt_rating->execute() === TRUE) {
    //     echo "Rating submitted successfully.";
    // } else {
    //     echo "Error: " . $stmt_rating->error;
    }

    // Insert comment into comments table
    $stmt_comment = $conn->prepare("INSERT INTO comments (RecipeID, UserID, Comment, CommentDate) VALUES (?, ?, ?, NOW())");
    $stmt_comment->bind_param("iis", $recipe_id, $user_id, $comment);

    // Execute comment insertion
    if ($stmt_comment->execute() === TRUE) {
        echo '<script>alert("Comment submitted successfully.");</script>';
        echo '<script>window.location.href = document.referrer;</script>';
        

    } else {
        echo "Error: " . $stmt_comment->error;
    }

    // Close connections
    $stmt_rating->close();
    $stmt_comment->close();
    $conn->close();
} else {
    // If someone tries to access this page directly without submitting the form
    echo "Invalid request.";
}
?>
