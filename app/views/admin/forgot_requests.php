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
                                <div class="card-header">
                                    <h6 class="card-title">Forgot Password Requests</h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered text-center">
                                            <thead>
                                                <tr>
                                                    <th width="10%">#</th>
                                                    <th>Email</th>
                                                    <th>Reason</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1;
                                                foreach ($requests as $row): ?>
                                                    <tr>
                                                        <td><?= $i++ ?></td>
                                                        <td><?= $row['user_username'] ?></td>
                                                        <td><?= $row['forgot_reason'] ?></td>
                                                        <td>
                                                            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#approveModal<?= $row['user_id'] ?>">Approve</button>
                                                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#rejectModal<?= $row['user_id'] ?>">Reject</button>
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
    <?php foreach ($requests as $row): ?>
        <!-- Approve Modal -->
        <div class="modal fade" id="approveModal<?= $row['user_id'] ?>" tabindex="-1" aria-labelledby="approveModalLabel<?= $row['user_id'] ?>" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="/admin/forgot_requests/approve/<?= $row['user_id'] ?>" method="POST">
                        <div class="modal-header">
                            <h5 class="modal-title" id="approveModalLabel<?= $row['user_id'] ?>">Approve Request</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3 fw-bold">
                                Are you sure you want to approve this request?
                            </div>
                            <div class="mb-3">
                                <label for="user_password" class="form-label">New Password</label>
                                <input type="password" class="form-control" id="user_password" name="user_password" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Approve</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Reject Modal -->
        <div class="modal fade" id="rejectModal<?= $row['user_id'] ?>" tabindex="-1" aria-labelledby="rejectModalLabel<?= $row['user_id'] ?>" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="/admin/forgot_requests/reject/<?= $row['user_id'] ?>" method="POST">
                        <div class="modal-header">
                            <h5 class="modal-title" id="rejectModalLabel<?= $row['user_id'] ?>">Reject Request</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to reject this request?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger">Reject</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <script>
        let table = $(".table").DataTable({
            ordering: false
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