<?php
session_start();

class EmployeeController
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

        if ($this->role !== 'employee') {
            header("Location: /logout");
        }
    }

    public function index()
    {
        $data = [
            "modules" => $this->moduleModel->getAllModules(),
            "moduleModel" => $this->moduleModel,
            "progressModel" => $this->progressModel
        ];

        loadView("head");
        loadView("$this->role/home", $data);
    }

    public function activateModule($module_id)
    {
        if ($this->requestMethod === 'POST') {
            $data = [
                'employee_id' => $_SESSION['employee_id'],
                'module_id' => $module_id
            ];

            $this->progressModel->create($data);

            echo json_encode(['status' => 'success', 'message' => 'Module activated successfully']);
        }
    }

    public function messages()
    {
        $data = [
            "contacts" => $this->messageModel->getContacts()
        ];

        loadView("head");
        loadView("$this->role/messages", $data);
    }

    public function about()
    {
        loadView("head");
        loadView("$this->role/about");
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
