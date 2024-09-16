<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "datastore_db";

try {
    $objConnect = new mysqli($servername, $username, $password, $dbname);

    if ($objConnect->connect_error) {
        throw new Exception("Connection failed: " . $objConnect->connect_error);
    }

    $objConnect->set_charset("utf8");

    // Pagination setup
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $rows_per_page = 20;
    $offset = ($page - 1) * $rows_per_page;

    // Prepare SQL for total rows
    $stmt_total = $objConnect->prepare("SELECT COUNT(*) AS total FROM view");
    $stmt_total->execute();
    $result_total = $stmt_total->get_result();
    $row_total = $result_total->fetch_assoc();
    $total_rows = $row_total['total'];

    $total_pages = ceil($total_rows / $rows_per_page);

    // Prepare SQL for data
    $stmt_data = $objConnect->prepare("SELECT view.*, files.filename, peak.serial_number, peak.CA_code FROM view LEFT JOIN files ON view.V_ID = files.ID LEFT JOIN peak ON view.V_ID = peak.V_ID LIMIT ?, ?");
    $stmt_data->bind_param("ii", $offset, $rows_per_page);
    $stmt_data->execute();
    $resultdatastore_db = $stmt_data->get_result();

} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?>
