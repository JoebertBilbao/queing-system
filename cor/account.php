<div class="app-utilities col-auto">
    <div class="app-utility-item app-user-dropdown dropdown">
    <?php
                session_start();
                if (!isset($_SESSION['email'])) {
                    header('Location: index.php');
                    exit();
                }
                $userName = $_SESSION['email'];
                ?>
        <a class="dropdown-toggle" id="user-dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
            aria-expanded="false"> <?php echo htmlspecialchars($userName); ?> <i class="fas fa-user-circle"></i> </a>
        <ul class="dropdown-menu" aria-labelledby="user-dropdown-toggle">
            <li>
                <hr class="dropdown-divider">
               
            </li>
            <li><a class="dropdown-item" href="logout.php">Log Out</a></li>
        </ul>
    </div>
    <!--//app-user-dropdown-->
</div>
