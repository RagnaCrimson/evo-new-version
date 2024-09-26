<?php include 'fetch_data.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แสดงข้อมูล</title>
    <link href="../css/dashboard_styles.css" rel="stylesheet">
    <link href="../css/custom-select.css" rel="stylesheet">
    <link href="../css/data_view.css" rel="stylesheet">
    <script src="../js/script.js"></script>
</head>
<body>
    <?php include '../header.php'; ?>

    <div class="container">
        <header>
            <h1>แสดงสถานะ</h1>
        </header>

        <main>
            <div class="search-container">
                <form method="get" action="">
                    <input type="text" name="search" placeholder="ค้นหาหน่วยงาน..." value="<?php echo htmlspecialchars($search_query); ?>">
                    <button type="submit">ค้นหา</button>
                </form>
                <p>หน่วยงานทั้งหมด : <?php echo htmlspecialchars($total_rows); ?></p>
                <a href="?act=excel&sale=<?php echo urlencode($saleFilter); ?>&province=<?php echo urlencode($provinceFilter); ?>&status=<?php echo urlencode($statusFilter); ?>" class="btn btn-primary">Export to Excel</a>
            </div>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>ชื่อหน่วยงาน</th>
                        <th>จังหวัด</th>
                        <th>อำเภอ</th>
                        <th>ตำบล</th>
                        <th>ค่าไฟ/เดือน (บาท)</th>
                        <th>สถานะ</th>
                        <th>ทีมฝ่ายขาย</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $resultdatastore_db->fetch_assoc()): ?>
                        <tr class="clickable-row">
                            <td><?php echo htmlspecialchars($row['V_ID']); ?></td>
                            <td><?php echo htmlspecialchars($row['V_Name']); ?></td>
                            <td><?php echo htmlspecialchars($row['V_Province']); ?></td>
                            <td><?php echo htmlspecialchars($row['V_District']); ?></td>
                            <td><?php echo htmlspecialchars($row['V_SubDistrict']); ?></td>
                            <td><?php echo ($row["V_Electric_per_month"] == 0) ? 'N/A' : number_format($row["V_Electric_per_month"], 2); ?> </td>
                            <td><?php echo htmlspecialchars($row['T_Status']); ?></td>
                            <td><?php echo htmlspecialchars($row['V_Sale']); ?></td>
                            <td>
                                <a href="status_update.php?V_ID=<?php echo urlencode($row['V_ID']); ?>" class="btn btn-primary">อัพเดตสถานะ</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <div class="pagination">
                <?php if ($page > 1): ?>
                    <a class="page-link" href="?page=<?php echo $page - 1; ?>&search=<?php echo urlencode($search_query); ?>">&laquo; Previous</a>
                <?php endif; ?>

                <?php 
                $max_pages_to_show = 20;
                $half_max = floor($max_pages_to_show / 2);

                $start_page = max(1, $page - $half_max);
                $end_page = min($total_pages, $page + $half_max);

                if ($end_page - $start_page < $max_pages_to_show - 1) {
                    if ($start_page > 1) {
                        $start_page = max(1, $end_page - $max_pages_to_show + 1);
                    }
                    if ($end_page < $total_pages) {
                        $end_page = min($total_pages, $start_page + $max_pages_to_show - 1);
                    }
                }

                if ($start_page > 1) {
                    echo '<a class="page-link" href="?page=1&search=' . urlencode($search_query) . '">1</a>';
                    if ($start_page > 2) echo '<span class="page-ellipsis">...</span>';
                }

                for ($i = $start_page; $i <= $end_page; $i++): ?>
                    <a class="page-link <?php echo $i == $page ? 'active' : ''; ?>" href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search_query); ?>">
                        <?php echo $i; ?>
                    </a>
                <?php endfor; ?>

                <?php if ($page < $total_pages): ?>
                    <a class="page-link" href="?page=<?php echo $page + 1; ?>&search=<?php echo urlencode($search_query); ?>">Next &raquo;</a>
                <?php endif; ?>
            </div>
        </main>
    </div>

    <?php include '../footer.php'; ?>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const rows = document.querySelectorAll('.clickable-row');
            let activeRow = null;

            rows.forEach(function(row) {
                row.addEventListener('click', function() {
                    if (activeRow && activeRow !== row) {
                        activeRow.classList.remove('active-row');
                    }

                    row.classList.toggle('active-row');

                    activeRow = row.classList.contains('active-row') ? row : null;
                });
            });
        });
    </script>
</body>
</html>
