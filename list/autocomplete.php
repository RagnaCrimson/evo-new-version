<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "datastore_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode(['error' => 'Connection failed: ' . $conn->connect_error]);
    exit();
}

$term = isset($_GET['term']) ? $conn->real_escape_string($_GET['term']) : '';

$sql = "SELECT V_Name FROM view WHERE V_Name LIKE ? LIMIT 10";
$stmt = $conn->prepare($sql);
$likeTerm = '%' . $term . '%';
$stmt->bind_param("s", $likeTerm);
$stmt->execute();
$stmt->bind_result($name);

$suggestions = [];
while ($stmt->fetch()) {
    $suggestions[] = $name;
}
$stmt->close();
$conn->close();

echo json_encode($suggestions);
?>
