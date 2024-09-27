<?php
include '../header.php';
include '../connect.php';

$region = isset($_GET['region']) ? $_GET['region'] : '';
$provinceFilter = isset($_GET['province']) ? $_GET['province'] : '';
$saleFilter = isset($_GET['sale']) ? $_GET['sale'] : '';

if (empty($region)) {
    die("Invalid region specified.");
}

// Pagination setup
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$recordsPerPage = 20;
$offset = ($page - 1) * $recordsPerPage;

// Query for the region data
$strSQL = "SELECT * FROM view WHERE V_Region = ?";

if (!empty($provinceFilter)) {
    $strSQL .= " AND V_Province = ?";
}
if (!empty($saleFilter)) {
    $strSQL .= " AND V_Sale = ?";
}

$strSQL .= " ORDER BY V_Region ASC LIMIT ?, ?";
$stmt = $objConnect->prepare($strSQL);
if (!$stmt) {
    die("Prepare failed: " . $objConnect->error);
}

$params = [$region];

if (!empty($provinceFilter)) {
    $params[] = $provinceFilter;
}
if (!empty($saleFilter)) {
    $params[] = $saleFilter;
}
$params[] = $offset;
$params[] = $recordsPerPage;

$stmt->bind_param(str_repeat("s", count($params) - 2) . "ii", ...$params);
$stmt->execute();
$result = $stmt->get_result();

// Count total records for pagination
$countSQL = "SELECT COUNT(*) AS totalRecords FROM view WHERE V_Region = ?";
$stmtCount = $objConnect->prepare($countSQL);
$stmtCount->bind_param("s", $region);
$stmtCount->execute();
$countResult = $stmtCount->get_result();
$totalRecords = $countResult->fetch_assoc()['totalRecords'];

// Adjust count query to include filters
if (!empty($provinceFilter)) {
    $countSQL .= " AND V_Province = ?";
}
if (!empty($saleFilter)) {
    $countSQL .= " AND V_Sale = ?";
}

$stmtCount = $objConnect->prepare($countSQL);
$paramsCount = [$region];

if (!empty($provinceFilter)) {
    $paramsCount[] = $provinceFilter;
}
if (!empty($saleFilter)) {
    $paramsCount[] = $saleFilter;
}

$stmtCount->bind_param(str_repeat("s", count($paramsCount)), ...$paramsCount);
$stmtCount->execute();
$countResult = $stmtCount->get_result();
$totalRecords = $countResult->fetch_assoc()['totalRecords'];
$totalPages = ceil($totalRecords / $recordsPerPage);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายละเอียดภูมิภาค: <?php echo htmlspecialchars($region); ?></title>
    <link href="../css/dashboard_styles.css" rel="stylesheet">
    <link href="../css/custom-select.css" rel="stylesheet">
    <link href="../css/detail_style.css" rel="stylesheet">
    <script src="../js/logout.js"></script>
</head>
<body>
    <div class="main-content">
        <h2>รายละเอียดหน่วยงานในภูมิภาค: <?php echo htmlspecialchars($region); ?></h2>
        
        <form method="GET" action="">
            <input type="hidden" name="region" value="<?php echo htmlspecialchars($region); ?>">
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

        <table class="table table-bordered">
        <p>จำนวนทั้งหมด: <?php echo number_format($totalRecords); ?> หน่วยงาน</p>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>ชื่อหน่วยงาน</th>
                    <th>จังหวัด</th>
                    <th>Peak ต่อเดือน</th>
                    <th>ทีมฝ่ายขาย</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['V_ID']); ?></td>
                    <td><?php echo htmlspecialchars($row['V_Name']); ?></td>
                    <td><?php echo htmlspecialchars($row['V_Province']); ?></td>
                    <td><?php echo number_format($row['V_Peak_month'], 2); ?></td>
                    <td><?php echo htmlspecialchars($row['V_Sale']); ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="?region=<?php echo urlencode($region); ?>&province=<?php echo urlencode($provinceFilter); ?>&sale=<?php echo urlencode($saleFilter); ?>&page=<?php echo $page - 1; ?>">Prev</a>
            <?php endif; ?>

            <?php
            $startPage = max(1, $page - 9);
            $endPage = min($totalPages, $startPage + 19);

            for ($i = $startPage; $i <= $endPage; $i++): ?>
                <a href="?region=<?php echo urlencode($region); ?>&province=<?php echo urlencode($provinceFilter); ?>&sale=<?php echo urlencode($saleFilter); ?>&page=<?php echo $i; ?>" class="<?php echo $i == $page ? 'active' : ''; ?>">
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>

            <?php if ($page < $totalPages): ?>
                <a href="?region=<?php echo urlencode($region); ?>&province=<?php echo urlencode($provinceFilter); ?>&sale=<?php echo urlencode($saleFilter); ?>&page=<?php echo $page + 1; ?>">Next</a>
            <?php endif; ?>
        </div>
    </div>
    
    <?php include '../footer.php'; ?>
</body>
</html>

<?php
$stmt->close();
$stmtCount->close();
mysqli_close($objConnect);
?>
