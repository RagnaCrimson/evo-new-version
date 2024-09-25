<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "datastore_db";

try {
    // Establish the database connection
    $objConnect = new mysqli($servername, $username, $password, $dbname);

    if ($objConnect->connect_error) {
        throw new Exception("Connection failed: " . $objConnect->connect_error);
    }

    $objConnect->set_charset("utf8");

    $search_query = isset($_GET['search']) ? trim($_GET['search']) : '';

    // Filters
    $saleFilter = isset($_GET['sale']) ? $_GET['sale'] : '';
    $provinceFilter = isset($_GET['province']) ? $_GET['province'] : '';
    $statusFilter = isset($_GET['status']) ? $_GET['status'] : '';

    // Search query
    $sql = "SELECT * FROM view WHERE V_Name LIKE ? OR V_Province LIKE ?";
    $stmt = $objConnect->prepare($sql);
    
    if (!$stmt) {
        throw new Exception("Prepare failed: " . $objConnect->error);
    }

    $search_param = "%{$search_query}%";
    $stmt->bind_param('ss', $search_param, $search_param);
    $stmt->execute();
    $resultdatastore_db = $stmt->get_result();

    // Pagination
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $rows_per_page = 20;
    $offset = ($page - 1) * $rows_per_page;

    // Total record count
    $stmt_total = $objConnect->prepare("SELECT COUNT(*) AS total FROM view WHERE V_Name LIKE ? OR V_Province LIKE ?");
    if (!$stmt_total) {
        throw new Exception("Prepare failed (total): " . $objConnect->error);
    }
    $stmt_total->bind_param('ss', $search_param, $search_param);
    $stmt_total->execute();
    $result_total = $stmt_total->get_result();
    $row_total = $result_total->fetch_assoc();
    $total_rows = $row_total['total'];
    $total_pages = ceil($total_rows / $rows_per_page);

    // Data query with joined tables
    $stmt_data = $objConnect->prepare("
        SELECT view.*, files.filename, peak.serial_number, peak.CA_code, task.T_Status
        FROM view 
        LEFT JOIN files ON view.V_ID = files.ID 
        LEFT JOIN peak ON view.V_ID = peak.V_ID 
        LEFT JOIN task ON view.V_ID = task.T_ID
        WHERE V_Name LIKE ? OR V_Province LIKE ? 
        LIMIT ?, ?");
    
    if (!$stmt_data) {
        throw new Exception("Prepare failed (data): " . $objConnect->error);
    }

    $stmt_data->bind_param("ssii", $search_param, $search_param, $offset, $rows_per_page);
    $stmt_data->execute();
    $resultdatastore_db = $stmt_data->get_result();

} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}

// Excel export logic
if (isset($_GET['act']) && $_GET['act'] == 'excel') {
    header("Content-Type: text/csv; charset=utf-8");
    header("Content-Disposition: attachment; filename=export.csv");
    header("Pragma: no-cache");
    header("Expires: 0");

    // Open output stream
    $output = fopen('php://output', 'w');
    fprintf($output, "\xEF\xBB\xBF"); // UTF-8 BOM for Excel compatibility

    // Correct query for export
    $sql = "
        SELECT view.*, task.T_Status
        FROM view 
        LEFT JOIN task ON view.V_ID = task.V_ID
        WHERE (view.V_Sale = ? OR ? = '')
        AND (view.V_Province = ? OR ? = '')
        AND (task.T_Status = ? OR ? = '')";

    $stmt = $objConnect->prepare($sql);
    if (!$stmt) {
        die("Prepare failed (excel): " . $objConnect->error);
    }

    // Bind parameters for the export
    $stmt->bind_param("ssssss", $saleFilter, $saleFilter, $provinceFilter, $provinceFilter, $statusFilter, $statusFilter);
    $stmt->execute();
    $result = $stmt->get_result();

    // Write the CSV header
    fputcsv($output, ['ID', 'ชื่อหน่วยงาน', 'จังหวัด', 'อำเภอ', 'ตำบล', 'ค่าไฟ', 'ทีมฝ่ายขาย', 'สถานะ']);

    // Write data rows
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            fputcsv($output, [
                $row['V_ID'],
                $row['V_Name'],
                $row['V_Province'],
                $row['V_District'],
                $row['V_SubDistrict'],
                $row['V_Electric_per_month'],
                $row['V_Sale'],
                $row['T_Status']
            ]);
        }
    } else {
        fputcsv($output, ['No data found']);
    }

    fclose($output);
    $stmt->close();
    $objConnect->close();
    exit;
}
?>
