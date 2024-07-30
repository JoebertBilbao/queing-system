<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require '../database/db.php';

if (!isset($_SESSION['department'])) {
    // Redirect to login page or show an error
    header("Location: login.php");
    exit;
}
$user_department = $_SESSION['department'];

$department_head_map = [
    'BSIT' => 'BSIT - Dino Illustrisimo',
    'BSED' => 'BSED - DR. Priscilla F. Canoy',
    'BEED' => 'BEED - Mr. Reyan Diaz',
    'BSBA' => 'BSBA - Mrs. Mariel D. Castillo',
    'BSHM' => 'BSHM - Mr. Cristy Forsuelo'
];

$department_head = $department_head_map[$user_department] ?? '';
// Initialize variables
$limit = 10; // Number of records per page
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;
$search = isset($_GET['search']) ? $_GET['search'] : '';

$search_query = "WHERE department_head = '$department_head'";
if (!empty($search)) {
    $search_query .= " AND (full_name LIKE '%$search%' OR email LIKE '%$search%' OR phone LIKE '%$search%' OR address LIKE '%$search%' OR interest LIKE '%$search%' OR experience LIKE '%$search%' OR expectations LIKE '%$search%' OR interviewer LIKE '%$search%' OR availability LIKE '%$search%' OR additional_comments LIKE '%$search%')";
}

$sql = "SELECT full_name, email, phone, address, interest, experience, expectations, interviewer, department_head, availability, additional_comments FROM interview_form $search_query LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);

// Count total records for pagination
$count_sql = "SELECT COUNT(*) as total FROM interview_form $search_query";
$count_result = $conn->query($count_sql);
$total_records = $count_result ? $count_result->fetch_assoc()['total'] : 0;
$total_pages = ceil($total_records / $limit);

$conn->close();
?>

<?php include('header.php'); ?>
<style>
    .cell {
        max-width: 200px; /* Adjust as needed */
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
</style>
<div class="app-wrapper">

    <div class="app-content pt-3 p-md-3 p-lg-4">
        <div class="container-xl">
            <div class="row g-3 mb-4 align-items-center justify-content-between">
                <div class="col-auto">
                    <h1 class="app-page-title mb-0">Interview Forms</h1>
                </div>
                <div class="col-auto">
                    <div class="page-utilities">
                    <div class="row g-2 justify-content-start justify-content-md-end align-items-center">
                            <div class="col-auto">
                                <input type="text" id="search-forms" name="search" class="form-control search-forms" placeholder="Search" value="<?php echo htmlspecialchars($search); ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-content" id="forms-table-tab-content">
                <div class="tab-pane fade show active" id="forms-all" role="tabpanel" aria-labelledby="forms-all-tab">
                    <div class="app-card app-card-forms-table shadow-sm mb-5">
                        <div class="app-card-body">
                            <div class="table-responsive">
                                <table class="table app-table-hover mb-0 text-left">
                                    <thead>
                                        <tr>
                                            <th class="cell">Full Name</th>
                                            <th class="cell">Email</th>
                                            <th class="cell">Phone</th>
                                            <th class="cell">Address</th>
                                            <th class="cell">Interest</th>
                                            <th class="cell">Experience</th>
                                            <th class="cell">Expectations</th>
                                            <th class="cell">Interviewer</th>
                                            <th class="cell">Department Head</th>
                                            <th class="cell">Availability</th>
                                            <th class="cell">Additional Comments</th>
                                            <th class="cell">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                       if ($result && $result->num_rows > 0) {
                                        while($row = $result->fetch_assoc()) {
                                            $studentData = htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8');
                                            echo "<tr>
                                                    <td class='cell'>" . $row["full_name"] . "</td>
                                                    <td class='cell'>" . $row["email"] . "</td>
                                                    <td class='cell'>" . $row["phone"] . "</td>
                                                    <td class='cell'>" . $row["address"] . "</td>
                                                    <td class='cell'>" . $row["interest"] . "</td>
                                                    <td class='cell'>" . $row["experience"] . "</td>
                                                    <td class='cell'>" . $row["expectations"] . "</td>
                                                    <td class='cell'>" . $row["interviewer"] . "</td>
                                                    <td class='cell'>" . $row["department_head"] . "</td>
                                                    <td class='cell'>" . $row["availability"] . "</td>
                                                    <td class='cell'>" . $row["additional_comments"] . "</td>
                                                    <td class='cell'><button class='btn-sm app-btn-secondary view-details' data-student='" . $studentData . "'>View</button></td>
                                                  </tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='12' class='cell'>No records found</td></tr>";
                                    }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <!--//table-responsive-->
                        </div>
                        <!--//app-card-body-->
                    </div>
                    <div class="modal fade" id="studentModal" tabindex="-1" aria-labelledby="studentModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="studentModalLabel">Student Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="studentModalBody">
        <!-- Student details will be inserted here -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
                    <!--//app-card-->
                    <nav class="app-pagination">
                        <ul class="pagination justify-content-center">
                            <?php if ($page > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?php echo $page - 1; ?>&search=<?php echo htmlspecialchars($search); ?>" tabindex="-1" aria-disabled="true">Previous</a>
                                </li>
                            <?php else: ?>
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                                </li>
                            <?php endif; ?>

                            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                <li class="page-item <?php if ($i == $page) echo 'active'; ?>"><a class="page-link" href="?page=<?php echo $i; ?>&search=<?php echo htmlspecialchars($search); ?>"><?php echo $i; ?></a></li>
                            <?php endfor; ?>

                            <?php if ($page < $total_pages): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?php echo $page + 1; ?>&search=<?php echo htmlspecialchars($search); ?>">Next</a>
                                </li>
                            <?php else: ?>
                                <li class="page-item disabled">
                                    <a class="page-link" href="#">Next</a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                    <!--//app-pagination-->
                </div>
            </div>
            <!--//tab-content-->
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const viewButtons = document.querySelectorAll('.view-details');
    const modalBody = document.getElementById('studentModalBody');
    const studentModal = new bootstrap.Modal(document.getElementById('studentModal'));

    viewButtons.forEach(button => {
        button.addEventListener('click', function() {
            const studentData = JSON.parse(this.getAttribute('data-student'));
            let modalContent = '<dl class="row">';
            for (const [key, value] of Object.entries(studentData)) {
                modalContent += `
                    <dt class="col-sm-3">${key.replace('_', ' ').toUpperCase()}</dt>
                    <dd class="col-sm-9">${value}</dd>
                `;
            }
            modalContent += '</dl>';
            modalBody.innerHTML = modalContent;
            studentModal.show();
        });
    });
});
</script>
    <script>
    function logout() {
        window.location.href = 'index.php';
    }
    </script>

<script src="assets/plugins/popper.min.js"></script>
<script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/js/app.js"></script>

</body>
</html>
