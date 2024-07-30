<?php
require '../database/db.php';

// Fetch all enroll requests
$result = $conn->query("SELECT * FROM enroll_requests");

// Include your header file
include 'header.php';
?>

<div class="app-wrapper">
    <div class="app-content pt-3 p-md-3 p-lg-4">
        <div class="container-xl">
            <div class="row g-3 mb-4 align-items-center justify-content-between">
                <div class="col-auto">
                    <h1 class="app-page-title mb-0">Student List</h1>
                </div>
                <div class="col-auto">
                    <div class="page-utilities">
                        <div class="row g-2 justify-content-start justify-content-md-end align-items-center">
                            <div class="col-auto">
                                <form class="table-search-form row gx-1 align-items-center">
                                    <div class="col-auto">
                                        <input type="text" id="search-orders" name="searchorders" class="form-control search-orders" placeholder="Search">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
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
                                            <th class="cell">First Name</th>
                                            <th class="cell">Last Name</th>
                                            <th class="cell">Email</th>
                                            <th class="cell">Birth of Date</th>
                                            <th class="cell">Address</th>
                                            <th class="cell">Course</th>
                                            <th class="cell">High School</th>
                                            <th class="cell">Message</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($row = $result->fetch_assoc()): ?>
                                            <tr>
                                                <td class="cell"><?php echo htmlspecialchars($row['firstname']); ?></td>
                                                <td class="cell"><?php echo htmlspecialchars($row['lastname']); ?></td>
                                                <td class="cell"><?php echo htmlspecialchars($row['email']); ?></td>
                                                <td class="cell"><?php echo htmlspecialchars($row['date_of_birth']); ?></td>
                                                <td class="cell"><?php echo htmlspecialchars($row['address']); ?></td>
                                                <td class="cell"><?php echo htmlspecialchars($row['course']); ?></td>
                                                <td class="cell"><?php echo htmlspecialchars($row['high_school']); ?></td>
                                                <td class="cell"><?php echo htmlspecialchars($row['message']); ?></td>
                                            </tr>
                                        <?php endwhile; ?>
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

<?php
// Free the result set
$result->free();

// Close the database connection
$conn->close();

// Include your footer file
include 'footer.php';
?>
