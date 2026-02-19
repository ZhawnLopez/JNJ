<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jnj_inasal";

// create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

// this is for cashierint.php u can just integrate other db.phps from other files if needed