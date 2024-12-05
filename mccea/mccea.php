<?php
include('header.php');
include('../database/db.php');

if (!isset($_SESSION['email'])) {
    header('Location: index.php');
    exit();
}

$sql = "SELECT id, name, email, course, year_level, status, semester, step_status FROM users WHERE step_status = 'step 6'";
$result = $conn->query($sql);
?>

<div class="app-wrapper">
    <div class="app-content pt-3 p-md-3 p-lg-4">
        <div class="container-xl">
            <div class="row g-3 mb-4 align-items-center justify-content-between">
                <div class="col-auto">
                    <h1 class="app-page-title mb-0">MCCEA OFFICE (Step 6)</h1>
                </div>
            </div>

            <div class="tab-content" id="orders-table-tab-content">
                <div class="tab-pane fade show active" id="orders-all" role="tabpanel" aria-labelledby="orders-all-tab">
                    <div class="app-card app-card-orders-table shadow-sm mb-5">
                        <div class="app-card-body">
                            <div class="table-responsive">
                                <table class="table app-table-hover mb-0 text-left">
                                    <thead>
                                        <tr>
                                            <th class="cell">Queue Numbers</th>
                                            <th class="cell">Student Name</th>
                                            <th class="cell">Email</th>
                                            <th class="cell">Course</th>
                                            <th class="cell">Year Level</th>
                                            <th class="cell">Student Type</th>
                                            <th class="cell">Semester</th>
                                            <th class="cell">Step Status</th>
                                            <th class="cell">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                           $display_id = 1;
                                        if ($result->num_rows > 0) {
                                            while($row = $result->fetch_assoc()) {
                                                echo "<tr>";
                                                echo "<td class='cell'>" . htmlspecialchars($display_id++) . "</td>"; // Display sequential number                                                                                  
                                                echo "<td class='cell'>" . htmlspecialchars($row['name']) . "</td>";
                                                echo "<td class='cell'>" . htmlspecialchars($row['email']) . "</td>";
                                                echo "<td class='cell'>" . htmlspecialchars($row['course']) . "</td>";
                                                echo "<td class='cell'>" . htmlspecialchars($row['year_level']) . "</td>";
                                                echo "<td class='cell'>" . htmlspecialchars($row['status']) . "</td>";
                                                echo "<td class='cell'>" . htmlspecialchars($row['semester']) . "</td>";
                                                echo "<td class='cell'>" . htmlspecialchars($row['step_status']) . "</td>";
                                                echo "<td class='cell'><button class='btn btn-sm btn-primary proceed-btn' data-id='" . $row['id'] . "'>Proceed</button></td>";
                                                echo "</tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='8' class='cell'>No records found</td></tr>";
                                        }
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function() {
    $('.proceed-btn').on('click', function() {
        var $row = $(this).closest('tr');
        var studentId = $(this).data('id');
        
        Swal.fire({
            title: 'Are you sure?',
            text: "This student will be moved to the next step.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, proceed!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: '../stepproceed/proceed_step.php',
                    data: { id: studentId, step: 'step 7' }, // Assuming step 4 is the next step
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire(
                                'Moved!',
                                'The student has been moved to the next step.',
                                'success'
                            ).then(() => {
                                $row.remove();
                            });
                        } else {
                            Swal.fire(
                                'Error!',
                                'There was an error moving the student: ' + response.message,
                                'error'
                            );
                        }
                    },
                    error: function() {
                        Swal.fire(
                            'Error!',
                            'There was an error with the request.',
                            'error'
                        );
                    }
                });
            }
        });
    });
});
</script>
<?php
include 'footer.php';
?>
