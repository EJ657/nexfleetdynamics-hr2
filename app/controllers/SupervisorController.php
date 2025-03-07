<?php
session_start();

class SupervisorController
{
    private $requestMethod, $role, $userModel, $forgotRequestsModel, $adminModel, $supervisorModel, $employeeModel, $messageModel, $moduleModel, $progressModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->forgotRequestsModel = new ForgotRequestsModel();
        $this->adminModel = new AdminModel();
        $this->supervisorModel = new SupervisorModel();
        $this->employeeModel = new EmployeeModel();
        $this->messageModel = new MessagesModel();
        $this->moduleModel = new ModuleModel();
        $this->progressModel = new ProgressModel();
        $this->requestMethod = $_SERVER['REQUEST_METHOD'];
        $this->role = $_SESSION['user_role'];

        if ($this->role !== 'supervisor') {
            header("Location: /logout");
        }
    }

    public function index()
    {
        $data = [
            "dashboard" => $this->progressModel->getAll(),
            "activeParticipantsCount" => $this->progressModel->getEmployeeProgressCount()['total'] ?? 0,
            "activeLearningModulesCount" => $this->moduleModel->getTotalActiveModule()['total'] ?? 0,
            "activeLearningTasksCount" => $this->moduleModel->getTotalActiveModuleTasks()['total'] ?? 0,
            "completedParticipantsCount" => $this->progressModel->getEmployeeCompletedCount()['total'] ?? 0,
            "missingModuleTasks" => $this->progressModel->getTotalMissingModuleTasks()['total'] ?? 0
        ];

        loadView("head");
        loadView("$this->role/home", $data);
    }

    public function modules()
    {
        $data = [
            "modules" => $this->moduleModel->getAllModules(),
            "moduleModel" => $this->moduleModel
        ];

        loadView("head");
        loadView("$this->role/modules", $data);
    }

    public function createModule()
    {
        if ($this->requestMethod === 'POST') {

            $data = file_get_contents('php://input');
            $postData = json_decode($data, true);

            $content = $postData['content'];
            $sanitizedContent = htmlspecialchars($content, ENT_QUOTES, 'UTF-8');

            $postData['module_content'] = $sanitizedContent;

            $this->moduleModel->create($postData);

            echo json_encode(['status' => 'success', 'message' => 'Data saved successfully']);
        }
    }

    public function editModule()
    {
        if ($this->requestMethod === 'POST') {

            $data = file_get_contents('php://input');
            $postData = json_decode($data, true);

            $moduleId = $postData['moduleId']; // Get the module ID
            $content = $postData['content']; // Get the CKEditor content

            $sanitizedContent = htmlspecialchars($content, ENT_QUOTES, 'UTF-8');

            $postData['module_id'] = $moduleId;
            $postData['module_content'] = $sanitizedContent;

            $this->moduleModel->edit($postData);

            echo json_encode(['status' => 'success', 'message' => 'Data saved successfully']);
        }
    }

    public function deleteModule($module_id)
    {
        $this->moduleModel->delete($module_id);

        $_SESSION['message'] = "Module deleted successfully";
        header("Location: /supervisor/modules");
    }

    public function createTask($module_id)
    {
        if ($this->requestMethod === 'POST') {

            $this->moduleModel->createTask($module_id, $_POST);

            $_SESSION['message'] = "Task created successfully";
            header("Location: /supervisor/modules");
        }
    }

    public function editTask($task_id)
    {
        if ($this->requestMethod === 'POST') {

            $module_id = $_POST['module_id'];
            $this->moduleModel->editTask($module_id, $task_id, $_POST);

            $_SESSION['message'] = "Task updated successfully";
            header("Location: /supervisor/modules");
        }
    }

    public function deleteTask($task_id)
    {
        $this->moduleModel->deleteTask($task_id);

        $_SESSION['message'] = "Task deleted successfully";
        header("Location: /supervisor/modules");
    }

    public function createQuestion($task_id)
    {
        if ($this->requestMethod === 'POST') {

            $_POST['question_data'] = json_encode($_POST['question_data']);
            $questionData = json_decode($_POST['question_data'], true);
            $formattedData = [];
            $choices = ['A', 'B', 'C', 'D'];

            foreach ($questionData as $index => $choice) {
                $formattedData[$choices[$index]] = $choice;
            }

            $_POST['question_data'] = json_encode($formattedData);
            $this->moduleModel->createQuestion($task_id, $_POST);

            $_SESSION['message'] = "Question created successfully";
            header("Location: /supervisor/modules");
        }
    }

    public function editQuestion($question_id)
    {
        if ($this->requestMethod === 'POST') {

            $_POST['question_data'] = json_encode($_POST['question_data']);
            $questionData = json_decode($_POST['question_data'], true);
            $formattedData = [];
            $choices = ['A', 'B', 'C', 'D'];

            foreach ($questionData as $index => $choice) {
                $formattedData[$choices[$index]] = $choice;
            }

            $_POST['question_data'] = json_encode($formattedData);
            $this->moduleModel->editQuestion($question_id, $_POST);

            $_SESSION['message'] = "Question updated successfully";
            header("Location: /supervisor/modules");
        }
    }

    public function deleteQuestion($question_id)
    {
        $this->moduleModel->deleteQuestion($question_id);

        $_SESSION['message'] = "Question deleted successfully";
        header("Location: /supervisor/modules");
    }

    public function messages()
    {
        $data = [
            "contacts" => $this->messageModel->getContacts()
        ];

        loadView("head");
        loadView("$this->role/messages", $data);
    }

    // public function updateProfile()
    // {
    //     if ($this->requestMethod == 'POST') {
    //         $userData = [
    //             'user_id' => $_SESSION['user_id'],
    //             'user_username' => $_POST['user_username'],
    //             'user_password' => $_POST['user_password']
    //         ];

    //         $this->userModel->edit($userData);

    //         $adminData = [
    //             'admin_name' => $_POST['admin_name'],
    //             'user_id' => $_SESSION['user_id']
    //         ];

    //         $this->adminModel->edit($adminData);

    //         $data = $this->adminModel->getByUserId($_SESSION['user_id']);
    //         foreach ($data as $key => $value) {
    //             if ($key !== 'user_id') {
    //                 $_SESSION[$key] = $value;
    //             }
    //         }

    //         $user = $this->userModel->get($_SESSION['user_id']);
    //         foreach ($user as $key => $value) {
    //             if ($key !== 'user_password') {
    //                 $_SESSION[$key] = $value;
    //             }
    //         }

    //         echo json_encode(["success" => "true", "message" => "Profile updated successfully"]);
    //         // header("Location: " . $_SERVER['HTTP_REFERER']);
    //     }
    // }
}
