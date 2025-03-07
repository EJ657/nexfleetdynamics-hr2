<body class="">
    <?php include('header.php'); ?>
    <div class="page-content admin-cover">
        <?php include('sidebar.php'); ?>
        <div class="content-wrapper">
            <div class="content-inner">
                <div class="content">
                    <div class="row-mb-3">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h6 class="card-title">User Accounts</h6>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">Add User</button>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered text-center">
                                            <thead>
                                                <tr>
                                                    <th width="10%">#</th>
                                                    <th>Name</th>
                                                    <th>Email Address</th>
                                                    <th>User Role</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1;
                                                foreach ($accounts as $row): ?>
                                                    <tr>
                                                        <td><?= $i++ ?></td>
                                                        <td><?= $row['user_name'] ?></td>
                                                        <td><?= $row['user_username'] ?></td>
                                                        <td><?= $row['user_role'] ?></td>
                                                        <td>
                                                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editUserModal<?= $row['user_id'] ?>">Edit</button>
                                                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteUserModal<?= $row['user_id'] ?>">Delete</button>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
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
    </div>
    <?php foreach ($accounts as $row): ?>
        <!-- Edit User Modal -->
        <div class="modal fade" id="editUserModal<?= $row['user_id'] ?>" tabindex="-1" aria-labelledby="editUserModalLabel<?= $row['user_id'] ?>" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="/super_admin/accounts/edit/<?= $row['user_id'] ?>" method="POST">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editUserModalLabel<?= $row['user_id'] ?>">Edit User</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <input type="hidden" name="user_role" value="<?= $row['user_role'] ?>" required>
                                <label for="edit_user_username<?= $row['user_id'] ?>" class="form-label">Username</label>
                                <input type="email" class="form-control" id="edit_user_username<?= $row['user_id'] ?>" name="user_username" value="<?= $row['user_username'] ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_user_password<?= $row['user_id'] ?>" class="form-label">Password (leave blank if you don't want to change)</label>
                                <input type="password" class="form-control" id="edit_user_password<?= $row['user_id'] ?>" name="user_password">
                            </div>
                            <div class="mb-3" id="edit_admin_name_div<?= $row['user_id'] ?>" style="display: <?= $row['user_role'] == 'admin' ? 'block' : 'none' ?>;">
                                <label for="edit_admin_name<?= $row['user_id'] ?>" class="form-label">Admin Name</label>
                                <input type="text" class="form-control" id="edit_admin_name<?= $row['user_id'] ?>" name="admin_name" value="<?= $row['admin_name'] ?>">
                            </div>
                            <div class="mb-3" id="edit_supervisor_name_div<?= $row['user_id'] ?>" style="display: <?= $row['user_role'] == 'supervisor' ? 'block' : 'none' ?>;">
                                <label for="edit_supervisor_name<?= $row['user_id'] ?>" class="form-label">Supervisor Name</label>
                                <input type="text" class="form-control" id="edit_supervisor_name<?= $row['user_id'] ?>" name="supervisor_name" value="<?= $row['supervisor_name'] ?>">
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Delete User Modal -->
        <div class="modal fade" id="deleteUserModal<?= $row['user_id'] ?>" tabindex="-1" aria-labelledby="deleteUserModalLabel<?= $row['user_id'] ?>" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteUserModalLabel<?= $row['user_id'] ?>">Delete User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this user?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <a href="/super_admin/accounts/delete/<?= $row['user_id'] ?>" class="btn btn-danger">Delete</a>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="/super_admin/accounts/create" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addUserModalLabel">Add User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="user_username" class="form-label">Username</label>
                            <input type="email" class="form-control" id="user_username" name="user_username" required>
                        </div>
                        <div class="mb-3">
                            <label for="user_password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="user_password" name="user_password" required>
                        </div>
                        <div class="mb-3">
                            <label for="user_role" class="form-label">User Role</label>
                            <select class="form-select" id="user_role" name="user_role" required>
                                <option value="" selected>Select User Role</option>
                                <option value="admin">Admin</option>
                                <option value="supervisor">Supervisor</option>
                                <option value="employee" disabled>Employee -- create at Competency Management</option>
                            </select>
                        </div>
                        <div class="mb-3" id="admin_name_div" style="display: none;">
                            <label for="admin_name" class="form-label">Admin Name</label>
                            <input type="text" class="form-control" id="admin_name" name="admin_name">
                        </div>
                        <div class="mb-3" id="supervisor_name_div" style="display: none;">
                            <label for="supervisor_name" class="form-label">Supervisor Name</label>
                            <input type="text" class="form-control" id="supervisor_name" name="supervisor_name">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        let table = $(".table").DataTable({
            ordering: false
        });

        $('#user_role').on('change', function() {
            var role = $(this).val();
            $('#admin_name_div').toggle(role === 'admin');
            $('#supervisor_name_div').toggle(role === 'supervisor');
        });

        <?php if (isset($_SESSION['message'])): ?>
            swalInit.fire({
                title: '<?= $_SESSION['message'] ?>',
                timer: 1500,
                showConfirmButton: false
            });
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>
    </script>
</body>

</html>