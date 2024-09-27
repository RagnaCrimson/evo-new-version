<?php
include '../connect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Data</title>
    <link href="../css/dashboard_styles.css" rel="stylesheet">
    <link href="../css/custom-select.css" rel="stylesheet">
</head>
<body>
    <?php include '../header.php'; ?>
    <div class="main-content">
        <div class="container">
            <h2>ดูรายงาน</h2>
            <form action="report_sale_name.php" method="post" target="_blank">
                <label for="sales_team">ทีมฝ่ายขาย</label>
                <select id="sales_team" name="sales_team">
                    <option value="">-- เลือก --</option>
                    <option value="คุณพิเย็น">คุณพิเย็น</option>
                    <option value="ดร.อี๊ด">ดร.อี๊ด</option>
                    <option value="VJK">VJK</option>
                    <option value="VJ">VJ</option>
                    <option value="คุณชนินทร์">คุณชนินทร์</option>
                    <option value="คุณเรืองยศ">คุณเรืองยศ</option>
                    <option value="คุณปริม">คุณปริม</option>
                    <option value="ตา(สตึก)">ตา(สตึก)</option>
                    <option value="คุณอั๋น(สตึก)">คุณอั๋น(สตึก)</option>
                    <option value="คุณตา / อั๋น">คุณตา / อั๋น</option>
                </select>
                <div class="radio-group">
                    <div class="button-group">
                        <button type="submit" name="view" class="btcolor" target="_blank">Submit</button>
                    </div>
                </div>
            </form>
        </div>         
    </div>
</body>
</html>