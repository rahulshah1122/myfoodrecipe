<?php
$host = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "my_recipe_book";

//create connection
$conn = new mysqli($host,$dbusername,$dbpassword,$dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
?>