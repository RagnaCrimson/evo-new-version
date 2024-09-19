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

    $sql = "SELECT * FROM view WHERE V_Name LIKE ? OR V_Province LIKE ?";
    $stmt = $objConnect->prepare($sql);
    $search_param = "%{$search_query}%";
    $stmt->bind_param('ss', $search_param, $search_param);
    $stmt->execute();
    $resultdatastore_db = $stmt->get_result();

    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $rows_per_page = 20;
    $offset = ($page - 1) * $rows_per_page;

    $stmt_total = $objConnect->prepare("SELECT COUNT(*) AS total FROM view WHERE V_Name LIKE ? OR V_Province LIKE ?");
    $stmt_total->bind_param('ss', $search_param, $search_param);
    $stmt_total->execute();
    $result_total = $stmt_total->get_result();
    $row_total = $result_total->fetch_assoc();
    $total_rows = $row_total['total'];

    $total_pages = ceil($total_rows / $rows_per_page);

    $stmt_data = $objConnect->prepare("SELECT view.*, files.filename, peak.serial_number, peak.CA_code 
                                       FROM view 
                                       LEFT JOIN files ON view.V_ID = files.ID 
                                       LEFT JOIN peak ON view.V_ID = peak.V_ID 
                                       WHERE V_Name LIKE ? OR V_Province LIKE ? 
                                       LIMIT ?, ?");
    $stmt_data->bind_param("ssii", $search_param, $search_param, $offset, $rows_per_page);
    $stmt_data->execute();
    $resultdatastore_db = $stmt_data->get_result();

} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?>
