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

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT * FROM admin WHERE UserName='$username' AND Password='$password'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $_SESSION['username'] = $username; 
    
    if ($username == 'insert') {
        $redirectUrl = 'insert_user/insert_data.php';
    } else {
        $redirectUrl = 'dashboard_admin.php';
    }
    
    $response = array('success' => true, 'redirectUrl' => $redirectUrl);
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($response);
?>