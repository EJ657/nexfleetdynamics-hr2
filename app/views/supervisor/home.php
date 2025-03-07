<body class="">
    <?php include('header.php'); ?>
    <div class="page-content admin-cover">
        <?php include('sidebar.php'); ?>
        <div class="content-wrapper">
            <div class="content-inner">
                <div class="content">
                    <div class="row justify-content-center d-flex align-items-center mb-3">
                        <div class="col-12 col-lg-2 mb-lg-0 mb-3">
                            <div class="card border-start border-start-primary">
                                <div class="card-body">
                                    <div class="row align-items-center no-gutters">
                                        <div class="col me-lg-2 mb-0">
                                            <div class="text-uppercase fw-bold mb-1"><span class="h6">Total Learning Module Active</span></div>
                                            <div class="text-dark fw-bold mb-0"><span><?= $activeLearningModulesCount ?></span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-2 mb-lg-0 mb-3">
                            <div class="card border-start border-start-primary">
                                <div class="card-body">
                                    <div class="row align-items-center no-gutters">
                                        <div class="col me-lg-2 mb-0">
                                            <div class="text-uppercase fw-bold mb-1"><span class="h6">Total Participants Active</span></div>
                                            <div class="text-dark fw-bold mb-0"><span><?= $activeParticipantsCount ?></span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-2 mb-lg-0 mb-3">
                            <div class="card border-start border-start-primary">
                                <div class="card-body">
                                    <div class="row align-items-center no-gutters">
                                        <div class="col me-lg-2 mb-0">
                                            <div class="text-uppercase fw-bold mb-1"><span class="h6">Total Active Module Tasks</span></div>
                                            <div class="text-dark fw-bold mb-0"><span><?= $activeLearningTasksCount ?></span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-2 mb-lg-0 mb-3">
                            <div class="card border-start border-start-primary">
                                <div class="card-body">
                                    <div class="row align-items-center no-gutters">
                                        <div class="col me-lg-2 mb-0">
                                            <div class="text-uppercase fw-bold mb-1"><span class="h6">Total Missing Module Tasks</span></div>
                                            <div class="text-dark fw-bold mb-0"><span><?= $missingModuleTasks ?></span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-2 mb-lg-0 mb-3">
                            <div class="card border-start border-start-primary">
                                <div class="card-body">
                                    <div class="row align-items-center no-gutters">
                                        <div class="col me-lg-2 mb-0">
                                            <div class="text-uppercase fw-bold mb-1"><span class="h6">Total Completed Module Tasks</span></div>
                                            <div class="text-dark fw-bold mb-0"><span><?= $completedParticipantsCount ?></span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row-mb-3">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Training Module</th>
                                                    <th>Employees Undergoing</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach($dashboard as $row): ?>
                                                    <tr>
                                                        <td><?=$row['module_name']?></td>
                                                        <td><?=$row['employee_name']?></td>
                                                        <td><?=$row['progress_status']?></td>
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