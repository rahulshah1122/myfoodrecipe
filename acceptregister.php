<?php 
require_once 'connect_db.php';

// Get form data
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$contact = $_POST['contact'];

// Check if email or contact already exists
$sql_check = "SELECT * FROM users WHERE Email = '$email' OR user_contact = '$contact'";
$result_check = $conn->query($sql_check);

if ($result_check->num_rows > 0) {
    echo "Error: Email or Contact already exists";
} else {
    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare SQL statement
    $sql = "INSERT INTO users (Username, Email, Password, RegistrationDate, user_contact) 
            VALUES ('$username', '$email', '$hashed_password', NOW(), '$contact')";

    // Execute SQL statement
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close database connection
$conn->close();
?>
