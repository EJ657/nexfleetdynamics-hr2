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
                                    <h5 class="card-title">Competency Management</h5>
                                    <div>
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEmployeeModal">Add Employee</button>
                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#importEmployeeModal">Import from CSV</button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12 col-lg-3">
                                            <div class="input-group d-flex align-items-center">
                                                <label class="me-2">Filter by Status: </label>
                                                <select id="statusFilter" class="form-select">
                                                    <option value="">All</option>
                                                    <option value="1">Active</option>
                                                    <option value="0">Inactive</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered text-center">
                                            <thead>
                                                <tr>
                                                    <th width="10%">#</th>
                                                    <th>Employee Name</th>
                                                    <th>Email</th>
                                                    <th>Hire Date</th>
                                                    <th>Job Position</th>
                                                    <th>Department</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1;
                                                foreach ($employees as $row): ?>
                                                    <tr>
                                                        <td><?= $i++ ?></td>
                                                        <td><?= $row['employee_name'] ?></td>
                                                        <td><?= $row['user_username'] ?></td>
                                                        <td><?= $row['employee_hire_date'] ?></td>
                                                        <td><?= $row['employee_position'] ?></td>
                                                        <td><?= $row['employee_department'] ?></td>
                                                        <td><?= ($row['is_active'] == 0) ? 'Inactive' : 'Active' ?></td>
                                                        <td>
                                                            <button type="button" class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#viewEmployeeModal<?= $row['user_id'] ?>">View</button>
                                                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editEmployeeModal<?= $row['user_id'] ?>">Edit</button>
                                                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteEmployeeModal<?= $row['user_id'] ?>">Delete</button>
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
    <?php foreach ($employees as $row): ?>
        <div class="modal fade" id="viewEmployeeModal<?= $row['user_id'] ?>" tabindex="-1" aria-labelledby="viewEmployeeModalLabel<?= $row['user_id'] ?>" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewEmployeeModalLabel<?= $row['user_id'] ?>">View Employee</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Employee Name</label>
                            <p class="form-control-plaintext"><?= $row['employee_name'] ?></p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <p class="form-control-plaintext"><?= $row['user_username'] ?></p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Hire Date</label>
                            <p class="form-control-plaintext"><?= $row['employee_hire_date'] ?></p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Job Position</label>
                            <p class="form-control-plaintext"><?= $row['employee_position'] ?></p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Department</label>
                            <p class="form-control-plaintext"><?= $row['employee_department'] ?></p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Soft Skills</label>
                            <p class="form-control-plaintext"><?= $row['employee_soft_skills'] ?></p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Hard Skills</label>
                            <p class="form-control-plaintext"><?= $row['employee_hard_skills'] ?></p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Active Status</label>
                            <p class="form-control-plaintext"><?= ($row['is_active'] == 0) ? 'Inactive' : 'Active' ?></p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="editEmployeeModal<?= $row['user_id'] ?>" tabindex="-1" aria-labelledby="editEmployeeModalLabel<?= $row['user_id'] ?>" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="/super_admin/competency/edit/<?= $row['user_id'] ?>" method="post">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editEmployeeModalLabel<?= $row['user_id'] ?>">Edit Employee</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="employee_name<?= $row['user_id'] ?>" class="form-label">Employee Name</label>
                                <input type="text" class="form-control" id="employee_name<?= $row['user_id'] ?>" name="employee_name" value="<?= $row['employee_name'] ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="user_username<?= $row['user_id'] ?>" class="form-label">Email</label>
                                <input type="email" class="form-control" id="user_username<?= $row['user_id'] ?>" name="user_username" value="<?= $row['user_username'] ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="user_password<?= $row['user_id'] ?>" class="form-label">Password (leave blank if you don't want to change)</label>
                                <input type="password" class="form-control" id="user_password<?= $row['user_id'] ?>" name="user_password">
                            </div>
                            <div class="mb-3">
                                <label for="employee_hire_date<?= $row['user_id'] ?>" class="form-label">Hire Date</label>
                                <input type="date" class="form-control" id="employee_hire_date<?= $row['user_id'] ?>" name="employee_hire_date" value="<?= $row['employee_hire_date'] ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="employee_position<?= $row['user_id'] ?>" class="form-label">Job Position</label>
                                <input type="text" class="form-control" id="employee_position<?= $row['user_id'] ?>" name="employee_position" value="<?= $row['employee_position'] ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="employee_department<?= $row['user_id'] ?>" class="form-label">Department</label>
                                <input type="text" class="form-control" id="employee_department<?= $row['user_id'] ?>" name="employee_department" value="<?= $row['employee_department'] ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="employee_soft_skills<?= $row['user_id'] ?>" class="form-label">Soft Skills</label>
                                <textarea class="form-control" id="employee_soft_skills<?= $row['user_id'] ?>" name="employee_soft_skills" rows="3"><?= $row['employee_soft_skills'] ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="employee_hard_skills<?= $row['user_id'] ?>" class="form-label">Hard Skills</label>
                                <textarea class="form-control" id="employee_hard_skills<?= $row['user_id'] ?>" name="employee_hard_skills" rows="3"><?= $row['employee_hard_skills'] ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="is_active<?= $row['user_id'] ?>" class="form-label">Active Status</label>
                                <select class="form-select" id="is_active<?= $row['user_id'] ?>" name="is_active">
                                    <option value="1" <?= $row['is_active'] == 1 ? 'selected' : '' ?>>Active</option>
                                    <option value="0" <?= $row['is_active'] == 0 ? 'selected' : '' ?>>Inactive</option>
                                </select>
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

        <div class="modal fade" id="deleteEmployeeModal<?= $row['user_id'] ?>" tabindex="-1" aria-labelledby="deleteEmployeeModalLabel<?= $row['user_id'] ?>" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="/super_admin/competency/delete/<?= $row['user_id'] ?>" method="post">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteEmployeeModalLabel<?= $row['user_id'] ?>">Delete Employee</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to delete <?= $row['employee_name'] ?>?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <!-- Add Employee Modal -->
    <div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-labelledby="addEmployeeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="/super_admin/competency/create" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addEmployeeModalLabel">Add Employee</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="employee_name" class="form-label">Employee Name</label>
                            <input type="text" class="form-control" id="employee_name" name="employee_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="user_username" class="form-label">Email</label>
                            <input type="email" class="form-control" id="user_username" name="user_username" required>
                        </div>
                        <div class="mb-3">
                            <label for="user_password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="user_password" name="user_password" required>
                        </div>
                        <div class="mb-3">
                            <label for="employee_hire_date" class="form-label">Hire Date</label>
                            <input type="date" class="form-control" id="employee_hire_date" name="employee_hire_date" required>
                        </div>
                        <div class="mb-3">
                            <label for="employee_position" class="form-label">Job Position</label>
                            <input type="text" class="form-control" id="employee_position" name="employee_position" required>
                        </div>
                        <div class="mb-3">
                            <label for="employee_department" class="form-label">Department</label>
                            <input type="text" class="form-control" id="employee_department" name="employee_department" required>
                        </div>
                        <div class="mb-3">
                            <label for="employee_soft_skills" class="form-label">Soft Skills</label>
                            <textarea class="form-control" id="employee_soft_skills" name="employee_soft_skills" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="employee_hard_skills" class="form-label">Hard Skills</label>
                            <textarea class="form-control" id="employee_hard_skills" name="employee_hard_skills" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="is_active" class="form-label">Active Status</label>
                            <select class="form-select" id="is_active" name="is_active">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        let table = $(".table").DataTable({
            ordering: false
        });

        $('#statusFilter').on('change', function() {
            table.column(6).search(this.value).draw();
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