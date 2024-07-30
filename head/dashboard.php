<?php
include 'header.php'; 
require '../database/db.php';

$department_head_map = [
    'BSIT' => 'BSIT - Dino Illustrisimo',
    'BSED' => 'BSED - DR. Priscilla F. Canoy',
    'BEED' => 'BEED - Mr. Reyan Diaz',
    'BSBA' => 'BSBA - Mrs. Mariel D. Castillo',
    'BSHM' => 'BSHM - Mr. Cristy Forsuelo'
];

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$user_department = $_SESSION['department'] ?? '';

if (array_key_exists($user_department, $department_head_map)) {
    $department_head = $department_head_map[$user_department];

    $count_sql = "SELECT COUNT(*) as total FROM interview_form WHERE department_head = '$department_head'";
    $count_result = $conn->query($count_sql);
    $total_students = $count_result ? $count_result->fetch_assoc()['total'] : 0;
} else {
    $total_students = 0;
}

$conn->close();
?>

<div class="app-wrapper">
    <div class="app-content pt-3 p-md-3 p-lg-4">
        <div class="container-xl">
            <h1 class="app-page-title">Dashboard</h1>
            
            <?php if ($total_students > 0): ?>
            <div class="row g-4 mb-4">
                <div class="col-6 col-lg-3">
                    <div class="app-card app-card-stat shadow-sm h-100">
                        <div class="app-card-body p-3 p-lg-4">
                            <h4 class="stats-type mb-1">Total Students for <?php echo $user_department; ?></h4>
                            <div class="stats-figure"><?php echo $total_students; ?></div>
                        </div>
                    </div>
                </div>
            </div>
            <?php else: ?>
            <div class="alert alert-info" role="alert">
                No data available for <?php echo $user_department; ?> department.
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
