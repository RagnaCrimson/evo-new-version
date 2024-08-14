<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Data</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/insert_data_styles.css" rel="stylesheet">
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container mt-5">
        <h1 class="mb-4">เพิ่มข้อมูล</h1>

        <!-- Form for inserting data -->
        <div class="card mb-4">
            <div class="card-header">เพิ่มข้อมูล</div>
            <div class="card-body">
                <form action="insert_data.php" method="POST" enctype="multipart/form-data">

                    <!-- Insert into View Table -->
                    <h4>ข้อมูลหน่วยงาน</h4>
                    <div class="form-group">
                        <label for="v_name">ชื่อหน่วยงาน</label>
                        <input type="text" class="form-control" id="v_name" name="v_name" required>
                    </div>
                    <div class="form-group">
                        <label for="v_province">จังหวัด</label>
                        <input type="text" class="form-control" id="v_province" name="v_province" required>
                    </div>
                    <div class="form-group">
                        <label for="v_district">อำเภอ</label>
                        <input type="text" class="form-control" id="v_district" name="v_district" required>
                    </div>
                    <div class="form-group">
                        <label for="v_subdistrict">ตำบล</label>
                        <input type="text" class="form-control" id="v_subdistrict" name="v_subdistrict">
                    </div>
                    <div class="form-group">
                        <label for="v_exec_name">ชื่อผู้บริหาร</label>
                        <input type="text" class="form-control" id="v_exec_name" name="v_exec_name" required>
                    </div>
                    <div class="form-group">
                        <label for="v_exec_phone">เบอร์ผู้บริหาร</label>
                        <input type="text" class="form-control" id="v_exec_phone" name="v_exec_phone" required>
                    </div>
                    <div class="form-group">
                        <label for="v_exec_mail">อีเมลผู้บริหาร</label>
                        <input type="email" class="form-control" id="v_exec_mail" name="v_exec_mail">
                    </div>
                    <div class="form-group">
                        <label for="v_coord_name1">ผู้ประสานงาน</label>
                        <input type="text" class="form-control" id="v_coord_name1" name="v_coord_name1">
                    </div>
                    <div class="form-group">
                        <label for="v_coord_phone1">เบอร์ผู้ประสานงาน</label>
                        <input type="text" class="form-control" id="v_coord_phone1" name="v_coord_phone1">
                    </div>
                    <div class="form-group">
                        <label for="v_coord_mail1">อีเมลผู้ประสานงาน</label>
                        <input type="email" class="form-control" id="v_coord_mail1" name="v_coord_mail1">
                    </div>
                    <div class="form-group">
                        <label for="v_sale">ทีมฝ่ายขาย</label>
                        <input type="text" class="form-control" id="v_sale" name="v_sale" required>
                    </div>
                    <div class="form-group">
                        <label for="v_date">วันที่ได้รับเอกสาร</label>
                        <input type="date" class="form-control" id="v_date" name="v_date" required>
                    </div>
                    <div class="form-group">
                        <label for="v_electric_per_year">ค่าไฟต่อปี</label>
                        <input type="number" class="form-control" id="v_electric_per_year" name="v_electric_per_year" step="0.01">
                    </div>
                    <div class="form-group">
                        <label for="v_electric_per_month">ค่าไฟต่อเดือน</label>
                        <input type="number" class="form-control" id="v_electric_per_month" name="v_electric_per_month" step="0.01">
                    </div>
                    <div class="form-group">
                        <label for="v_peak_year">ค่า peak ต่อปี</label>
                        <input type="number" class="form-control" id="v_peak_year" name="v_peak_year" step="0.01">
                    </div>
                    <div class="form-group">
                        <label for="v_peak_month">ค่า peak ต่อเดือน</label>
                        <input type="number" class="form-control" id="v_peak_month" name="v_peak_month" step="0.01">
                    </div>
                    <div class="form-group">
                        <label for="v_comment">หมายเหตุ</label>
                        <textarea class="form-control" id="v_comment" name="v_comment"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="v_file">อัพโหลดไฟล์เอกสาร</label>
                        <input type="file" class="form-control-file" id="v_file" name="v_file" accept=".pdf" required>
                    </div>

                    <!-- Insert into Bill Table -->
                    <h4>ข้อมูลบิล</h4>
                    <div class="form-group">
                        <label for="ca_code">เลขหนังสือตอบรับ</label>
                        <input type="text" class="form-control" id="ca_code" name="ca_code" required>
                    </div>
                    <div class="form-group">
                        <label for="serial_number">หมายเลขผู้ใช้ไฟฟ้า</label>
                        <input type="text" class="form-control" id="serial_number" name="serial_number" required>
                    </div>
                    <div class="form-group">
                        <label for="billing_month">เดือนที่บิล</label>
                        <input type="date" class="form-control" id="billing_month" name="billing_month" required>
                    </div>
                    <div class="form-group">
                        <label for="billing_amount">จำนวนเงิน</label>
                        <input type="number" class="form-control" id="billing_amount" name="billing_amount" step="0.01" required>
                    </div>

                    <!-- Insert into Status History Table -->
                    <h4>สถานะ</h4>
                    <div class="form-group">
                        <label for="status">สถานะปัจจุบัน</label>
                        <input type="text" class="form-control" id="status" name="status" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
