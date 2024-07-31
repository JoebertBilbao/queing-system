<?php
// Start session and include necessary files
// session_start();
include('header.php');
include('../database/db.php');

// Check if the department session is set; if not, redirect to login
if (!isset($_SESSION['department'])) {
    header("Location: index.php");
    exit;
}

$department = $_SESSION['department'];

// Prepare the SQL query to fetch students for the specified department
$sql = "SELECT id, name, email, course, year_level, status, semester FROM users WHERE course = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $department);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="app-wrapper">
    <div class="app-content pt-3 p-md-3 p-lg-4">
        <div class="container-xl">
            <div class="row g-3 mb-4 align-items-center justify-content-between">
                <div class="col-auto">
                    <h1 class="app-page-title mb-0">Student Records</h1>
                </div>
                <div class="col-auto">
                    <button class="btn btn-primary" onclick="printTable()">Print</button>
                </div>
            </div>

            <div class="tab-content" id="orders-table-tab-content">
                <div class="tab-pane fade show active" id="orders-all" role="tabpanel" aria-labelledby="orders-all-tab">
                    <div class="app-card app-card-orders-table shadow-sm mb-5">
                        <div class="app-card-body">
                            <div class="table-responsive" id="student-records-table">
                                <table class="table app-table-hover mb-0 text-left">
                                    <thead>
                                        <tr>
                                            <th class="cell">ID</th>
                                            <th class="cell">Student Name</th>
                                            <th class="cell">Email</th>
                                            <th class="cell">Course</th>
                                            <th class="cell">Year Level</th>
                                            <th class="cell">Student Type</th>
                                            <th class="cell">Semester</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $display_id = 1;
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                echo "<tr>";
                                                echo "<td class='cell'>" . htmlspecialchars($display_id++) . "</td>"; // Display sequential number
                                                echo "<td class='cell'>" . htmlspecialchars($row['name']) . "</td>";
                                                echo "<td class='cell'>" . htmlspecialchars($row['email']) . "</td>";
                                                echo "<td class='cell'>" . htmlspecialchars($row['course']) . "</td>";
                                                echo "<td class='cell'>" . htmlspecialchars($row['year_level']) . "</td>";
                                                echo "<td class='cell'>" . htmlspecialchars($row['status']) . "</td>";
                                                echo "<td class='cell'>" . htmlspecialchars($row['semester']) . "</td>";
                                                echo "</tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='7' class='cell'>No records found</td></tr>";
                                        }
                                        $stmt->close();
                                        $conn->close();
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function printTable() {
    var divToPrint = document.getElementById('student-records-table');
    var newWin = window.open('');
    newWin.document.write('<html><head><title>Print</title>');
    newWin.document.write('<style>table { width: 100%; border-collapse: collapse; } table, th, td { border: 1px solid black; padding: 8px; } th, td { text-align: left; } img { width: 100px; height: auto; display: block; margin: 0 auto; }</style>');
    newWin.document.write('</head><body>');
    newWin.document.write('<div style="text-align: center;">');
    newWin.document.write('<img src="assets/image/download.png" alt="MCC Logo">');
    newWin.document.write('<h1>MCC QUEUEING SYSTEM</h1>');
    newWin.document.write('<h2>Student Records</h2>');
    newWin.document.write('</div>');
    newWin.document.write(divToPrint.outerHTML);
    newWin.document.write('</body></html>');
    newWin.document.close();
    newWin.print();
    newWin.close();
}
</script>

<?php
include 'footer.php';
?>
