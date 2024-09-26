<?php
session_start();

include 'connect.php';

require_once 'session.php';

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
    <title>Header</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/dashboard_styles.css" rel="stylesheet">
    <link href="css/custom-select.css" rel="stylesheet">
    <script src="js/script.js"></script>
</head>
<body>
    <div class="sidebar">
        <div class="brand">
            <img src="/newevo/img/admin.png" alt="Logo">
            <span><?php echo $_SESSION['name']; ?></a></span>
        </div>
        <a href="/newevo/dashboard_admin.php">Dashboard</a>

        <div class="dropdown">
            <button class="dropdown-btn">รายการ 
                <i class="fa fa-caret-down"></i>
            </button>
            <div class="dropdown-container">
                <a href="/newevo/list/insert_data.php">เพิ่มข้อมูล</a>
                <a href="/newevo/list/data_view.php">ดูข้อมูลทั้งหมด</a>
                <a href="/newevo/list/status_view.php">ดูสถานะ</a>
            </div>
        </div>

        <div class="dropdown">
            <button class="dropdown-btn">Report 
                <i class="fa fa-caret-down"></i>
            </button>
            <div class="dropdown-container">
                <a href="/newevo/report/allname.php" target="_blank">รายชื่อทั้งหมด</a>
                <a href="/newevo/report/sale_name.php">เลือกทีมฝ่ายขาย</a>
            </div>
        </div>

        <a href="#" onclick="confirmLogout()">ลงชื่อออก</a>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var dropdown = document.querySelectorAll(".dropdown-btn");
            
            dropdown.forEach(function(btn) {
                btn.addEventListener("click", function() {
                    this.classList.toggle("active");
                    var dropdownContent = this.nextElementSibling;
                    if (dropdownContent.style.display === "block") {
                        dropdownContent.style.display = "none";
                    } else {
                        dropdownContent.style.display = "block";
                    }
                });
            });
        });
    </script>
</body>
</html>