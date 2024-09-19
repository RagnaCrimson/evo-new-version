<?php
include '../connect.php';

mysqli_query($objConnect, "SET NAMES utf8");

$data = array();

if (isset($_POST['submit'])) {
    $data = $_POST['data'];
    $V_ID = $_POST['V_ID'];

    // Check if V_ID is set
    if (!isset($V_ID)) {
        die("V_ID is not set.");
    }

    // Update `view` table
    $strSQL_update_view = "UPDATE view SET V_Name = ?, V_Province = ?, V_District = ?, V_SubDistrict = ?, V_ExecName = ?, V_ExecPhone = ?, V_ExecMail = ?, V_CoordName1 = ?, V_CoordPhone1 = ?, V_CoordMail1 = ?, V_Sale = ?, V_Date = ?, V_Electric_per_month = ?, V_Peak_month = ?, V_comment = ?, V_location = ? WHERE V_ID = ?";
    $stmt_update_view = mysqli_prepare($objConnect, $strSQL_update_view);

    if (!$stmt_update_view) {
        die("Error preparing statement for view update: " . mysqli_error($objConnect));
    }

    mysqli_stmt_bind_param($stmt_update_view, "sssssssssssssssss", 
        $data['V_Name'], $data['V_Province'], $data['V_District'], $data['V_SubDistrict'], 
        $data['V_ExecName'], $data['V_ExecPhone'], $data['V_ExecMail'], $data['V_CoordName1'], 
        $data['V_CoordPhone1'], $data['V_CoordMail1'], $data['V_Sale'], $data['V_Date'], 
        $data['V_Electric_per_month'], $data['V_Peak_month'], $data['V_comment'], 
        $data['V_location'], $V_ID
    );
    if (!mysqli_stmt_execute($stmt_update_view)) {
        die("Error executing view update statement: " . mysqli_stmt_error($stmt_update_view));
    }
    mysqli_stmt_close($stmt_update_view);

    // Update `peak` table
    $strSQL_update_peak = "UPDATE peak SET serial_number = ?, CA_code = ? WHERE V_ID = ?";
    $stmt_update_peak = mysqli_prepare($objConnect, $strSQL_update_peak);

    if (!$stmt_update_peak) {
        die("Error preparing statement for peak update: " . mysqli_error($objConnect));
    }

    mysqli_stmt_bind_param($stmt_update_peak, "ssi", $data['serial_number'], $data['CA_code'], $V_ID);
    if (!mysqli_stmt_execute($stmt_update_peak)) {
        die("Error executing peak update statement: " . mysqli_stmt_error($stmt_update_peak));
    }
    mysqli_stmt_close($stmt_update_peak);

    // Update `bill` table
    $strSQL_update_bill = "UPDATE bill SET B_M12 = ? WHERE V_ID = ?";
    $stmt_update_bill = mysqli_prepare($objConnect, $strSQL_update_bill);

    if (!$stmt_update_bill) {
        die("Error preparing statement for bill update: " . mysqli_error($objConnect));
    }

    mysqli_stmt_bind_param($stmt_update_bill, "si", $data['B_M12'], $V_ID);
    if (!mysqli_stmt_execute($stmt_update_bill)) {
        die("Error executing bill update statement: " . mysqli_stmt_error($stmt_update_bill));
    }
    mysqli_stmt_close($stmt_update_bill);

    // Handle file upload
    if (!empty($_FILES['pdf_file']['name'])) {
        $file = $_FILES['pdf_file']['tmp_name'];
        $filename = basename($_FILES['pdf_file']['name']);
        $target = '../uploads/' . $filename;
        
        if (move_uploaded_file($file, $target)) {
            // Update `files` table
            $strSQL_update_file = "UPDATE files SET filename = ? WHERE id = ?";
            $stmt_update_file = mysqli_prepare($objConnect, $strSQL_update_file);

            if (!$stmt_update_file) {
                die("Error preparing statement for file update: " . mysqli_error($objConnect));
            }

            mysqli_stmt_bind_param($stmt_update_file, "si", $filename, $V_ID);
            if (!mysqli_stmt_execute($stmt_update_file)) {
                die("Error executing file update statement: " . mysqli_stmt_error($stmt_update_file));
            }
            mysqli_stmt_close($stmt_update_file);
        } else {
            echo "Error uploading file.";
        }
    }

    echo "Data updated successfully.";
    header("Location: data_view.php");
    exit;
} else {
    // Fetch existing data if not POST
    if (isset($_GET['V_ID'])) {
        $V_ID = $_GET['V_ID'];
        $strSQL_select = "SELECT * FROM view WHERE V_ID = ?";
        $stmt_select = mysqli_prepare($objConnect, $strSQL_select);

        if (!$stmt_select) {
            die("Error preparing statement for view select: " . mysqli_error($objConnect));
        }

        mysqli_stmt_bind_param($stmt_select, "i", $V_ID);
        mysqli_stmt_execute($stmt_select);
        $result = mysqli_stmt_get_result($stmt_select);
        $data = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt_select);
    } else {
        die("V_ID not provided.");
    }
}
?>