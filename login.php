<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "datastore_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $inputUsername = $_POST['username'];
    $inputPassword = $_POST['password'];

    if ($inputUsername === 'admin111') {
        // Redirect to admin dashboard
        header("Location: dashboard_admin.php");
        exit();
    } else {
        // Redirect to other page
        header("Location: other_page.php");
        exit();
    }
}
?>
