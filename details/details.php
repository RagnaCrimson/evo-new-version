<?php
include '../header.php';
include '../connect.php';

$range = isset($_GET['range']) ? $_GET['range'] : '';

$valid_ranges = ['ไม่มีข้อมูล', '1-50', '51-100', '101-150', '151-199', '200-10000'];
if (!in_array($range, $valid_ranges)) {
    die("Invalid range specified.");
}

$provinceFilter = isset($_GET['province']) ? $_GET['province'] : '';
$saleFilter = isset($_GET['sale']) ? $_GET['sale'] : '';

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$recordsPerPage = 20;
$offset = ($page - 1) * $recordsPerPage;

// Base SQL Query with Range Filter
$strSQL = "SELECT * FROM view WHERE ";
switch ($range) {
    case 'ไม่มีข้อมูล':
        $strSQL .= "V_Peak_month = 0";
        break;
    case '1-50':
        $strSQL .= "V_Peak_month BETWEEN 1 AND 50";
        break;
    case '51-100':
        $strSQL .= "V_Peak_month BETWEEN 51 AND 100";
        break;
    case '101-150':
        $strSQL .= "V_Peak_month BETWEEN 101 AND 150";
        break;
    case '151-199':
        $strSQL .= "V_Peak_month BETWEEN 151 AND 199";
        break;
    case '200-10000':
        $strSQL .= "V_Peak_month BETWEEN 200 AND 10000";
        break;
}

// Filters
if (!empty($provinceFilter)) {
    $strSQL .= " AND V_Province = ?";
}
if (!empty($saleFilter)) {
    $strSQL .= " AND V_Sale = ?";
}

// Query for Total Record Count
$countSQL = "SELECT COUNT(*) FROM view WHERE " . substr($strSQL, strpos($strSQL, 'V_Peak_month'));
$stmtCount = $objConnect->prepare($countSQL);
if ($provinceFilter && $saleFilter) {
    $stmtCount->bind_param('ss', $provinceFilter, $saleFilter);
} elseif ($provinceFilter) {
    $stmtCount->bind_param('s', $provinceFilter);
} elseif ($saleFilter) {
    $stmtCount->bind_param('s', $saleFilter);
}
$stmtCount->execute();
$stmtCount->bind_result($totalRecords);
$stmtCount->fetch();
$stmtCount->close();

// Apply Pagination Limits to Main Query
$strSQL .= " LIMIT ?, ?";
$stmt = $objConnect->prepare($strSQL);
if (!$stmt) {
    die("Prepare failed: " . $objConnect->error);
}

// Bind Filters and Pagination Params
if (!empty($provinceFilter) && !empty($saleFilter)) {
    $stmt->bind_param("ssii", $provinceFilter, $saleFilter, $offset, $recordsPerPage);
} elseif (!empty($provinceFilter)) {
    $stmt->bind_param("sii", $provinceFilter, $offset, $recordsPerPage);
} elseif (!empty($saleFilter)) {
    $stmt->bind_param("sii", $saleFilter, $offset, $recordsPerPage);
} else {
    $stmt->bind_param("ii", $offset, $recordsPerPage);
}

$result = $stmt->execute();
if (!$result) {
    die("Query execution failed: " . $stmt->error);
}

$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filtered Results</title>
    <link href="../css/dashboard_styles.css" rel="stylesheet">
    <link href="../css/custom-select.css" rel="stylesheet">
    <link href="../css/detail_style.css" rel="stylesheet">
    <script src="../js/logout.js"></script>
</head>
<body>
    <div class="main-content">
        <h2>หน่วยงานที่มีค่า Peak : <?php echo htmlspecialchars($range); ?></h2>
        
        <form method="GET" action="">
            <input type="hidden" name="range" value="<?php echo htmlspecialchars($range); ?>">
            <div class="form-group">
                <label for="province">จังหวัด:</label>
                <select name="province" id="province" class="form-control">
                    <option value="">--เลือกจังหวัด--</option>
                    <?php
                    $provinces = $objConnect->query("SELECT DISTINCT V_Province FROM view");
                    while ($row = $provinces->fetch_assoc()): ?>
                        <option value="<?php echo htmlspecialchars($row['V_Province']); ?>" <?php if ($provinceFilter == $row['V_Province']) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($row['V_Province']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>

                <label for="sale">ทีมฝ่ายขาย:</label>
                <select name="sale" id="sale" class="form-control">
                    <option value="">--เลือกทีมฝ่ายขาย--</option>
                    <?php
                    $sales = $objConnect->query("SELECT DISTINCT V_Sale FROM view");
                    while ($row = $sales->fetch_assoc()): ?>
                        <option value="<?php echo htmlspecialchars($row['V_Sale']); ?>" <?php if ($saleFilter == $row['V_Sale']) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($row['V_Sale']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
                <button type="submit" class="btn btn-primary">กรอง</button>
            </div>
        </form>
        
        <p>แสดงผลข้อมูลทั้งหมด: <?php echo $totalRecords; ?> รายการ</p> <!-- Total records display -->

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>ชื่อหน่วยงาน</th>
                    <th>จังหวัด</th>
                    <th>ค่า Peak</th>
                    <th>ทีมฝ่ายขาย</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['V_ID']); ?></td>
                    <td><?php echo htmlspecialchars($row['V_Name']); ?></td>
                    <td><?php echo htmlspecialchars($row['V_Province']); ?></td>
                    <td><?php echo ($row["V_Peak_month"] == 0) ? 'N/A' : number_format($row["V_Peak_month"], 2); ?></td>
                    <td><?php echo htmlspecialchars($row['V_Sale']); ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <div class="pagination" style="margin: 30px 0; text-align: center;">
            <?php if ($page > 1): ?>
                <a href="?province=<?php echo urlencode($provinceFilter); ?>&sale=<?php echo urlencode($saleFilter); ?>&range=<?php echo urlencode($range); ?>&page=<?php echo $page - 1; ?>">Prev</a>
            <?php endif; ?>

            <?php 
            $totalPages = ceil($totalRecords / $recordsPerPage);
            $startPage = max(1, $page - 9);
            $endPage = min($totalPages, $startPage + 19);

            for ($i = $startPage; $i <= $endPage; $i++): ?>
                <a href="?province=<?php echo urlencode($provinceFilter); ?>&sale=<?php echo urlencode($saleFilter); ?>&range=<?php echo urlencode($range); ?>&page=<?php echo $i; ?>" class="<?php echo $i == $page ? 'active' : ''; ?>">
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>

            <?php if ($page < $totalPages): ?>
                <a href="?province=<?php echo urlencode($provinceFilter); ?>&sale=<?php echo urlencode($saleFilter); ?>&range=<?php echo urlencode($range); ?>&page=<?php echo $page + 1; ?>">Next</a>
            <?php endif; ?>
        </div>
    </div>
    <?php include '../footer.php'; ?>
</body>
</html>
