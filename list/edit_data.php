<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขข้อมูล</title>
    <link href="../css/dashboard_styles.css" rel="stylesheet">
    <link href="../css/custom-select.css" rel="stylesheet">
    <link href="../css/edit.css" rel="stylesheet">
    <script src="../js/logout.js"></script>
</head>
<body>
    <?php include '../header.php'; ?>
    <?php include 'edit_process.php'; ?>

    <div class="container">
        <h1>แก้ไขข้อมูล: <?php echo htmlspecialchars($data['V_Name'] ?? ''); ?></h1>
        
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="V_Name">ชื่อหน่วยงาน</label>
                <input type="text" id="V_Name" name="data[V_Name]" value="<?php echo htmlspecialchars($data['V_Name'] ?? ''); ?>" required>
            </div>
            <div class="form-group">
                <label for="V_Province">จังหวัด</label>
                <input type="text" id="V_Province" name="data[V_Province]" value="<?php echo htmlspecialchars($data['V_Province'] ?? ''); ?>" required>
            </div>
            <div class="form-group">
                <label for="V_District">อำเภอ</label>
                <input type="text" id="V_District" name="data[V_District]" value="<?php echo htmlspecialchars($data['V_District'] ?? ''); ?>" required>
            </div>
            <div class="form-group">
                <label for="V_SubDistrict">ตำบล</label>
                <input type="text" id="V_SubDistrict" name="data[V_SubDistrict]" value="<?php echo htmlspecialchars($data['V_SubDistrict'] ?? ''); ?>" required>
            </div>
            <div class="form-group">
                <label for="V_Sale">ทีมฝ่ายขาย</label>
                <input type="text" id="V_Sale" name="data[V_Sale]" value="<?php echo htmlspecialchars($data['V_Sale'] ?? ''); ?>" required>
            </div>
            <!-- Additional Fields -->
            <div class="form-group">
                <label for="V_ExecName">ชื่อผู้บริหาร</label>
                <input type="text" id="V_ExecName" name="data[V_ExecName]" value="<?php echo htmlspecialchars($data['V_ExecName'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label for="V_ExecPhone">เบอร์ผู้บริหาร</label>
                <input type="text" id="V_ExecPhone" name="data[V_ExecPhone]" value="<?php echo htmlspecialchars($data['V_ExecPhone'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label for="V_ExecMail">อีเมลผู้บริหาร</label>
                <input type="email" id="V_ExecMail" name="data[V_ExecMail]" value="<?php echo htmlspecialchars($data['V_ExecMail'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label for="V_CoordName1">ชื่อผู้ประสานงาน 1</label>
                <input type="text" id="V_CoordName1" name="data[V_CoordName1]" value="<?php echo htmlspecialchars($data['V_CoordName1'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label for="V_CoordPhone1">เบอร์ผู้ประสานงาน 1</label>
                <input type="text" id="V_CoordPhone1" name="data[V_CoordPhone1]" value="<?php echo htmlspecialchars($data['V_CoordPhone1'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label for="V_CoordMail1">อีเมลผู้ประสานงาน 1</label>
                <input type="email" id="V_CoordMail1" name="data[V_CoordMail1]" value="<?php echo htmlspecialchars($data['V_CoordMail1'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label for="V_Date">วันที่ได้รับเอกสาร</label>
                <input type="date" id="V_Date" name="data[V_Date]" value="<?php echo htmlspecialchars($data['V_Date'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label for="CA_code">หมายเลขผู้ใช้ไฟ</label>
                <input type="number" id="CA_code" name="data[CA_code]" value="<?php echo htmlspecialchars($data['CA_code'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label for="B_M12">วันที่บิลค่าไฟ</label>
                <input type="date" id="B_M12" name="data[B_M12]" value="<?php echo htmlspecialchars($data['B_M12'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label for="V_Electric_per_month">ค่าไฟ/เดือน (บาท)</label>
                <input type="number" id="V_Electric_per_month" name="data[V_Electric_per_month]" value="<?php echo htmlspecialchars($data['V_Electric_per_month'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label for="V_comment">หมายเหตุ</label>
                <textarea id="V_comment" name="data[V_comment]"><?php echo htmlspecialchars($data['V_comment'] ?? ''); ?></textarea>
            </div>
            <div class="form-group">
                <label for="V_location">GPS</label>
                <input type="text" id="V_location" name="data[V_location]" value="<?php echo htmlspecialchars($data['V_location'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label for="pdf_file">ไฟล์เอกสาร (PDF)</label>
                <input type="file" id="pdf_file" name="pdf_file" accept=".pdf">
                <?php if (!empty($data['filename'])): ?>
                    <a href="../uploads/<?php echo htmlspecialchars($data['filename']); ?>" target="_blank">View Current PDF</a>
                <?php endif; ?>
            </div>
            <input type="hidden" name="V_ID" value="<?php echo htmlspecialchars($V_ID); ?>">
            <button type="submit" name="submit">Update</button>
        </form>
    </div>
</body>
</html>
