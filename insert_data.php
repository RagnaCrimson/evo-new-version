<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Data Form</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .form-container {
            margin: 20px;
            padding: 30px;
            background-color: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
        }
        .form-title {
            text-align: center;
            margin-bottom: 30px;
            font-size: 24px;
            color: #007bff;
        }
        .form-row {
            margin-bottom: 15px;
        }
        .form-group label {
            font-weight: bold;
        }
        .submit-btn {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="form-container">
            <h2 class="form-title">Insert Data</h2>

            <form method="POST" enctype="multipart/form-data">
                <!-- Organization Information -->
                <div class="form-row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="V_Name">ชื่อหน่วยงาน:</label>
                            <input type="text" id="V_Name" name="V_Name" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="V_Province">จังหวัด:</label>
                            <input type="text" id="V_Province" name="V_Province" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="V_District">อำเภอ:</label>
                            <input type="text" id="V_District" name="V_District" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="V_SubDistrict">ตำบล:</label>
                            <input type="text" id="V_SubDistrict" name="V_SubDistrict" class="form-control">
                        </div>
                    </div>
                </div>

                <!-- Executive Information -->
                <div class="form-row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="V_ExecName">ชื่อผู้บริหาร:</label>
                            <input type="text" id="V_ExecName" name="V_ExecName" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="V_ExecPhone">เบอร์ผู้บริหาร:</label>
                            <input type="text" id="V_ExecPhone" name="V_ExecPhone" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="V_ExecMail">อีเมลผู้บริหาร:</label>
                            <input type="email" id="V_ExecMail" name="V_ExecMail" class="form-control">
                        </div>
                    </div>
                </div>

                <!-- Coordinator Information -->
                <div class="form-row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="V_CoordName1">ชื่อผู้ประสานงาน:</label>
                            <input type="text" id="V_CoordName1" name="V_CoordName1" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="V_CoordPhone1">เบอร์ผู้ประสานงาน:</label>
                            <input type="text" id="V_CoordPhone1" name="V_CoordPhone1" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="V_CoordMail1">อีเมลผู้ประสานงาน:</label>
                            <input type="email" id="V_CoordMail1" name="V_CoordMail1" class="form-control">
                        </div>
                    </div>
                </div>

                <!-- Electricity and Billing Information -->
                <div class="form-row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="serial_number">รหัสการไฟฟ้า:</label>
                            <input type="text" id="serial_number" name="serial_number" maxlength="10" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="CA_code">รหัสผู้ใช้ไฟ:</label>
                            <input type="text" id="CA_code" name="CA_code" maxlength="12" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="B_M12">ระบุเดือน:</label>
                            <input type="month" id="B_M12" name="B_M12" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="V_Electric_per_month">ค่าไฟต่อเดือน:</label>
                            <input type="number" id="V_Electric_per_month" name="V_Electric_per_month" class="form-control" step="any" placeholder="000.00">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="V_Peak_month">ค่า Peak:</label>
                            <input type="number" id="V_Peak_month" name="V_Peak_month" class="form-control" step="any" placeholder="000.00">
                        </div>
                    </div>
                </div>

                <!-- Sales Team and Status Information -->
                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="V_Sale">ทีมฝ่ายขาย:</label>
                            <input type="text" id="V_Sale" name="V_Sale" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="V_Date">วันที่ได้รับเอกสาร:</label>
                            <input type="date" id="V_Date" name="V_Date" class="form-control">
                        </div>
                    </div>
                </div>

                <!-- Comments and Status -->
                <div class="form-row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="V_comment">หมายเหตุ:</label>
                            <textarea id="V_comment" name="V_comment" class="form-control"></textarea>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="T_Status">สถานะ:</label>
                            <select id="T_Status" name="T_Status" class="form-control" required>
                                <option value="">-- เลือกสถานะ --</option>
                                <option value="ได้รับเอกสาร">ได้รับเอกสาร</option>
                                <option value="นำส่งการไฟฟ้า">นำส่งการไฟฟ้า</option>
                                <option value="ตอบรับ">ตอบรับ</option>
                                <option value="ส่งมอบงาน">ส่งมอบงาน</option>
                                <option value="ไม่ผ่าน">ไม่ผ่าน</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="file">เลือกไฟล์ (PDF):</label>
                            <input type="file" id="file" name="file" class="form-control" accept="application/pdf" required>
                        </div>
                    </div>
                </div>

                <!-- Submit and Reset Buttons -->
                <div class="submit-btn">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="reset" class="btn btn-secondary ml-3">Reset</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
