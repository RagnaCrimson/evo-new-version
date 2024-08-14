<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_evo";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
?>
