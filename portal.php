<?php
include('database/db.php'); // Include your database connection file

// Initialize arrays
$courses = [];
$counts = [];
$totalStudents = 0;

$stepsLabels = [];
$stepsData = [];

// Fetch data for courses
$sqlCourses = "SELECT course, COUNT(*) AS count FROM users GROUP BY course";
$resultCourses = $conn->query($sqlCourses);

if ($resultCourses === FALSE) {
    die("Error executing query for courses: " . $conn->error);
}

if ($resultCourses->num_rows > 0) {
    while ($row = $resultCourses->fetch_assoc()) {
        $courses[] = $row['course'];
        $counts[] = $row['count'];
        $totalStudents += $row['count']; // Calculate total number of students
    }
}

// Fetch data for steps
$sqlSteps = "SELECT step_status, COUNT(*) AS count FROM users GROUP BY step_status";
$resultSteps = $conn->query($sqlSteps);

if ($resultSteps === FALSE) {
    die("Error executing query for steps: " . $conn->error);
}

if ($resultSteps->num_rows > 0) {
    while ($row = $resultSteps->fetch_assoc()) {
        $stepsLabels[] = 'Step ' . $row['step_status'];
        $stepsData[] = $row['count'];
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PORTALS</title>
    <link href="assets/image/images.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
    
    <!-- Fonts and Vendor CSS Files -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/css/main.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.7.0"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-chart-3d"></script>

    <style>
    body { display: flex; flex-direction: row; min-height: 100vh; margin: 0; font-family: 'Roboto', sans-serif; }
    .sidebar { width: 250px; background-color: rgba(255, 255, 255, 0.8); padding: 15px; height: 100vh; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); position: fixed; top: 0; left: 0; overflow-y: auto; }
    .sidebar .nav-link { display: flex; align-items: center; padding: 10px; text-decoration: none; color: #333; border-radius: 5px; transition: background-color 0.3s ease; }
    .sidebar .nav-link:hover { background-color: #e9ecef; }
    .sidebar .nav-link i { margin-right: 10px; }
    .sidebar .dashboard-link { margin-bottom: 20px; font-weight: bold; }
    .main-content { margin-left: 270px; padding: 20px; flex: 1; }
    .header { text-align: center; margin-bottom: 40px; padding: 20px 0; background-color: transparent; }
    .header img { max-width: 100%; margin-bottom: 10px; opacity: 0.8; }
    .header p { margin: 0; }
    .charts-container { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; }
    .chart-container { width: 100%; height: 400px; }
    .chart-right { grid-column: 2; }
    </style>
</head>
<body class="bg-light">
    <div class="sidebar">
        <div class="header">
            <img src="assets/image/download.png" alt="Madridejos Community College Logo" width="100" height="80">
            <p>MADRIDEJOS COMMUNITY COLLEGE</p>   
        </div>
        <a href="guidance/index.php" class="nav-link"><i class="bi bi-calendar-check"></i> Guidance Office</a>
        <a href="head/index.php" class="nav-link"><i class="bi bi-person-circle"></i> Department Head</a>
        <a href="registrar/index.php" class="nav-link"><i class="bi bi-file-earmark-text"></i> Registrar Office</a>
        <a href="ssc/index.php" class="nav-link"><i class="bi bi-clipboard-data"></i> SSC Office</a>
        <a href="clinic/index.php" class="nav-link"><i class="bi bi-heart"></i> Clinic Office</a>
        <a href="mccea/index.php" class="nav-link"><i class="bi bi-gear"></i> MCCEA Office</a>
        <a href="cor/index.php" class="nav-link"><i class="bi bi-file-earmark-code"></i> COR</a>
        <a href="./index.php" class="nav-link"><i class="bi bi-house-door"></i> Back to Home</a>
    </div>
    <div class="main-content">
        <div class="charts-container">
            <div class="chart-container">
                <canvas id="courseChart"></canvas>
            </div>
            <div class="chart-container chart-right">
                <canvas id="completionChart"></canvas>
            </div>
            <div class="chart-container">
                <canvas id="stepsChart"></canvas>
            </div>
        </div>
        <script>
    // PHP Data to JavaScript for Bar Chart
    const labels = <?php echo json_encode($courses); ?>;
    const data = <?php echo json_encode($counts); ?>;
    const totalStudents = <?php echo $totalStudents; ?>;

    const colors = [
        'rgba(255, 99, 132, 1)',
        'rgba(54, 162, 235, 1)',
        'rgba(255, 206, 86, 1)',
        'rgba(75, 192, 192, 1)',
        'rgba(153, 102, 255, 1)',
        'rgba(255, 159, 64, 1)',
        'rgba(255, 99, 132, 1)',
        'rgba(54, 162, 235, 1)',
        'rgba(255, 206, 86, 1)',
        'rgba(75, 192, 192, 1)'
    ];

    const borderColors = [
        'rgba(255, 99, 132, 1)',
        'rgba(54, 162, 235, 1)',
        'rgba(255, 206, 86, 1)',
        'rgba(75, 192, 192, 1)',
        'rgba(153, 102, 255, 1)',
        'rgba(255, 159, 64, 1)',
        'rgba(255, 99, 132, 1)',
        'rgba(54, 162, 235, 1)',
        'rgba(255, 206, 86, 1)',
        'rgba(75, 192, 192, 1)'
    ];

    // Bar Chart Setup
    const ctx = document.getElementById('courseChart').getContext('2d');
    const courseChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Student List',
                data: data,
                backgroundColor: colors,
                borderColor: borderColors,
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            const percentage = ((tooltipItem.raw / totalStudents) * 100).toFixed(2);
                            return ` ${tooltipItem.label}: ${tooltipItem.raw} (${percentage}%)`;
                        },
                        title: function() {
                            return '';
                        }
                    },
                    bodyFont: {
                        size: 14,
                        weight: 'bold'
                    },
                    titleFont: {
                        size: 16,
                        weight: 'bold'
                    }
                },
                legend: {
                    labels: {
                        font: {
                            size: 14,
                            weight: 'bold'
                        }
                    }
                },
                title: {
                    display: true,
                    font: {
                        size: 16,
                        weight: 'bold'
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        font: {
                            size: 14,
                            weight: 'bold'
                        }
                    }
                },
                x: {
                    ticks: {
                        font: {
                            size: 14,
                            weight: 'bold'
                        }
                    }
                }
            }
        }
    });

    // Doughnut Chart Setup
    const doughnutData = {
        labels: labels,
        datasets: [{
            data: data,
            backgroundColor: colors,
            hoverBackgroundColor: colors.map(color => color.replace('1)', '0.8)'))
        }]
    };

    const ctxDoughnut = document.getElementById('completionChart').getContext('2d');
    const completionChart = new Chart(ctxDoughnut, {
        type: 'doughnut',
        data: doughnutData,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        font: {
                            size: 14,
                            weight: 'bold'
                        }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            const percentage = ((tooltipItem.raw / totalStudents) * 100).toFixed(2);
                            return ` ${tooltipItem.label}: ${tooltipItem.raw} (${percentage}%)`;
                        },
                        title: function() {
                            return '';
                        }
                    },
                    bodyFont: {
                        size: 14,
                        weight: 'bold'
                    },
                    titleFont: {
                        size: 16,
                        weight: 'bold'
                    }
                }
            }
        }
    });

    // Steps Chart Setup
    const stepsLabels = <?php echo json_encode($stepsLabels); ?>;
    const stepsData = <?php echo json_encode($stepsData); ?>;

    const ctxSteps = document.getElementById('stepsChart').getContext('2d');
    const stepsChart = new Chart(ctxSteps, {
        type: 'bar',
        data: {
            labels: stepsLabels,
            datasets: [{
                label: 'Students Step Process',
                data: stepsData,
                backgroundColor: colors,
                borderColor: borderColors,
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            const percentage = ((tooltipItem.raw / totalStudents) * 100).toFixed(2);
                            return ` ${tooltipItem.label}: ${tooltipItem.raw} (${percentage}%)`;
                        },
                        title: function() {
                            return '';
                        }
                    },
                    bodyFont: {
                        size: 14,
                        weight: 'bold'
                    },
                    titleFont: {
                        size: 16,
                        weight: 'bold'
                    }
                },
                legend: {
                    labels: {
                        font: {
                            size: 14,
                            weight: 'bold'
                        }
                    }
                },
                title: {
                    display: true,
                    font: {
                        size: 16,
                        weight: 'bold'
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        font: {
                            size: 14,
                            weight: 'bold'
                        }
                    }
                },
                x: {
                    ticks: {
                        font: {
                            size: 14,
                            weight: 'bold'
                        }
                    }
                }
            }
        }
    });
</script>

    </div>
</body>
</html>

