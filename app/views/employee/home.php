<body class="">
    <?php include('header.php'); ?>
    <div class="page-content admin-cover">
        <?php include('sidebar.php'); ?>
        <div class="content-wrapper">
            <div class="content-inner">
                <div class="content">
                    <div class="row row-cols-1 row-cols-lg-4 mb-3">
                        <?php foreach ($modules as $module): ?>
                            <div class="col">
                                <div class="card my-color text-white">
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <div class="col-12">
                                                <h4><?= $module['module_name'] ?></h4>
                                                <p><?= $module['module_description'] ?></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-lg-6">
                                                <?php $progress = $progressModel->getByEmployeeId($_SESSION['employee_id'], $module['module_id']); ?>
                                                <?php if (isset($progress['progress_status']) && ($progress['progress_status'] == 'In Progress' || $progress['progress_status'] == 'Missing')): ?>
                                                    <button type="button" class="btn btn-sm btn-light d-flex align-items-center justify-content-center" data-bs-toggle="modal" data-bs-target="#viewModule<?= $module['module_id'] ?>">Continue<i class="ph-arrow-right ms-2"></i></button>
                                                <?php elseif (isset($progress['progress_status']) && $progress['progress_status'] == 'Completed'): ?>
                                                    <span class="text-white">Completed</span>
                                                <?php else: ?>
                                                    <button type="button" class="btn btn-sm btn-light d-flex align-items-center justify-content-center" data-bs-toggle="modal" data-bs-target="#viewModule<?= $module['module_id'] ?>">View Details<i class="ph-arrow-right ms-2"></i></button>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php foreach ($modules as $module): ?>
        <div class="modal fade" id="viewModule<?= $module['module_id'] ?>" tabindex="-1" aria-labelledby="viewModuleLabel<?= $module['module_id'] ?>" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewModuleLabel<?= $module['module_id'] ?>"><?= $module['module_name'] ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <?php $progress = $progressModel->getByEmployeeId($_SESSION['employee_id'], $module['module_id']); ?>
                        <?php if (isset($progress['progress_status']) && ($progress['progress_status'] == 'In Progress' || $progress['progress_status'] == 'Missing')): ?>
                            <div class="accordion" id="moduleContentAccordion<?= $module['module_id'] ?>">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingContent<?= $module['module_id'] ?>">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseContent<?= $module['module_id'] ?>" aria-expanded="false" aria-controls="collapseContent<?= $module['module_id'] ?>">
                                            Module Content
                                        </button>
                                    </h2>
                                    <div id="collapseContent<?= $module['module_id'] ?>" class="accordion-collapse collapse" aria-labelledby="headingContent<?= $module['module_id'] ?>" data-bs-parent="#moduleContentAccordion<?= $module['module_id'] ?>">
                                        <div class="accordion-body">
                                            <p>
                                                <?= html_entity_decode($module['module_content']) ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <h5>Tasks</h5>
                            <?php foreach ($moduleModel->getAllTasks($module['module_id']) as $task): ?>
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <?php if (strtotime($task['task_expiration_date']) < time()): ?>
                                            <span class="badge bg-danger">Missed</span>
                                        <?php else: ?>
                                            <div class="accordion" id="taskAccordion<?= $task['task_id'] ?>">
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="heading<?= $task['task_id'] ?>">
                                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $task['task_id'] ?>" aria-expanded="false" aria-controls="collapse<?= $task['task_id'] ?>">
                                                            <div>
                                                                <?= $task['task_name'] ?><br>
                                                                <small><?= $task['task_description'] ?></small><br>
                                                                <b>Deadline: <?= $task['task_expiration_date'] ?></b>
                                                            </div>
                                                        </button>
                                                    </h2>
                                                    <div id="collapse<?= $task['task_id'] ?>" class="accordion-collapse collapse" aria-labelledby="heading<?= $task['task_id'] ?>" data-bs-parent="#taskAccordion<?= $task['task_id'] ?>">
                                                        <div class="accordion-body">
                                                            <form action="/employee/tasks/submit/<?= $task['task_id'] ?>" method="POST">
                                                                <?php foreach ($moduleModel->getAllQuestions($task['task_id']) as $question): ?>
                                                                    <div class="mb-3">
                                                                        <label><?= $question['question_text'] ?></label>
                                                                        <?php foreach (json_decode($question['question_data'], true) as $key => $choice): ?>
                                                                            <div class="form-check">
                                                                                <input class="form-check-input" type="radio" name="question_<?= $question['question_id'] ?>" value="<?= $key ?>">
                                                                                <label class="form-check-label"><?= $choice ?></label>
                                                                            </div>
                                                                        <?php endforeach; ?>
                                                                    </div>
                                                                <?php endforeach; ?>
                                                                <button type="submit" class="btn btn-primary btn-sm">Submit Task</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php elseif (isset($progress['progress_status']) && $progress['progress_status'] == 'Completed'): ?>
                            <span class="text-white">Completed</span>
                        <?php else: ?>
                            <p>
                                <?= html_entity_decode($module['module_content']) ?>
                            </p>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="readModule<?= $module['module_id'] ?>" onchange="takeModule(<?= $module['module_id'] ?>)">
                                <label class="form-check-label" for="readModule<?= $module['module_id'] ?>">
                                    I have read this module and I want to answer the tasks
                                </label>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <script>
        <?php if (isset($_SESSION['message'])): ?>
            swalInit.fire({
                title: '<?= $_SESSION['message'] ?>',
                timer: 1500,
                showConfirmButton: false
            });
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>

        function takeModule(moduleId) {
            swalInit.fire({
                title: 'Are you ready to answer the tasks?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, I\'ll do it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/employee/modules/activate/' + moduleId,
                        type: 'POST',
                        success: function(response) {
                            swalInit.fire(
                                'Activated!',
                                'The module has been activated.',
                                'success'
                            ).then(() => {
                                location.reload();
                            });
                        },
                        error: function(xhr, status, error) {
                            swalInit.fire(
                                'Error!',
                                'There was an error activating the module.',
                                'error'
                            );
                        }
                    });
                } else {
                    $("#readModule" + moduleId).prop('checked', false);
                }
            });
        }
    </script>
</body>

</html>