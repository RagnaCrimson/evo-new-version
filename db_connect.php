<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "datastore_db";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
?>
