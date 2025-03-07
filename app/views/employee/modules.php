<body class="">
    <?php include('header.php'); ?>
    <div class="page-content admin-cover">
        <?php include('sidebar.php'); ?>
        <div class="content-wrapper">
            <div class="content-inner">
                <div class="content">
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0">Module Management</h5>
                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addModuleModal"><i class="ph-plus me-2"></i> Add Module</button>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Module Name</th>
                                                    <th>Description</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($modules as $module) : ?>
                                                    <tr>
                                                        <td><?= $module['module_name'] ?></td>
                                                        <td><?= $module['module_description'] ?></td>
                                                        <td><?= $module['is_active'] == 1 ? 'Open' : 'Closed' ?></td>
                                                        <td>
                                                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModuleModal<?= $module['module_id'] ?>">Edit</button>
                                                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModuleModal<?= $module['module_id'] ?>">Delete</button>
                                                            <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#viewModuleTasks<?= $module['module_id'] ?>">View Tasks</button>
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
    <?php foreach ($modules as $module) : ?>
        <div class="modal fade" id="editModuleModal<?= $module['module_id'] ?>" tabindex="-1" aria-labelledby="editModuleModalLabel<?= $module['module_id'] ?>" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModuleModalLabel<?= $module['module_id'] ?>">Edit Module</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="/supervisor/modules/edit/<?= $module['module_id'] ?>" method="POST">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="module_name_<?= $module['module_id'] ?>" class="form-label">Module Name</label>
                                <input type="text" class="form-control" id="module_name_<?= $module['module_id'] ?>" name="module_name" value="<?= $module['module_name'] ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="module_description_<?= $module['module_id'] ?>" class="form-label">Module Description</label>
                                <textarea class="form-control" id="module_description_<?= $module['module_id'] ?>" name="module_description" required><?= $module['module_description'] ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="module_status_<?= $module['module_id'] ?>" class="form-label">Module Status</label>
                                <select class="form-select" id="is_active_<?= $module['module_id'] ?>" name="is_active" required>
                                    <option value="1" <?= $module['is_active'] == 1 ? 'selected' : '' ?>>Open</option>
                                    <option value="0" <?= $module['is_active'] == 0 ? 'selected' : '' ?>>Closed</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="deleteModuleModal<?= $module['module_id'] ?>" tabindex="-1" aria-labelledby="deleteModuleModalLabel<?= $module['module_id'] ?>" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModuleModalLabel<?= $module['module_id'] ?>">Delete Module</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="/supervisor/modules/delete/<?= $module['module_id'] ?>" method="POST">
                        <div class="modal-body">
                            <p>Are you sure you want to delete the module "<?= $module['module_name'] ?>"?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="viewModuleTasks<?= $module['module_id'] ?>" tabindex="-1" aria-labelledby="viewModuleTasksLabel<?= $module['module_id'] ?>" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewModuleTasksLabel<?= $module['module_id'] ?>">Module Tasks</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Task Name</th>
                                        <th>Description</th>
                                        <th>Expiration Date</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($moduleModel->getAllTasks($module['module_id']) as $task) : ?>
                                        <tr>
                                            <td><?= $task['task_name'] ?></td>
                                            <td><?= $task['task_description'] ?></td>
                                            <td><?= $task['task_expiration_date'] ?></td>
                                            <td><?= $task['is_active'] == 1 ? 'Active' : 'Inactive' ?></td>
                                            <td>
                                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editTaskModal<?= $task['task_id'] ?>">Edit</button>
                                                <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteTaskModal<?= $task['task_id'] ?>">Delete</button>
                                                <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#viewQuestionsModal<?= $task['task_id'] ?>">View Questions</button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addTaskModal<?= $module['module_id'] ?>"><i class="ph-plus me-2"></i> Add Task</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="addTaskModal<?= $module['module_id'] ?>" tabindex="-1" aria-labelledby="addTaskModalLabel<?= $module['module_id'] ?>" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addTaskModalLabel<?= $module['module_id'] ?>">Add Task</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="/supervisor/modules/<?= $module['module_id'] ?>/tasks/create" method="POST">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="task_name_<?= $module['module_id'] ?>" class="form-label">Task Name</label>
                                <input type="text" class="form-control" id="task_name_<?= $module['module_id'] ?>" name="task_name" required>
                            </div>
                            <div class="mb-3">
                                <label for="task_description_<?= $module['module_id'] ?>" class="form-label">Task Description</label>
                                <textarea class="form-control" id="task_description_<?= $module['module_id'] ?>" name="task_description" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="task_expiration_date_<?= $module['module_id'] ?>" class="form-label">Task Expiration Date</label>
                                <input type="date" class="form-control" id="task_expiration_date_<?= $module['module_id'] ?>" name="task_expiration_date" required>
                            </div>
                            <div class="mb-3">
                                <label for="task_status_<?= $module['module_id'] ?>" class="form-label">Task Status</label>
                                <select class="form-select" id="task_status_<?= $module['module_id'] ?>" name="is_active" required>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save Task</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <?php foreach ($moduleModel->getAllTasks($module['module_id']) as $task) : ?>
            <div class="modal fade" id="editTaskModal<?= $task['task_id'] ?>" tabindex="-1" aria-labelledby="editTaskModalLabel<?= $task['task_id'] ?>" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editTaskModalLabel<?= $task['task_id'] ?>">Edit Task</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="/supervisor/tasks/edit/<?= $task['task_id'] ?>" method="POST">
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="task_name_<?= $task['task_id'] ?>" class="form-label">Task Name</label>
                                    <input type="text" class="form-control" id="task_name_<?= $task['task_id'] ?>" name="task_name" value="<?= $task['task_name'] ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="task_description_<?= $task['task_id'] ?>" class="form-label">Task Description</label>
                                    <textarea class="form-control" id="task_description_<?= $task['task_id'] ?>" name="task_description" required><?= $task['task_description'] ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="task_expiration_date_<?= $task['task_id'] ?>" class="form-label">Task Expiration Date</label>
                                    <input type="date" class="form-control" id="task_expiration_date_<?= $task['task_id'] ?>" name="task_expiration_date" value="<?= $task['task_expiration_date'] ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="task_status_<?= $task['task_id'] ?>" class="form-label">Task Status</label>
                                    <select class="form-select" id="task_status_<?= $task['task_id'] ?>" name="is_active" required>
                                        <option value="1" <?= $task['is_active'] == 1 ? 'selected' : '' ?>>Active</option>
                                        <option value="0" <?= $task['is_active'] == 0 ? 'selected' : '' ?>>Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="deleteTaskModal<?= $task['task_id'] ?>" tabindex="-1" aria-labelledby="deleteTaskModalLabel<?= $task['task_id'] ?>" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteTaskModalLabel<?= $task['task_id'] ?>">Delete Task</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="/supervisor/tasks/delete/<?= $task['task_id'] ?>" method="POST">
                            <div class="modal-body">
                                <p>Are you sure you want to delete the task "<?= $task['task_name'] ?>"?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="viewQuestionsModal<?= $task['task_id'] ?>" tabindex="-1" aria-labelledby="viewQuestionsModalLabel<?= $task['task_id'] ?>" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="viewQuestionsModalLabel<?= $task['task_id'] ?>">Task Questions</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Question Text</th>
                                            <th>Answer</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($moduleModel->getAllQuestions($task['task_id']) as $question) : ?>
                                            <tr>
                                                <td><?= $question['question_text'] ?></td>
                                                <td><?= $question['question_answer'] ?></td>
                                                <td>
                                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editQuestionModal<?= $question['question_id'] ?>">Edit</button>
                                                    <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteQuestionModal<?= $question['question_id'] ?>">Delete</button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addQuestionModal<?= $task['task_id'] ?>"><i class="ph-plus me-2"></i> Add Question</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="addQuestionModal<?= $task['task_id'] ?>" tabindex="-1" aria-labelledby="addQuestionModalLabel<?= $task['task_id'] ?>" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addQuestionModalLabel<?= $task['task_id'] ?>">Add Question</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="/supervisor/tasks/<?= $task['task_id'] ?>/questions/create" method="POST">
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="question_text_<?= $task['task_id'] ?>" class="form-label">Question Text</label>
                                    <textarea class="form-control" id="question_text_<?= $task['task_id'] ?>" name="question_text" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="question_data_<?= $task['task_id'] ?>" class="form-label">Question Choices</label>
                                    <input type="text" class="form-control mb-2" id="question_data_<?= $task['task_id'] ?>_a" name="question_data[]" placeholder="Choice A" required>
                                    <input type="text" class="form-control mb-2" id="question_data_<?= $task['task_id'] ?>_b" name="question_data[]" placeholder="Choice B" required>
                                    <input type="text" class="form-control mb-2" id="question_data_<?= $task['task_id'] ?>_c" name="question_data[]" placeholder="Choice C" required>
                                    <input type="text" class="form-control mb-2" id="question_data_<?= $task['task_id'] ?>_d" name="question_data[]" placeholder="Choice D" required>
                                </div>
                                <div class="mb-3">
                                    <label for="question_answer_<?= $task['task_id'] ?>" class="form-label">Correct Answer</label>
                                    <select class="form-select" id="question_answer_<?= $task['task_id'] ?>" name="question_answer" required>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>
                                        <option value="D">D</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save Question</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="editQuestionModal<?= $question['question_id'] ?>" tabindex="-1" aria-labelledby="editQuestionModalLabel<?= $question['question_id'] ?>" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editQuestionModalLabel<?= $question['question_id'] ?>">Edit Question</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="/supervisor/questions/edit/<?= $question['question_id'] ?>" method="POST">
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="question_text_<?= $question['question_id'] ?>" class="form-label">Question Text</label>
                                    <textarea class="form-control" id="question_text_<?= $question['question_id'] ?>" name="question_text" required><?= $question['question_text'] ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="question_data_<?= $question['question_id'] ?>" class="form-label">Question Choices</label>
                                    <?php $choices = json_decode($question['question_data'], true); ?>
                                    <input type="text" class="form-control mb-2" id="question_data_<?= $question['question_id'] ?>_a" name="question_data[]" value="<?= $choices[0] ?>" required>
                                    <input type="text" class="form-control mb-2" id="question_data_<?= $question['question_id'] ?>_b" name="question_data[]" value="<?= $choices[1] ?>" required>
                                    <input type="text" class="form-control mb-2" id="question_data_<?= $question['question_id'] ?>_c" name="question_data[]" value="<?= $choices[2] ?>" required>
                                    <input type="text" class="form-control mb-2" id="question_data_<?= $question['question_id'] ?>_d" name="question_data[]" value="<?= $choices[3] ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="question_answer_<?= $question['question_id'] ?>" class="form-label">Correct Answer</label>
                                    <select class="form-select" id="question_answer_<?= $question['question_id'] ?>" name="question_answer" required>
                                        <option value="A" <?= $question['question_answer'] == 'A' ? 'selected' : '' ?>>A</option>
                                        <option value="B" <?= $question['question_answer'] == 'B' ? 'selected' : '' ?>>B</option>
                                        <option value="C" <?= $question['question_answer'] == 'C' ? 'selected' : '' ?>>C</option>
                                        <option value="D" <?= $question['question_answer'] == 'D' ? 'selected' : '' ?>>D</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="deleteQuestionModal<?= $question['question_id'] ?>" tabindex="-1" aria-labelledby="deleteQuestionModalLabel<?= $question['question_id'] ?>" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteQuestionModalLabel<?= $question['question_id'] ?>">Delete Question</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="/supervisor/questions/delete/<?= $question['question_id'] ?>" method="POST">
                            <div class="modal-body">
                                <p>Are you sure you want to delete the question "<?= $question['question_text'] ?>"?</p>
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
    <?php endforeach; ?>
    <div class="modal fade" id="addModuleModal" tabindex="-1" aria-labelledby="addModuleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModuleModalLabel">Add Module</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/supervisor/modules/create" method="POST">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="module_name" class="form-label">Module Name</label>
                            <input type="text" class="form-control" id="module_name" name="module_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="module_description" class="form-label">Module Description</label>
                            <textarea class="form-control" id="module_description" name="module_description" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="module_status" class="form-label">Module Status</label>
                            <select class="form-select" id="is_active" name="is_active" required>
                                <option value="1">Open</option>
                                <option value="0">Closed</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Module</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        let table = $(".table").DataTable({
            ordering: false
        })

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