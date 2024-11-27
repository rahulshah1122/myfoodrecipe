<?php
$host = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "homstall";

//create connection
$conn = new mysqli($host,$dbusername,$dbpassword,$dbname);
if(mysqli_connect_error()){
    die('Connect Error('.mysquli_connect_errno().')'
    .mysqli_connect_error());
}
?>