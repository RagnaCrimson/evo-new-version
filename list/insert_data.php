<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Data</title>
    <link href="../css/dashboard_styles.css" rel="stylesheet">
    <link href="../css/custom-select.css" rel="stylesheet">
    <link href="../css/insert.css" rel="stylesheet">
</head>
<body>
    <?php include '../header.php'; ?>

    <div class="container">
        <h1>เพิ่มข้อมูล</h1>
        <form action="upload.php" method="POST" onsubmit="showSuccessPopup()" enctype="multipart/form-data">
            <div class="row">
                <div class="field">
                    <label for="V_Name">ชื่อหน่วยงาน :</label>
                    <input type="text" id="V_Name" name="V_Name" autocomplete="off" required>
                    <div id="duplicateMessage" style="color: red; display: none;"></div>
                    <div id="suggestions" class="suggestions-container"></div>
                </div>
                <div class="field">
                    <label for="V_Province">จังหวัด :</label>
                    <input type="text" id="V_Province" name="V_Province" required>
                </div>
                <div class="field">
                    <label for="V_District">อำเภอ :</label>
                    <input type="text" id="V_District" name="V_District" required>
                </div>
                <div class="field">
                    <label for="V_SubDistrict">ตำบล :</label>
                    <input type="text" id="V_SubDistrict" name="V_SubDistrict">
                </div>
            </div>

            <div class="row">
                <div class="field half-width">
                    <label for="V_location">ตำแหน่ง GPS Link google map หรือ พิกัด (ถ้ามี) :</label>
                    <input type="text" id="V_location" name="V_location">
                </div>
            </div>

            <div class="row">
                <div class="field half-width">
                    <label for="V_ExecName">ชื่อผู้บริหาร :</label>
                    <input type="text" id="V_ExecName" name="V_ExecName">
                </div>
                <div class="field">
                    <label for="V_ExecPhone">เบอร์ผู้บริหาร :</label>
                    <input type="text" id="V_ExecPhone" name="V_ExecPhone">
                </div>
                <div class="field">
                    <label for="V_ExecMail">อีเมลผู้บริหาร :</label>
                    <input type="text" id="V_ExecMail" name="V_ExecMail">
                </div>
            </div>

            <div class="row">
                <div class="field half-width">
                    <label for="V_CoordName1">ชื่อผู้ประสานงาน :</label>
                    <input type="text" id="V_CoordName1" name="V_CoordName1">
                </div>
                <div class="field">
                    <label for="V_CoordPhone1">เบอร์ผู้ประสานงาน :</label>
                    <input type="text" id="V_CoordPhone1" name="V_CoordPhone1">
                </div>
                <div class="field">
                    <label for="V_CoordMail1">อีเมลผู้ประสานงาน :</label>
                    <input type="text" id="V_CoordMail1" name="V_CoordMail1">
                </div>
            </div>

            <div class="row">
                <div class="field">
                    <label for="serial_number">รหัสเครื่องวัด :</label>
                    <input type="text" id="serial_number" name="serial_number" maxlength="10">
                </div>
                <div class="field">
                    <label for="CA_code">หมายเลขผู้ใช้ไฟฟ้า :</label>
                    <input type="text" id="CA_code" name="CA_code" maxlength="12">
                </div>
            </div>

            <div class="row">
                <div class="field">
                    <label for="B_M12">ระบุเดือนบิลค่าไฟ :</label>
                    <input type="date" id="B_M12" name="B_M12">
                </div>
                <div class="field">
                    <label for="V_Electric_per_month">ค่าไฟ :</label>
                    <input type="number" step="any" placeholder="ค่าไฟ 000.00" id="V_Electric_per_month" name="V_Electric_per_month">
                </div>
            </div>

            <div class="row">
                <div class="field full-width">
                    <label for="V_comment">หมายเหตุ :</label>
                    <textarea id="V_comment" name="V_comment"></textarea>
                </div>
            </div>

            <div class="row">
                <div class="field">
                    <label for="V_Sale">ทีมฝ่ายขาย :</label>
                    <input type="text" id="V_Sale" name="V_Sale" required>
                </div>
                <div class="field">
                    <label for="V_Date">วันที่ได้รับเอกสาร :</label>
                    <input type="date" id="V_Date" name="V_Date" required>
                </div>
                <div class="field">
                    <label for="T_Status">สถานะ :</label>
                    <select id="T_Status" name="T_Status" required>
                        <option value="">-- เลือกสถานะ --</option>
                        <option value="ได้รับเอกสาร">ได้รับเอกสาร</option>
                        <option value="นำส่งการไฟฟ้า">นำส่งการไฟฟ้า</option>
                        <option value="ตอบรับ">ตอบรับ</option>
                        <option value="ส่งมอบงาน">ส่งมอบงาน</option>
                        <option value="ไม่ผ่าน">ไม่ผ่าน</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="field half-width">
                    <label for="file">เลือกไฟล์ :</label>
                    <input type="file" name="file" id="file" accept="application/pdf" required>
                </div>
            </div>

            <div class="button-group">
                <button type="submit">Submit</button>
                <button type="reset" onclick="confirmReset(event)">Reset</button>
            </div>
        </form>
    </div>
    <script>
        function confirmReset(event) {
            if (!confirm("ต้องการที่จะล้างข้อมูลหรือไม่?")) {
                event.preventDefault();
            }
        }
    </script>
</body>
</html>
