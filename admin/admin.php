<?php
include('header.php');
include('../database/db.php');

// Initialize arrays
$courses = [];
$counts = [];
$totalStudents = 0;
$stepsLabels = [];
$stepsData = [];
$totalCompletedStudents = 0;

// Fetch total completed students
$sqlCompleted = "SELECT COUNT(*) AS total_completed FROM users WHERE step_status = 'Completed'";
$resultCompleted = $conn->query($sqlCompleted);

if ($resultCompleted === FALSE) {
    die("Error executing query for completed steps: " . $conn->error);
}

if ($resultCompleted->num_rows > 0) {
    $row = $resultCompleted->fetch_assoc();
    $totalCompletedStudents = $row['total_completed'];
}

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
        $totalStudents += $row['count'];
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

<style>
    body {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
        margin: 0;
        font-family: 'Poppins', sans-serif;
        background-color: #f7f9fc;
    }

    .main-content {
        padding: 20px;
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .header {
        text-align: left;
        color: white;
        margin-bottom: 20px;
    }

    .header h1 {
        margin: 0;
        font-size: 24px;
    }

    .header p {
        margin: 5px 0 0;
        font-size: 18px;
        color:black;
    }

    .cards-container {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
    }

    .card {
        background: white;
        flex: 1;
        min-width: 200px;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
        text-align: center;
    }

    .card h3 {
        margin: 0;
        font-size: 2em;
        color: #4e54c8;
    }

    .charts-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
    }

    .chart-container {
        background: white;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
        height: 400px;
    }
</style>
<div class="app-wrapper">
    <div class="app-content pt-3 p-md-3 p-lg-4">
        <div class="container-xl">
<div class="main-content">
    <div class="header">
        <h1>Welcome to the Dashboard</h1>
        <p>Overview of student progress and analytics</p>
    </div>

    <div class="cards-container">
        <div class="card">
            <h3><?php echo $totalCompletedStudents; ?></h3>
            <p>Total Completed Students</p>
        </div>
        <div class="card">
            <h3><?php echo $totalStudents; ?></h3>
            <p>Total Students</p>
        </div>
    </div>

    <div class="charts-container">
        <div class="chart-container">
            <canvas id="courseChart"></canvas>
        </div>
        <div class="chart-container">
            <canvas id="completionChart"></canvas>
        </div>
        <div class="chart-container">
            <canvas id="stepsChart"></canvas>
        </div>
    </div>
</div>
</div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const labels = <?php echo json_encode($courses); ?>;
    const data = <?php echo json_encode($counts); ?>;
    const totalStudents = <?php echo $totalStudents; ?>;
    const stepsLabels = <?php echo json_encode($stepsLabels); ?>;
    const stepsData = <?php echo json_encode($stepsData); ?>;

    const colors = ['rgba(54, 162, 235, 0.7)', 'rgba(255, 99, 132, 0.7)', 'rgba(75, 192, 192, 0.7)'];

    new Chart(document.getElementById('courseChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Students per Course',
                data: data,
                backgroundColor: colors,
            }]
        }
    });

    new Chart(document.getElementById('completionChart').getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                label: 'Completion Chart',
                data: data,
                backgroundColor: colors,
            }]
        }
    });

    new Chart(document.getElementById('stepsChart').getContext('2d'), {
        type: 'line',
        data: {
            labels: stepsLabels,
            datasets: [{
                label: 'Steps Progress',
                data: stepsData,
                backgroundColor: 'rgba(153, 102, 255, 0.7)',
            }]
        }
    });
</script>

<?php include 'footer.php'; ?>
