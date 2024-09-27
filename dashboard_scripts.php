<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Charts</title>
    <link rel="stylesheet" href="styles/dashboard_styles.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
</head>
<body>
    <div class="row chart-container">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">สถานะงาน</div>
                <div class="card-body">
                    <canvas id="pieChart1"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">หน่วยงานที่มีศักยภาพ</div>
                <div class="card-body">
                    <canvas id="efficiency-chart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">ค่า Peak ต่อเดือน</div>
                <div class="card-body">
                    <canvas id="pieChart2"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">ภูมิภาคหน่วยงาน</div>
                <div class="card-body">
                    <canvas id="pieChart5"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">ค่าไฟต่อปี</div>
                <div class="card-body">
                    <canvas id="pieChart3"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">ค่าไฟต่อเดือน</div>
                <div class="card-body">
                    <canvas id="pieChart4"></canvas>
                </div>
            </div>
        </div>


    <script>
        Chart.register(ChartDataLabels);

        // PHP data passed to JavaScript
        const statusLabels = <?php echo json_encode($status_labels); ?>;
        const statusCounts = <?php echo json_encode($status_counts); ?>;

        const ctxPie = document.getElementById('pieChart1').getContext('2d');
        const pieChart = new Chart(ctxPie, {
            type: 'doughnut',
            data: {
                labels: statusLabels,
                datasets: [{
                    label: 'สถานะงาน',
                    data: statusCounts,
                    backgroundColor: [
                        '#b6ddea', '#12725c', '#898989', '#0b6165', 
                        '#C70039', '#581845', '#FFC300'
                    ]
                }]
            },
            options: {
                responsive: true,
                onClick: (event, elements) => {
                    if (elements.length > 0) {
                        const segmentIndex = elements[0].index;
                        const label = pieChart.data.labels[segmentIndex];
                        window.location.href = `details/details_task.php?status=${encodeURIComponent(label)}`;
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'สถานะงาน'
                    },
                    datalabels: {
                        color: '#fff',
                        font: {
                            weight: 'bold',
                            size: 14
                        },
                        textAlign: 'center',
                        textAnchor: 'middle'
                    }
                }
            }
        });

        const ctxNewDoughnut = document.getElementById('pieChart2').getContext('2d');
        const newDoughnutChart = new Chart(ctxNewDoughnut, {
            type: 'doughnut',
            data: {
                labels: ['ไม่มีข้อมูล', '1-50', '51-100', '101-150', '151-199', '200-10000'],
                datasets: [{
                    label: 'Total Peak per Month',
                    data: [
                        <?php echo $count_0; ?>,
                        <?php echo $count_1_50; ?>,
                        <?php echo $count_51_100; ?>,
                        <?php echo $count_101_150; ?>,
                        <?php echo $count_151_199; ?>,
                        <?php echo $count_200_10000; ?>
                    ],
                    backgroundColor: ['#ea4335', '#fbbc05', '#4285f4', '#34a853', '#FF5733', '#8E44AD']
                }]
            },
            options: {
                responsive: true,
                cutout: '50%',
                onClick: (event, elements) => {
                    if (elements.length > 0) {
                        const segmentIndex = elements[0].index;
                        const label = newDoughnutChart.data.labels[segmentIndex];
                        window.location.href = `details/details.php?range=${label}`;
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'ค่า Peak ต่อเดือน'
                    },
                    datalabels: {
                        formatter: (value, context) => {
                            const total = context.dataset.data.reduce((sum, val) => sum + val, 0);
                            const percentage = (value / total * 100).toFixed(2) + '%';
                            return percentage;
                        },
                        color: '#fff',
                        font: {
                            weight: 'bold',
                            size: 14
                        },
                        anchor: 'center',
                        align: 'center',
                        padding: {
                            bottom: 5
                        },
                        display: (context) => {
                            return context.dataset.data[context.dataIndex] > 20;
                        }
                    }
                }
            }
        });

        const electricYearLabels = ['ไม่มีข้อมูล', '1-100000', '100001-200000', '200001-500000', '500001-1000000', '1000001-90000000'];
        const electricYearCounts = [
            <?php echo $count_electric_0; ?>,
            <?php echo $count_electric_1_100000; ?>,
            <?php echo $count_electric_100001_200000; ?>,
            <?php echo $count_electric_200001_500000; ?>,
            <?php echo $count_electric_500001_1000000; ?>,
            <?php echo $count_electric_1000001_90000000; ?>
        ];

        const ctxElectricYear = document.getElementById('pieChart3').getContext('2d');
        const electricYearChart = new Chart(ctxElectricYear, {
            type: 'doughnut',
            data: {
                labels: electricYearLabels,
                datasets: [{
                    label: 'Total Electric per Year',
                    data: electricYearCounts,
                    backgroundColor: ['#40B5AD', '#008080', '#4682B4', '#509ce4', '#085298', '#0b2c4b']
                }]
            },
            options: {
                responsive: true,
                onClick: (event, elements) => {
                    if (elements.length > 0) {
                        const segmentIndex = elements[0].index;
                        const label = electricYearChart.data.labels[segmentIndex];
                        window.location.href = `details/details_electric_year.php?range=${encodeURIComponent(label)}`;
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'ค่าไฟฟ้าต่อปี'
                    },
                    datalabels: {
                        formatter: (value, context) => {
                            const total = context.dataset.data.reduce((sum, val) => sum + val, 0);
                            const percentage = (value / total * 100).toFixed(2) + '%';
                            return percentage;
                        },
                        color: '#fff',
                        font: {
                            weight: 'bold',
                            size: 14
                        },
                        textAlign: 'center',
                        textAnchor: 'middle'
                    }
                }
            }
        });

        const electricMonthLabels = ['ไม่มีข้อมูล', '1-10000', '10001-30000', '30001-50000', '50001-100000', '100001-200000', '200001-10000000'];
        const electricMonthCounts = [
            <?php echo $count_electric_month_0; ?>,
            <?php echo $count_electric_month_1_10000; ?>,
            <?php echo $count_electric_month_10001_30000; ?>,
            <?php echo $count_electric_month_30001_50000; ?>,
            <?php echo $count_electric_month_50001_100000; ?>,
            <?php echo $count_electric_month_100001_200000; ?>,
            <?php echo $count_electric_month_200001_10000000; ?>
        ];

        const ctxElectricMonth = document.getElementById('pieChart4').getContext('2d');
        const electricMonthChart = new Chart(ctxElectricMonth, {
            type: 'doughnut',
            data: {
                labels: electricMonthLabels,
                datasets: [{
                    label: 'Total Electric per Month',
                    data: electricMonthCounts,
                    backgroundColor: ['#450a80', '#2b0057', '#005682', '#e52b50', '#ffbf00', '#8c0404', '#50c878']
                }]
            },
            options: {
                responsive: true,
                onClick: (event, elements) => {
                    if (elements.length > 0) {
                        const segmentIndex = elements[0].index;
                        const label = electricMonthChart.data.labels[segmentIndex];
                        window.location.href = `details/details_electric_month.php?range=${encodeURIComponent(label)}`;
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'ค่าไฟฟ้าต่อเดือน'
                    },
                    datalabels: {
                        formatter: (value, context) => {
                            const total = context.dataset.data.reduce((sum, val) => sum + val, 0);
                            const percentage = (value / total * 100).toFixed(2) + '%';
                            return percentage;
                        },
                        color: '#fff',
                        font: {
                            weight: 'bold',
                            size: 14
                        },
                        textAlign: 'center',
                        textAnchor: 'middle'
                    }
                }
            }
        });

        const efficiencyLabels = ['ไม่มีศักยภาพ', 'มีศักยภาพ'];
        const efficiencyCounts = [
            <?php echo $count_electric_month_ineffective; ?>,
            <?php echo $count_electric_month_effective; ?>
        ];

        const ctxEfficiency = document.getElementById('efficiency-chart').getContext('2d');
        const efficiencyChart = new Chart(ctxEfficiency, {
            type: 'doughnut',
            data: {
                labels: efficiencyLabels,
                datasets: [{
                    label: 'Efficiency',
                    data: efficiencyCounts,
                    backgroundColor: ['#C70039', '#2ecc71']
                }]
            },
            options: {
                responsive: true,
                onClick: (event, elements) => {
                    if (elements.length > 0) {
                        const segmentIndex = elements[0].index;
                        const range = efficiencyLabels[segmentIndex];
                        window.location.href = `details/details_effective.php?range=${encodeURIComponent(range)}`;
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'กราฟแสดงประสิทธิภาพ'
                    },
                    datalabels: {
                        formatter: (value, context) => {
                            const total = context.dataset.data.reduce((sum, val) => sum + val, 0);
                            const percentage = (value / total * 100).toFixed(2) + '%';
                            return percentage;
                        },
                        color: '#fff',
                        font: {
                            weight: 'bold',
                            size: 14
                        },
                        textAlign: 'center',
                        textAnchor: 'middle'
                    }
                }
            }
        });

        const regionLabels = <?php echo $region_labels_json; ?>;
        const regionCounts = <?php echo $region_counts_json; ?>;
        
        const ctxRegionPie = document.getElementById('pieChart5').getContext('2d');
        const regionPieChart = new Chart(ctxRegionPie, {
            type: 'doughnut',
            data: {
                labels: regionLabels,
                datasets: [{
                    label: 'Regions',
                    data: regionCounts,
                    backgroundColor: [
                        '#d35400', '#138d75', '#FFCE56', '#5499c7', '#2e4053', '#900C3F'
                    ]
                }]
            },
            options: {
                responsive: true,
                onClick: (event, elements) => {
                    if (elements.length > 0) {
                        const segmentIndex = elements[0].index;
                        const label = regionPieChart.data.labels[segmentIndex];
                        window.location.href = `details/details_region.php?region=${encodeURIComponent(label)}`;
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'ภูมิภาค'
                    },
                    datalabels: {
                        display: (context) => {
                            return context.dataset.data[context.dataIndex] > 20;
                        },
                        color: '#fff',
                        font: {
                            weight: 'bold',
                            size: 14
                        },
                        anchor: 'center',
                        align: 'center',
                        padding: {
                            bottom: 5
                        }
                    },
                }
            }
        });
    </script>
</body>
</html>
