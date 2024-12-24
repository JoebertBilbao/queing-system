<?php
// Start session and include necessary files
// session_start();
include('header.php');
include('../database/db.php');

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
                    <button class="btn btn-primary" onclick="printRecords()">Print</button>
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
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                echo "<tr>";
                                                echo "<td class='cell'>" . htmlspecialchars($row['id']) . "</td>";
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
function printRecords() {
    const printContent = `
        <html>
        <head>
            <title>Print Student Records</title>
            <style>
                @media print {
                    @page {
                        margin: 0;
                        size: auto;
                    }
                    body {
                        font-family: Arial, sans-serif;
                        margin: 20mm 15mm;
                    }
                    .header-container {
                        text-align: center;
                        margin-bottom: 20px;
                        width: 100%; /* Ensures alignment with table */
                    }
                    .header-container img {
                        max-width: 500px; /* Adjust logo size */
                        height: auto;
                    }
                    .header-container h2 {
                        font-size: 32px; /* Adjust header size */
                        margin: 10px 0;
                    }
                    table {
                        width: 85%;
                        border-collapse: collapse;
                        border: 1px solid black;
                        margin: 0 auto; /* Centers the table */
                    }
                    table, th, td {
                        border: 1px solid black;
                    }
                    th, td {
                        padding: 8px;
                        text-align: left;
                    }
                }
            </style>
        </head>
        <body>
            <div class="header-container">
                <img src="https://mccqueueingsystem.com/assets/image/Picture1.png" alt="MCC Logo">
                <h2>Student Records</h2>
            </div>
            ${document.getElementById('student-records-table').outerHTML}
        </body>
        </html>
    `;

    const iframe = document.createElement('iframe');
    iframe.style.display = 'none';
    document.body.appendChild(iframe);
    
    iframe.contentWindow.document.open();
    iframe.contentWindow.document.write(printContent);
    iframe.contentWindow.document.close();
    
    iframe.onload = function() {
        iframe.contentWindow.print();
        document.body.removeChild(iframe);
    };
}
</script>

<?php
include 'footer.php';
?>
