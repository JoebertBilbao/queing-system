<?php 
include 'header.php';
include('../database/db.php');

$sql = "SELECT COUNT(*) as request_count FROM requests";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$request_count = $row['request_count'];
?>

<div class="app-wrapper">
    <div class="app-content pt-3 p-md-3 p-lg-4">
        <div class="container-xl">
            <h1 class="app-page-title">Dashboard</h1>
            <div class="row g-4 mb-4">
                <div class="col-6 col-lg-3">
                    <div class="app-card app-card-stat shadow-sm h-100">
                        <div class="app-card-body p-3 p-lg-4">
                            <h4 class="stats-type mb-1">Total Student Requests</h4>
                            <div class="stats-figure"><?php echo $request_count; ?></div>
                            <div class="stats-meta">
                                Active Requests
                            </div>
                        </div>
                        <a class="app-card-link-mask" href="#"></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>