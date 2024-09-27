<?php
include '../header.php';
include '../connect.php';

$range = isset($_GET['range']) ? $_GET['range'] : '';
$provinceFilter = isset($_GET['province']) ? $_GET['province'] : '';
$saleFilter = isset($_GET['sale']) ? $_GET['sale'] : '';

$valid_ranges = [
    'ไม่มีข้อมูล',
    '1-100000',
    '100001-200000',
    '200001-500000',
    '500001-1000000',
    '1000001-90000000',
];

if (!in_array($range, $valid_ranges)) {
    die("Invalid range specified.");
}

switch ($range) {
    case 'ไม่มีข้อมูล':
        $yearCondition = "V_Electric_per_year = 0";
        break;
    case '1-100000':
        $yearCondition = "V_Electric_per_year BETWEEN 1 AND 100000";
        break;
    case '100001-200000':
        $yearCondition = "V_Electric_per_year BETWEEN 100001 AND 200000";
        break;
    case '200001-500000':
        $yearCondition = "V_Electric_per_year BETWEEN 200001 AND 500000";
        break;
    case '500001-1000000':
        $yearCondition = "V_Electric_per_year BETWEEN 500001 AND 1000000";
        break;
    case '1000001-90000000':
        $yearCondition = "V_Electric_per_year BETWEEN 1000001 AND 90000000";
        break;
    default:
        die("Invalid range specified.");
}

$provinceCondition = $provinceFilter ? "AND V_Province = '$provinceFilter'" : '';
$saleCondition = $saleFilter ? "AND V_Sale = '$saleFilter'" : '';

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$recordsPerPage = 20;
$offset = ($page - 1) * $recordsPerPage;

$yearSQL = "
    SELECT v.*, t.T_Status 
    FROM view v 
    JOIN task t ON v.V_ID = t.T_ID 
    WHERE $yearCondition $provinceCondition $saleCondition 
    ORDER BY V_Electric_per_year DESC
    LIMIT ?, ?";

$stmt = $objConnect->prepare($yearSQL);
$stmt->bind_param("ii", $offset, $recordsPerPage);
$stmt->execute();
$yearResult = $stmt->get_result();

if (!$yearResult) {
    die("Query failed: " . $objConnect->error);
}

$countSQL = "
    SELECT COUNT(*) AS totalRecords 
    FROM view v 
    JOIN task t ON v.V_ID = t.T_ID 
    WHERE $yearCondition $provinceCondition $saleCondition";

$countResult = $objConnect->query($countSQL);
$totalRecords = $countResult->fetch_assoc()['totalRecords'];
$totalPages = ceil($totalRecords / $recordsPerPage);

$provinces = $objConnect->query("SELECT DISTINCT V_Province FROM view");
$sales = $objConnect->query("SELECT DISTINCT V_Sale FROM view");
$statuses = $objConnect->query("SELECT DISTINCT T_Status FROM task");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายละเอียดค่าไฟฟ้าต่อปี: <?php echo htmlspecialchars($range); ?></title>
    <link href="../css/dashboard_styles.css" rel="stylesheet">
    <link href="../css/custom-select.css" rel="stylesheet">
    <link href="../css/detail_style.css" rel="stylesheet">
    <script src="../js/logout.js"></script>
</head>
<body>
    <div class="main-content">
        <h2>รายละเอียดค่าไฟฟ้าต่อปี: <?php echo htmlspecialchars($range); ?></h2>

        <form method="GET" action="">
            <input type="hidden" name="range" value="<?php echo htmlspecialchars($range); ?>">
            <div class="form-group">
                <label for="province">จังหวัด:</label>
                <select name="province" id="province" class="form-control">
                    <option value="">--เลือกจังหวัด--</option>
                    <?php while ($row = $provinces->fetch_assoc()): ?>
                        <option value="<?php echo htmlspecialchars($row['V_Province']); ?>" <?php if ($provinceFilter == $row['V_Province']) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($row['V_Province']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>

                <label for="sale">ทีมฝ่ายขาย:</label>
                <select name="sale" id="sale" class="form-control">
                    <option value="">--เลือกทีมฝ่ายขาย--</option>
                    <?php while ($row = $sales->fetch_assoc()): ?>
                        <option value="<?php echo htmlspecialchars($row['V_Sale']); ?>" <?php if ($saleFilter == $row['V_Sale']) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($row['V_Sale']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>

                <button type="submit" class="btn btn-primary">กรอง</button>
            </div>
        </form>

        <div class="data-count">
            <p>จำนวนข้อมูลทั้งหมด: <?php echo $totalRecords; ?> รายการ</p>
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>ชื่อหน่วยงาน</th>
                    <th>จังหวัด</th>
                    <th>ค่าไฟฟ้าต่อปี</th>
                    <th>ทีมฝ่ายขาย</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $yearResult->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['V_ID']); ?></td>
                    <td><?php echo htmlspecialchars($row['V_Name']); ?></td>
                    <td><?php echo htmlspecialchars($row['V_Province']); ?></td>
                    <td><?php echo number_format($row['V_Electric_per_year'], 2); ?></td>
                    <td><?php echo htmlspecialchars($row['V_Sale']); ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="?range=<?php echo urlencode($range); ?>&province=<?php echo urlencode($provinceFilter); ?>&sale=<?php echo urlencode($saleFilter); ?>&page=<?php echo $page - 1; ?>">Prev</a>
            <?php endif; ?>

            <?php
            $startPage = max(1, $page - 9);
            $endPage = min($totalPages, $startPage + 19);

            for ($i = $startPage; $i <= $endPage; $i++): ?>
                <a href="?range=<?php echo urlencode($range); ?>&province=<?php echo urlencode($provinceFilter); ?>&sale=<?php echo urlencode($saleFilter); ?>&page=<?php echo $i; ?>" class="<?php echo $i == $page ? 'active' : ''; ?>">
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>

            <?php if ($page < $totalPages): ?>
                <a href="?range=<?php echo urlencode($range); ?>&province=<?php echo urlencode($provinceFilter); ?>&sale=<?php echo urlencode($saleFilter); ?>&page=<?php echo $page + 1; ?>">Next</a>
            <?php endif; ?>
        </div>

    </div>

    <?php include '../footer.php'; ?>
</body>
</html>
