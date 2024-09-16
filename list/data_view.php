<?php include '../fetch_data.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Data</title>
    <link href="../css/dashboard_styles.css" rel="stylesheet">
    <link href="../css/custom-select.css" rel="stylesheet">
    <link href="../css/data_view.css" rel="stylesheet">
</head>
<body>
    <?php include '../header.php'; ?>

    <div class="container">
        <header>
            <h1>ข้อมูลของหน่วยงาน</h1>
        </header>
        <!-- ที่แสดงข้อมูล -->
        <main>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>ชื่อหน่วยงาน</th>
                        <th>จังหวัด</th>
                        <th>อำเภอ</th>
                        <th>ตำบล</th>
                        <th>ค่าไฟ/เดือน</th>
                        <th>ไฟล์เอกสาร</th>
                        <th>ทีมฝ่ายขาย</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $resultdatastore_db->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['V_ID']); ?></td>
                            <td><?php echo htmlspecialchars($row['V_Name']); ?></td>
                            <td><?php echo htmlspecialchars($row['V_Province']); ?></td>
                            <td><?php echo htmlspecialchars($row['V_District']); ?></td>
                            <td><?php echo htmlspecialchars($row['V_SubDistrict']); ?></td>
                            <td><?php echo htmlspecialchars($row['V_Electric_per_month']); ?></td>
                            <td>
                                <?php if (!empty($row['filename'])): ?>
                                    <a href="../uploads/<?php echo htmlspecialchars($row['filename']); ?>" target="_blank">
                                        <?php echo htmlspecialchars($row['filename']); ?>
                                    </a>
                                <?php else: ?>
                                    No File
                                <?php endif; ?>
                            </td>
                            <td><?php echo htmlspecialchars($row['V_Sale']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <!-- ที่กดเปลี่ยนหน้า -->
            <div class="pagination">
                <?php if ($page > 1): ?>
                    <a class="page-link" href="?page=<?php echo $page - 1; ?>">&laquo; Previous</a>
                <?php endif; ?>

                <?php 
                $max_pages_to_show = 20; // Maximum number of pages to show
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

                // Display page numbers
                if ($start_page > 1) {
                    echo '<a class="page-link" href="?page=1">1</a>';
                    if ($start_page > 2) echo '<span class="page-ellipsis">...</span>';
                }

                for ($i = $start_page; $i <= $end_page; $i++): ?>
                    <a class="page-link <?php echo $i == $page ? 'active' : ''; ?>" href="?page=<?php echo $i; ?>">
                        <?php echo $i; ?>
                    </a>
                <?php endfor; ?>

                <?php if ($page < $total_pages): ?>
                    <a class="page-link" href="?page=<?php echo $page + 1; ?>">Next &raquo;</a>
                <?php endif; ?>
            </div>
        </main>
    </div>

    <!-- เปลี่ยนหน้าแล้วไม่เด้ง -->
    <script>
    function loadPage(page) {
        const url = window.location.href.split('?')[0] + '?page=' + page;
        fetch(url)
            .then(response => response.text())
            .then(html => {
                document.body.innerHTML = html;
                window.scrollTo(0, document.body.scrollHeight);
            })
            .catch(error => console.log(error));
    }

    document.addEventListener("DOMContentLoaded", function() {
        window.scrollTo(0, document.body.scrollHeight);
    });
    </script>
</body>
</html>
