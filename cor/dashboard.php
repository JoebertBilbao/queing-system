<?php
require '../database/db.php';

// Fetch total number of records in enroll_requests table
$result = $conn->query("SELECT COUNT(*) AS total FROM uniform_requests");
$row = $result->fetch_assoc();
$totalEnrollRequests = $row['total'];

include 'header.php'; 
?>

<div class="app-wrapper">
    <div class="app-content pt-3 p-md-3 p-lg-4">
        <div class="container-xl">

            <h1 class="app-page-title">Dashboard</h1>

            <div class="row g-4 mb-4">
                <div class="col-6 col-lg-3">
                    <div class="app-card app-card-stat shadow-sm h-100">
                        <div class="app-card-body p-3 p-lg-4">
                            <h4 class="stats-type mb-1">Total Requests</h4>
                            <div class="stats-figure"><?php echo $totalEnrollRequests; ?></div>
                            <div class="stats-meta text-success">
                                <!-- Optional: Add an icon or additional information -->
                                <!-- Example: -->
                                <!-- <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-up"
                                    fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M8 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L7.5 2.707V14.5a.5.5 0 0 0 .5.5z" />
                                </svg> 20% -->
                            </div>
                        </div>
                        <!--//app-card-body-->
                        <a class="app-card-link-mask" href="#"></a>
                    </div>
                    <!--//app-card-->
                </div>
            </div>
            <!--//row-->

        </div>
    </div>
</div>

<script>
function logout() {
    window.location.href = 'index.php';
}
</script>

<?php
include 'footer.php'; 
?>
