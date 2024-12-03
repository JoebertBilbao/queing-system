<?php
// Add HTTP security headers
header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload"); // Enforce HTTPS
header("X-Frame-Options: SAMEORIGIN"); // Prevent clickjacking
header("X-Content-Type-Options: nosniff"); // Prevent MIME-type sniffing
header("Referrer-Policy: no-referrer-when-downgrade"); // Control the referrer information
header("Permissions-Policy: geolocation=(), microphone=(), camera=()"); // Control browser features
// Redirect to admin/index.php

include('header.php');
include('../database/db.php');


// Fetch users from database
$result = $conn->query("SELECT id, name, email FROM mccea");
?>

<div class="app-wrapper">
    <div class="app-content pt-3 p-md-3 p-lg-4">
        <div class="container-xl">
            <div class="row g-3 mb-4 align-items-center justify-content-between">
                <div class="col-auto">
                    <h1 class="app-page-title mb-0">Manage Users</h1>
                </div>
                <div class="col-auto">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#userModal">
                        Add New User
                    </button>
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
                                            <th class="cell">Name</th>
                                            <th class="cell">Email</th>
                                            <th class="cell">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($row = $result->fetch_assoc()): ?>
                                            <tr>
                                                <td class="cell"><?php echo htmlspecialchars($row['name']); ?></td>
                                                <td class="cell"><?php echo htmlspecialchars($row['email']); ?></td>
                                                <td class="cell">
                                                    <button class="btn btn-sm btn-primary" onclick="editUser(<?php echo $row['id']; ?>, '<?php echo htmlspecialchars($row['name'], ENT_QUOTES); ?>', '<?php echo htmlspecialchars($row['email'], ENT_QUOTES); ?>')">Edit</button>
                                                    <button class="btn btn-sm btn-danger" onclick="deleteUser(<?php echo $row['id']; ?>)">Delete</button>
                                                </td>
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

<!-- User Modal -->
<div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel">Add/Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="userForm" action="action/process_user.php" method="post">
                    <input type="hidden" id="action" name="action" value="add">
                    <input type="hidden" id="userId" name="id" value="">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password">
                        <small class="form-text text-muted">Leave blank to keep current password when editing.</small>
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function editUser(id, name, email) {
    document.getElementById('action').value = 'edit';
    document.getElementById('userId').value = id;
    document.getElementById('name').value = name;
    document.getElementById('email').value = email;
    document.getElementById('password').value = '';
    document.getElementById('userModalLabel').textContent = 'Edit User';
    new bootstrap.Modal(document.getElementById('userModal')).show();
}

function deleteUser(id) {
    if (confirm('Are you sure you want to delete this user?')) {
        var form = document.createElement('form');
        form.method = 'POST';
        form.action = 'action/process_user.php';
        
        var actionInput = document.createElement('input');
        actionInput.type = 'hidden';
        actionInput.name = 'action';
        actionInput.value = 'delete';
        form.appendChild(actionInput);
        
        var idInput = document.createElement('input');
        idInput.type = 'hidden';
        idInput.name = 'id';
        idInput.value = id;
        form.appendChild(idInput);
        
        document.body.appendChild(form);
        form.submit();
    }
}

document.getElementById('userModal').addEventListener('hidden.bs.modal', function () {
    document.getElementById('action').value = 'add';
    document.getElementById('userId').value = '';
    document.getElementById('name').value = '';
    document.getElementById('email').value = '';
    document.getElementById('password').value = '';
    document.getElementById('userModalLabel').textContent = 'Add New User';
});
</script>

<?php include 'footer.php'; ?>