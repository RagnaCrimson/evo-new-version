<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_evo";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $v_name = $conn->real_escape_string($_POST['v_name']);
    $v_province = $conn->real_escape_string($_POST['v_province']);
    $v_district = $conn->real_escape_string($_POST['v_district']);
    $v_subdistrict = $conn->real_escape_string($_POST['v_subdistrict']);
    $v_exec_name = $conn->real_escape_string($_POST['v_exec_name']);
    $v_exec_phone = $conn->real_escape_string($_POST['v_exec_phone']);
    $v_exec_mail = $conn->real_escape_string($_POST['v_exec_mail']);
    $v_coord_name1 = $conn->real_escape_string($_POST['v_coord_name1']);
    $v_coord_phone1 = $conn->real_escape_string($_POST['v_coord_phone1']);
    $v_coord_mail1 = $conn->real_escape_string($_POST['v_coord_mail1']);
    $v_sale = $conn->real_escape_string($_POST['v_sale']);
    $v_date = $_POST['v_date'];
    $v_electric_per_year = $_POST['v_electric_per_year'];
    $v_electric_per_month = $_POST['v_electric_per_month'];
    $v_peak_year = $_POST['v_peak_year'];
    $v_peak_month = $_POST['v_peak_month'];
    $v_comment = $conn->real_escape_string($_POST['v_comment']);
    
    // Handle file upload
    $v_file = null;
    if (isset($_FILES['v_file']) && $_FILES['v_file']['error'] == UPLOAD_ERR_OK) {
        $v_file = file_get_contents($_FILES['v_file']['tmp_name']);
    }

    $stmt = $conn->prepare("INSERT INTO view (V_Name, V_Province, V_District, V_SubDistrict, V_ExecName, V_ExecPhone, V_ExecMail, V_CoordName1, V_CoordPhone1, V_CoordMail1, V_Sale, V_Date, V_Electric_per_year, V_Electric_per_month, V_Peak_year, V_Peak_month, V_comment, V_File) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssssssssssb", $v_name, $v_province, $v_district, $v_subdistrict, $v_exec_name, $v_exec_phone, $v_exec_mail, $v_coord_name1, $v_coord_phone1, $v_coord_mail1, $v_sale, $v_date, $v_electric_per_year, $v_electric_per_month, $v_peak_year, $v_peak_month, $v_comment, $v_file);

    if ($stmt->execute()) {
        $v_id = $stmt->insert_id;
        
        // Insert into bill table
        $ca_code = $conn->real_escape_string($_POST['ca_code']);
        $serial_number = $conn->real_escape_string($_POST['serial_number']);
        $billing_month = $_POST['billing_month'];
        $billing_amount = $_POST['billing_amount'];
        
        $stmt = $conn->prepare("INSERT INTO bill (CA_Code, Serial_number, Billing_Month, Billing_Amount, V_ID) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssi", $ca_code, $serial_number, $billing_month, $billing_amount, $v_id);
        $stmt->execute();
        
        // Insert into status_history table
        $status = $conn->real_escape_string($_POST['status']);
        $status_date = $_POST['status_date'];
        
        $stmt = $conn->prepare("INSERT INTO status_history (V_ID, Status, Status_Date) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $v_id, $status, $status_date);
        $stmt->execute();
        
        echo "Data successfully inserted!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}
?>
