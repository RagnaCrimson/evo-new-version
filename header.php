<?php
session_start();

include 'connect.php';
// require_once 'session.php';

// check_login();

$username = $_SESSION['username'];
$sql = "SELECT Name FROM admin WHERE UserName='$username'";
$result = $objConnect->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $_SESSION['name'] = $row['Name'];
} else {
    echo "Name not found.";
}

$objConnect->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/dashboard_styles.css" rel="stylesheet">
    <script src="js/logout.js"></script>
</head>
<body>
    <div class="sidebar">
        <div class="brand">
            <img src="img/admin.png" alt="Logo">
            <span><?php echo $_SESSION['name']; ?></a></span>
        </div>
        <a href="dashboard_admin.php">Dashboard</a>
        <a a href="#">รายการ &dtrif;</a>
            <ul class="dropdown">
                <li><a href="../data_view.php">ดูข้อมูลทั้งหมด</a></li>
                <li><a href="../index.php">เพิ่มข้อมูล</a></li>
                <li><a href="../status_view.php">ดูสถานะ</a></li>
            </ul>
        <a href="#">Report &dtrif;</a>
            <ul class="dropdown">
                <li><a href="report/reportday.php">เลือกวันที่</a></li>
                <li><a href="report/allname.php" target="_blank">รายชื่อทั้งหมด</a></li>
                <li><a href="report/sale_name.php">เลือกทีมฝ่ายขาย</a></li>
                <!-- <li><a href="#">ตามสถานะ</a></li>
                <li><a href="#">บริษัทผู้รับเหมา</a></li> -->
            </ul>    
        <a onclick="confirmLogout()">ลงชื่ออก</a>
    </div>
</body>
</html>