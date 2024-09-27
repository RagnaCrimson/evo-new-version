<?php
include '../header.php';
include '../connect.php';

$provinceFilter = isset($_GET['province']) ? $_GET['province'] : '';
$saleFilter = isset($_GET['sale']) ? $_GET['sale'] : '';
$range = isset($_GET['range']) ? $_GET['range'] : '';

$valid_ranges = [
    'ไม่มีศักยภาพ',
    'มีศักยภาพ'
];

if (!in_array($range, $valid_ranges)) {
    die("Invalid range specified.");
}

switch ($range) {
    case 'ไม่มีศักยภาพ':
        $monthCondition = "V_Electric_per_month BETWEEN 0 AND 10000";
        break;
    case 'มีศักยภาพ':
        $monthCondition = "V_Electric_per_month BETWEEN 10001 AND 1000000";
        break;
    default:
        die("Invalid range specified.");
}

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$recordsPerPage = 20;
$offset = ($page - 1) * $recordsPerPage;

$strSQL = "SELECT * FROM view WHERE $monthCondition";

if (!empty($provinceFilter)) {
    $strSQL .= " AND V_Province = ?";
}
if (!empty($saleFilter)) {
    $strSQL .= " AND V_Sale = ?";
}

$strSQL .= " ORDER BY V_Electric_per_month DESC";

$countSQL = "SELECT COUNT(*) FROM view WHERE $monthCondition";

$params = [];
if (!empty($provinceFilter)) {
    $params[] = $provinceFilter;
}
if (!empty($saleFilter)) {
    $params[] = $saleFilter;
}

if (!empty($provinceFilter)) {
    $countSQL .= " AND V_Province = ?";
}
if (!empty($saleFilter)) {
    $countSQL .= " AND V_Sale = ?";
}

$stmtCount = $objConnect->prepare($countSQL);
if (!$stmtCount) {
    die("Prepare failed: " . $objConnect->error);
}

if ($params) {
    $stmtCount->bind_param(str_repeat('s', count($params)), ...$params);
}
$stmtCount->execute();
$stmtCount->bind_result($totalRecords);
$stmtCount->fetch();
$stmtCount->close();

$totalPages = ceil($totalRecords / $recordsPerPage);

$strSQL .= " LIMIT ?, ?";
$stmt = $objConnect->prepare($strSQL);
if (!$stmt) {
    die("Prepare failed: " . $objConnect->error);
}

$params[] = $offset;
$params[] = $recordsPerPage;

$stmt->bind_param(str_repeat('s', count($params) - 2) . 'ii', ...$params);
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
    <title>แสดงประสิทธิภาพ</title>
    <link href="../css/dashboard_styles.css" rel="stylesheet">
    <link href="../css/custom-select.css" rel="stylesheet">
    <link href="../css/detail_style.css" rel="stylesheet">
    <script src="../js/logout.js"></script>
</head>
<body>
    <div class="main-content">
        <h1>ประสิทธิภาพของหน่วยงาน</h1>

        <form method="GET" action="">
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

        <?php if ($totalRecords > 0): ?>
            <p>แสดงผลข้อมูลทั้งหมด: <?php echo $totalRecords; ?> รายการ</p>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>ชื่อหน่วยงาน</th>
                        <th>จังหวัด</th>
                        <th>ทีมฝ่ายขาย</th>
                        <th>ค่าไฟ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['V_ID']); ?></td>
                            <td><?php echo htmlspecialchars($row['V_Name']); ?></td>
                            <td><?php echo htmlspecialchars($row['V_Province']); ?></td>
                            <td><?php echo htmlspecialchars($row['V_Sale']); ?></td>
                            <td><?php echo ($row["V_Electric_per_month"] == 0) ? 'N/A' : number_format($row["V_Electric_per_month"], 2); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <div class="pagination" style="margin: 30px 0; text-align: center;">
                <?php if ($page > 1): ?>
                    <a href="?province=<?php echo urlencode($provinceFilter); ?>&sale=<?php echo urlencode($saleFilter); ?>&range=<?php echo urlencode($range); ?>&page=<?php echo $page - 1; ?>">Prev</a>
                <?php endif; ?>

                <?php 
                $startPage = max(1, $page - 9);
                $endPage = min($totalPages, $startPage + 19);

                if ($endPage - $startPage < 19) {
                    $startPage = max(1, $endPage - 19);
                }

                for ($i = $startPage; $i <= $endPage; $i++): ?>
                    <a href="?province=<?php echo urlencode($provinceFilter); ?>&sale=<?php echo urlencode($saleFilter); ?>&range=<?php echo urlencode($range); ?>&page=<?php echo $i; ?>" class="<?php echo $i == $page ? 'active' : ''; ?>">
                        <?php echo $i; ?>
                    </a>
                <?php endfor; ?>

                <?php if ($page < $totalPages): ?>
                    <a href="?province=<?php echo urlencode($provinceFilter); ?>&sale=<?php echo urlencode($saleFilter); ?>&range=<?php echo urlencode($range); ?>&page=<?php echo $page + 1; ?>">Next</a>
                <?php endif; ?>
            </div>

        <?php else: ?>
            <p>ไม่พบข้อมูลที่ต้องการ</p>
        <?php endif; ?>
    </div>

    <?php include '../footer.php'; ?>
</body>
</html>
