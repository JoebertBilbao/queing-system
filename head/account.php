<div class="app-utilities col-auto">

<?php
                session_start();
                if (!isset($_SESSION['department'])) {
                    header('Location: index');
                    exit();
                }
                 $name = $_SESSION['name'];
                ?>
                
    <div class="app-utility-item app-user-dropdown dropdown">
        <a class="dropdown-toggle" id="user-dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
            aria-expanded="false">  <?php echo htmlspecialchars($name); ?> <img src="assets/images/user1.png" alt="user profile"></a>
        <ul class="dropdown-menu" aria-labelledby="user-dropdown-toggle">
            <li>
                <hr class="dropdown-divider">
            </li>
            <li><a class="dropdown-item" style="cursor: pointer;" id="logoutBtn">Log Out</a></li>
        </ul>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById('logoutBtn').addEventListener('click', function() {
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to log out?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, log out',
                cancelButtonText: 'No, cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Perform the logout operation
                    Swal.fire({
                        title: 'Logging out...',
                        text: 'You are being logged out.',
                        icon: 'success',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = 'logout.php';
                    });
                }
            });
        });
    </script>
<script src="assets/plugins/popper.min.js"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/plugins/chart.js/chart.min.js"></script>
    <script src="assets/js/index-charts.js"></script>
    <script src="assets/js/app.js"></script>
