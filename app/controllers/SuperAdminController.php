<?php
session_start();

class SuperAdminController
{
    private $requestMethod, $role, $userModel, $forgotRequestsModel, $adminModel, $supervisorModel, $employeeModel, $messageModel, $progressModel, $moduleModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->forgotRequestsModel = new ForgotRequestsModel();
        $this->adminModel = new AdminModel();
        $this->supervisorModel = new SupervisorModel();
        $this->employeeModel = new EmployeeModel();
        $this->messageModel = new MessagesModel();
        $this->progressModel = new ProgressModel();
        $this->moduleModel = new ModuleModel();
        $this->requestMethod = $_SERVER['REQUEST_METHOD'];
        $this->role = $_SESSION['user_role'];

        if ($this->role !== 'super_admin') {
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

    public function accounts()
    {
        $data = [
            "accounts" => $this->userModel->getAllSuperAdmin()
        ];

        loadView("head");
        loadView("$this->role/accounts", $data);
    }

    public function createAccount()
    {
        if ($this->requestMethod == 'POST') {
            $userData = [
                'user_username' => $_POST['user_username'],
                'user_password' => $_POST['user_password'],
                'user_role' => $_POST['user_role']
            ];

            $userId = $this->userModel->create($userData);

            if ($userData['user_role'] == 'admin') {
                $adminData = [
                    'user_id' => $userId,
                    'admin_name' => $_POST['admin_name']
                ];
                $this->adminModel->create($adminData);
            } elseif ($userData['user_role'] == 'supervisor') {
                $supervisorData = [
                    'user_id' => $userId,
                    'supervisor_name' => $_POST['supervisor_name']
                ];
                $this->supervisorModel->create($supervisorData);
            }

            $_SESSION['message'] = "User account created successfully";
            header("Location: /super_admin/accounts");
        }
    }

    public function editAccount($user_id)
    {
        if ($this->requestMethod == 'POST') {
            $userData = [
                'user_id' => $user_id,
                'user_username' => $_POST['user_username'],
                'user_password' => $_POST['user_password']
            ];

            $this->userModel->edit($userData);

            if ($_POST['user_role'] == 'admin') {
                $adminData = [
                    'user_id' => $user_id,
                    'admin_name' => $_POST['admin_name']
                ];
                $this->adminModel->edit($adminData);
            } elseif ($_POST['user_role'] == 'supervisor') {
                $supervisorData = [
                    'user_id' => $user_id,
                    'supervisor_name' => $_POST['supervisor_name']
                ];
                $this->supervisorModel->edit($supervisorData);
            }

            $_SESSION['message'] = "User account updated successfully";
            header("Location: /super_admin/accounts");
        }
    }

    public function deleteAccount($user_id)
    {
        $this->userModel->delete($user_id);
        $_SESSION['message'] = "User account deleted successfully";
        header("Location: /super_admin/accounts");
    }

    public function competency()
    {
        $data = [
            "employees" => $this->employeeModel->getAll()
        ];

        loadView("head");
        loadView("$this->role/competency", $data);
    }

    public function createEmployee()
    {
        if ($this->requestMethod == 'POST') {
            $userData = [
                'user_username' => $_POST['user_username'],
                'user_password' => $_POST['user_password'],
                'user_role' => 'employee'
            ];

            $userId = $this->userModel->create($userData);

            $employeeData = [
                'user_id' => $userId,
                'employee_name' => $_POST['employee_name'],
                'employee_hire_date' => $_POST['employee_hire_date'],
                'employee_position' => $_POST['employee_position'],
                'employee_department' => $_POST['employee_department'],
                'employee_soft_skills' => $_POST['employee_soft_skills'],
                'employee_hard_skills' => $_POST['employee_hard_skills'],
                'is_active' => $_POST['is_active']
            ];

            $this->employeeModel->create($employeeData);

            $_SESSION['message'] = "Employee created successfully";
            header("Location: /super_admin/competency");
        }
    }

    public function editEmployee($user_id)
    {
        if ($this->requestMethod == 'POST') {
            $userData = [
                'user_id' => $user_id,
                'user_username' => $_POST['user_username'],
                'user_password' => $_POST['user_password']
            ];

            $this->userModel->edit($userData);

            $employeeData = [
                'user_id' => $user_id,
                'employee_name' => $_POST['employee_name'],
                'employee_hire_date' => $_POST['employee_hire_date'],
                'employee_position' => $_POST['employee_position'],
                'employee_department' => $_POST['employee_department'],
                'employee_soft_skills' => $_POST['employee_soft_skills'],
                'employee_hard_skills' => $_POST['employee_hard_skills'],
                'is_active' => $_POST['is_active']
            ];

            $this->employeeModel->edit($employeeData);

            $_SESSION['message'] = "Employee updated successfully";
            header("Location: /super_admin/competency");
        }
    }

    public function deleteEmployee($user_id)
    {
        $this->userModel->delete($user_id);
        $this->employeeModel->delete($user_id);
        $_SESSION['message'] = "Employee deleted successfully";
        header("Location: /super_admin/competency");
    }

    public function forgot_requests()
    {
        $data = [
            "requests" => $this->forgotRequestsModel->getAll()
        ];

        loadView("head");
        loadView("$this->role/forgot_requests", $data);
    }

    public function approveRequest($user_id)
    {
        if ($this->requestMethod == 'POST') {
            $newPassword = $_POST['user_password'];

            $this->userModel->updatePassword($user_id, $newPassword);
            $this->forgotRequestsModel->delete($user_id);

            $_SESSION['message'] = "Password reset and request approved successfully";
            header("Location: /super_admin/forgot_requests");
        }
    }

    public function rejectRequest($user_id)
    {
        if ($this->requestMethod == 'POST') {
            $this->forgotRequestsModel->delete($user_id);

            $_SESSION['message'] = "Request rejected successfully";
            header("Location: /super_admin/forgot_requests");
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
