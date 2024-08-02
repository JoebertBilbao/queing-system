<div class="app-utilities col-auto">
    <?php
                session_start();
                if (!isset($_SESSION['email'])) {
                    header('Location: index.php');
                    exit();
                }
                ?>
      <div class="app-utility-item app-user-dropdown dropdown">
        <a class="dropdown-toggle" id="user-dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
            aria-expanded="false"><img src="assets/images/user1.png" alt="user profile"></a>
        <ul class="dropdown-menu" aria-labelledby="user-dropdown-toggle">
            <li>
                <hr class="dropdown-divider">
               
            </li>
            <li><a class="dropdown-item" href="logout.php">Log Out</a></li>
        </ul>
    </div>
    <!--//app-user-dropdown-->
</div>
<!-- 
<script src="assets/plugins/popper.min.js"></script>
<script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/plugins/chart.js/chart.min.js"></script>
<script src="assets/js/index-charts.js"></script>
<script src="assets/js/app.js"></script> -->
