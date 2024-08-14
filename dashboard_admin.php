<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="css/dashboard_styles.css" rel="stylesheet">
</head>
<body>
    <?php include 'header.php'; ?>
    
    <div class="main-content">
        <h1 class="mb-4">Dashboard Overview</h1>
        
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Total Records</div>
                    <div class="card-body text-center">
                        <h3 id="total-records">1234</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Active Users</div>
                    <div class="card-body text-center">
                        <h3 id="active-users">567</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Pending Requests</div>
                    <div class="card-body text-center">
                        <h3 id="pending-requests">89</h3>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row chart-container">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Chart 1</div>
                    <div class="card-body">
                        <canvas id="pieChart1"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Chart 2</div>
                    <div class="card-body">
                        <canvas id="pieChart2"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="row chart-container">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Chart 3</div>
                    <div class="card-body">
                        <canvas id="pieChart3"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Chart 4</div>
                    <div class="card-body">
                        <canvas id="pieChart4"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="js/dashboard_scripts.js"></script>
</body>
</html>
