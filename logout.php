<?php
session_start();

// Unset all of the session variables
$_SESSION = array();

// If a session is active, destroy it
if (session_status() === PHP_SESSION_ACTIVE) {
    session_destroy();
}

// Redirect the user to a login page or any other appropriate page after logout
header("Location: login.php");
exit;
?>
