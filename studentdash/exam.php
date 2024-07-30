<?php include 'index.php'; ?>
<?php include '../database/db.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$user_score = null;
$has_requested = false;

if (isset($_SESSION['full_name'])) {
    $full_name = $_SESSION['full_name'];
    $sql = "SELECT score, request_date FROM requests WHERE full_name = ? ORDER BY request_date DESC LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $full_name);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $user_score = $row['score'];
        $has_requested = true;
    }
    $stmt->close();
}
?>

<style>
    body {
        background-color: #f8f9fa;
    }
    
    .joebert {
        background-color: white;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    .score-container {
        display: flex;
        justify-content: center;
        align-items: center;
        border: 5px solid #0FFF50;
        background-color: white;
        color: green;
        width: 150px;
        height: 150px;
        border-radius: 50%;
        margin: 0 auto;
        font-size: 1.5em;
        font-weight: bold;
        text-align: center;
    }
</style>

<div class="container">
    <div class="text-center mt-5">
        <h1>Exam Result</h1>
    </div>
    <div class="row ">
        <div class="col-lg-7 mx-auto">
            <div class="mt-2 mx-auto p-4 bg-light">
                <div class="card-body bg-light">
                    <div class="container joebert">
                        <?php if (!$has_requested): ?>
                            <form action="../action/request_exam.php" method="post" class="request-form">
                                <button type="submit" name="request_exam" class="btn btn-primary">Request Exam Result</button>
                            </form>
                        <?php endif; ?>
                        <div style="text-align: center;" class="mt-5">
                            <div class="score-container">
                                <?php
                                if ($user_score !== null) {
                                    echo "<h2>" . $user_score . "</h2>";
                                } elseif ($has_requested) {
                                    echo "<h2>Wait for your score</h2>";
                                } else {
                                    echo "<h2>Request a score</h2>";
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if (isset($_SESSION['request_success']) && $_SESSION['request_success']): ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Request submitted successfully.',
            showConfirmButton: false,
            timer: 1500
        });
    </script>
    <?php unset($_SESSION['request_success']); ?>
<?php endif; ?>

<?php include 'footer.php'; ?>