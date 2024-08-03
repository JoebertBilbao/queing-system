<?php
include('header.php');

include('../database/db.php');


$results_per_page = 10;
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($current_page - 1) * $results_per_page;

$sql = "SELECT id, full_name, course, request_date FROM requests WHERE score IS NULL ORDER BY request_date DESC LIMIT $offset, $results_per_page";
$result = $conn->query($sql);

$total_results_sql = "SELECT COUNT(*) as count FROM requests WHERE score IS NULL";
$total_results_result = $conn->query($total_results_sql);
$total_results = $total_results_result->fetch_assoc()['count'];
?>

    <div class="app-wrapper">

        <div class="app-content pt-3 p-md-3 p-lg-4">
            <div class="container-xl">
                <div class="row g-3 mb-4 align-items-center justify-content-between">
                    <div class="col-auto">
                        <h1 class="app-page-title mb-0">Request</h1>
                    </div>
                    <div class="col-auto">
                        <div class="page-utilities">
                            <div class="row g-2 justify-content-start justify-content-md-end align-items-center">
                                <div class="col-auto">
                                    <form class="table-search-form row gx-1 align-items-center">
                                        <div class="col-auto">
                                            <input type="text" id="search-orders" name="searchorders"
                                                class="form-control search-orders" placeholder="Search">
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-content" id="orders-table-tab-content">
                    <div class="tab-pane fade show active" id="orders-all" role="tabpanel"
                        aria-labelledby="orders-all-tab">
                        <div class="app-card app-card-orders-table shadow-sm mb-5">
                            <div class="app-card-body">
                                <div class="table-responsive">
                                    <table class="table app-table-hover mb-0 text-left">
                                        <thead>
                                            <tr>
                                                <th class="cell">Student Name</th>
                                                <th class="cell">Email</th>
                                                <th class="cell">Course</th>
                                                <th class="cell">Year Level</th>
                                                <th class="cell">Freshmen / Old Student</th>
                                                <th class="cell">Semester</th>
                                                <th class="cell">Status</th>
                                                <th class="cell"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                    <?php
                                   if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<tr data-student-id="' . $row['id'] . '">';
                                        echo '<td class="cell">' . htmlspecialchars($row['full_name']) . '</td>';
                                       
                                        echo '<td class="cell">' . htmlspecialchars($row['request_date']) . '</td>';
                                        echo '<td class="cell"><button class="btn btn-primary btn-sm" onclick="openScoreModal(' . $row['id'] . ', \'' . htmlspecialchars($row['full_name']) . '\')">Add Score</button></td>';
                                        echo '</tr>';
                                    }
                                } else {
                                    echo '<tr><td colspan="4">No requests found.</td></tr>';
                                }
                                    ?>
                                    </tbody>
                                    </table>
                                </div>
                                <!--//table-responsive-->

                            </div>
                            <!--//app-card-body-->
                        </div>
                        <nav class="app-pagination">
                        <ul class="pagination justify-content-center">
                            <?php
                            $total_pages = ceil($total_results / $results_per_page);

                            for ($i = 1; $i <= $total_pages; $i++) {
                                echo '<li class="page-item ' . ($current_page == $i ? 'active' : '') . '">';
                                echo '<a class="page-link" href="?page=' . $i . '">' . $i . '</a>';
                                echo '</li>';
                            }
                            ?>
                        </ul>
                    </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="scoreModal" tabindex="-1" aria-labelledby="scoreModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="scoreModalLabel">Add Score</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="scoreForm">
                    <input type="hidden" id="studentId" name="studentId">
                    <div class="mb-3">
                        <label for="studentName" class="form-label">Student Name</label>
                        <input type="text" class="form-control" id="studentName" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="score" class="form-label">Score</label>
                        <input type="number" class="form-control" id="score" name="score" min="0" max="100" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="submitScore()">Submit Score</button>
            </div>
        </div>
    </div>
</div>
<script>
function openScoreModal(studentId, studentName) {
    document.getElementById('studentId').value = studentId;
    document.getElementById('studentName').value = studentName;
    var scoreModal = new bootstrap.Modal(document.getElementById('scoreModal'));
    scoreModal.show();
}

function submitScore() {
    var studentId = document.getElementById('studentId').value;
    var score = document.getElementById('score').value;
    var studentName = document.getElementById('studentName').value;

    $.ajax({
        url: '../action/submit_score.php',
        type: 'POST',
        data: {
            studentId: studentId,
            score: score,
            fullName: studentName
        },
        success: function(response) {
            console.log('Score submitted successfully');
            var scoreModal = bootstrap.Modal.getInstance(document.getElementById('scoreModal'));
            scoreModal.hide();
            
            var row = document.querySelector('tr[data-student-id="' + studentId + '"]');
            if (row) {
                row.remove();
            }
            
            var tbody = document.querySelector('table tbody');
            if (tbody.children.length === 0) {
                tbody.innerHTML = '<tr><td colspan="4">No requests found.</td></tr>';
            }
            
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'Score submitted successfully!',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            });
        },
        error: function(xhr, status, error) {
            console.error('Error submitting score:', error);
            
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Error submitting score. Please try again.',
                confirmButtonColor: '#d33',
                confirmButtonText: 'OK'
            });
        }
    });
}
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="assets/plugins/popper.min.js"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/plugins/chart.js/chart.min.js"></script>
    <script src="assets/js/index-charts.js"></script>
    <script src="assets/js/app.js"></script>
<?php
include 'footer.php'
?>