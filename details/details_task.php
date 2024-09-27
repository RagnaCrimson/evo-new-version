<?php
ob_start();

include '../header.php';
include '../connect.php';

$status = isset($_GET['status']) ? $_GET['status'] : null;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 20;
$offset = ($page - 1) * $limit;

// Filters
$provinceFilter = isset($_GET['province']) ? $_GET['province'] : '';
$saleFilter = isset($_GET['sale']) ? $_GET['sale'] : '';

$queryConditions = [];
if ($status) {
    $status = mysqli_real_escape_string($objConnect, $status);
    $queryConditions[] = "t.T_Status = '$status'";
}
if (!empty($provinceFilter)) {
    $queryConditions[] = "v.V_Province = '$provinceFilter'";
}
if (!empty($saleFilter)) {
    $queryConditions[] = "v.V_Sale = '$saleFilter'";
}

// Build query
$query = "
    SELECT v.*, t.T_Status, v.V_name 
    FROM view AS v 
    LEFT JOIN task AS t ON v.V_ID = t.T_ID
";

if (!empty($queryConditions)) {
    $query .= " WHERE " . implode(' AND ', $queryConditions);
}

$query .= " LIMIT $offset, $limit";

$result = mysqli_query($objConnect, $query);
if (!$result) {
    die("Query failed: " . mysqli_error($objConnect));
}

// Count total records
$countQuery = "
    SELECT COUNT(*) as total 
    FROM view AS v 
    LEFT JOIN task AS t ON v.V_ID = t.T_ID
";

if (!empty($queryConditions)) {
    $countQuery .= " WHERE " . implode(' AND ', $queryConditions);
}

$countResult = mysqli_query($objConnect, $countQuery);
$totalRecords = mysqli_fetch_assoc($countResult)['total'];
$totalPages = ceil($totalRecords / $limit);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>สถานะ: <?php echo htmlspecialchars($status); ?></title>
    <link href="../css/dashboard_styles.css" rel="stylesheet">
    <link href="../css/custom-select.css" rel="stylesheet">
    <link href="../css/detail_style.css" rel="stylesheet">
    <script src="../js/logout.js"></script>
</head>
<body>
    <div class="main-content">
        <h1>สถานะ: <?php echo htmlspecialchars($status); ?></h1>

        <form method="GET" action="">
            <input type="hidden" name="status" value="<?php echo htmlspecialchars($status); ?>">
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

        <?php if ($status && mysqli_num_rows($result) > 0): ?>
            <p>แสดงผลข้อมูลทั้งหมด: <?php echo $totalRecords; ?> รายการ</p>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>ชื่อหน่วยงาน</th>
                        <th>จังหวัด</th>
                        <th>ทีมฝ่ายขาย</th>
                        <th>สถานะ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo $row['V_ID']; ?></td>
                            <td><?php echo $row['V_name']; ?></td>
                            <td><?php echo $row['V_Province']; ?></td>
                            <td><?php echo $row['V_Sale']; ?></td>
                            <td><?php echo $row['T_Status']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <div class="pagination" style="margin: 30px 0; text-align: center;">
                <?php if ($page > 1): ?>
                    <a href="?status=<?php echo urlencode($status); ?>&province=<?php echo urlencode($provinceFilter); ?>&sale=<?php echo urlencode($saleFilter); ?>&page=<?php echo $page - 1; ?>">Prev</a>
                <?php endif; ?>

                <?php 
                $startPage = max(1, $page - 9);
                $endPage = min($totalPages, $startPage + 19);

                if ($endPage - $startPage < 19) {
                    $startPage = max(1, $endPage - 19);
                }

                for ($i = $startPage; $i <= $endPage; $i++): ?>
                    <a href="?status=<?php echo urlencode($status); ?>&province=<?php echo urlencode($provinceFilter); ?>&sale=<?php echo urlencode($saleFilter); ?>&page=<?php echo $i; ?>" class="<?php echo $i == $page ? 'active' : ''; ?>">
                        <?php echo $i; ?>
                    </a>
                <?php endfor; ?>

                <?php if ($page < $totalPages): ?>
                    <a href="?status=<?php echo urlencode($status); ?>&province=<?php echo urlencode($provinceFilter); ?>&sale=<?php echo urlencode($saleFilter); ?>&page=<?php echo $page + 1; ?>">Next</a>
                <?php endif; ?>
            </div>

        <?php else: ?>
            <p>ไม่พบข้อมูลที่ต้องการ</p>
        <?php endif; ?>
    </div>

    <?php include '../footer.php'; ?>
</body>
</html>

<?php
mysqli_close($objConnect);
ob_end_flush();
?>
