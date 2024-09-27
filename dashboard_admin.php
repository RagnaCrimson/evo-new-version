<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-doughnutlabel@1.0.0"></script>
    <link href="css/dashboard_styles.css" rel="stylesheet">
    <script src="js/script.js"></script>
</head>
<body>
    <?php include 'sort_by.php';?>
    <?php include 'header.php'; ?>
    
    <div class="main-content">
        <h1 class="mb-4">Dashboard Overview</h1>
        
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">รวมจำนวนไฟฟ้ากิโลวัต Kw</div>
                    <div class="card-body text-center">
                        <h3 id="total-records"><?php echo number_format($total_electric_per_year); ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">รวมค่าใช้ไฟฟ้าต่อปี</div>
                    <div class="card-body text-center">
                        <h3 id="active-users"><?php echo number_format($total_electric_per_year); ?> บาท</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">หน่วยงานที่เข้าร่วมทั้งหมด</div>
                    <div class="card-body text-center">
                        <h3 id="total-count"></h3>
                    </div>
                </div>
            </div>
        </div>

    <?php include 'dashboard_scripts.php'; ?>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetch('total_count.php')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('total-count').textContent = data.total_count + ' แห่ง';
                })
                .catch(error => console.error('Error fetching data:', error));
        });
    </script>
</body>
</html>
