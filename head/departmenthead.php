<?php
// Security Headers
header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload"); // Enforces HTTPS
header("X-Frame-Options: SAMEORIGIN"); // Protects against clickjacking
header("X-Content-Type-Options: nosniff"); // Prevents MIME type sniffing
header("Referrer-Policy: no-referrer-when-downgrade"); // Controls referrer information sent with requests
header("Permissions-Policy: accelerometer=(), autoplay=(), camera=(), geolocation=(), gyroscope=(), magnetometer=(), microphone=(), payment=(), usb=()"); // Restricts feature permissions

// session_start();
include('header.php');
include('../database/db.php');

if (!isset($_SESSION['department'])) {
    header("Location: index.php");
    exit;
}

$department = $_SESSION['department'];      

$sql = "SELECT id, name, email, course, year_level, status, semester, step_status FROM users WHERE step_status = 'step 2' AND course = ?";
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
                    <h1 class="app-page-title mb-0">Department Head OFFICE(Step 2)</h1>
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
                                            <th class="cell">ID</th>
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
                                                echo "<td class='cell'><button class='btn btn-sm btn-primary proceed-btn' data-id='" . $row['id'] . "'>Proceed</button>
                                                  <button class='btn btn-sm btn-secondary edit-btn' data-id='" . $row['id'] . "' data-course='" . htmlspecialchars($row['course']) . "'>Edit</button></td>";
                                                echo "</tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='8' class='cell'>No records found</td></tr>";
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
<div class="modal fade" id="editCourseModal" tabindex="-1" aria-labelledby="editCourseModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCourseModalLabel">Edit Student Course</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editCourseForm">
                    <input type="hidden" id="studentId" name="studentId">
                    <div class="mb-3">
                        <label for="course" class="form-label">Course</label>
                        <select class="form-select" name="course" id="course">
                            <option value="bsit">Bachelor of Science in Information Technology (BSIT)</option>
                            <option value="bshm">Bachelor of Science in Hospitality Management (BSHM)</option>
                            <option value="bsba">Bachelor of Science in Business Administration (BSBA)</option>
                            <option value="bsed">Bachelor of Secondary Education (BSED)</option>
                            <option value="beed">Bachelor of Elementary Education (BEED)</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveCourseBtn">Save changes</button>
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
                    data: { id: studentId, step: 'step 3' },
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

    $('.edit-btn').on('click', function() {
        var studentId = $(this).data('id');
        var currentCourse = $(this).data('course');
        
        $('#studentId').val(studentId);
        $('#course').val(currentCourse);
        
        $('#editCourseModal').modal('show');
    });

    $('#saveCourseBtn').on('click', function() {
        var studentId = $('#studentId').val();
        var newCourse = $('#course').val();
        
        $.ajax({
            type: 'POST',
            url: '../stepproceed/update_course.php', // You'll need to create this PHP file
            data: { id: studentId, course: newCourse },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire(
                        'Updated!',
                        'The student\'s course has been updated.',
                        'success'
                    ).then(() => {
                        location.reload(); // Reload the page to reflect changes
                    });
                } else {
                    Swal.fire(
                        'Error!',
                        'There was an error updating the course: ' + response.message,
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
        
        $('#editCourseModal').modal('hide');
    });
});

</script>
<?php
include 'footer.php';
?>
