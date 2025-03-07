<?php
session_start();
class UserController
{
    private $requestMethod, $role, $userModel, $adminModel, $forgotRequestModel, $supervisorModel, $employeeModel, $progressModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->adminModel = new AdminModel();
        $this->forgotRequestModel = new ForgotRequestsModel();
        $this->supervisorModel = new SupervisorModel();
        $this->employeeModel = new EmployeeModel();
        $this->progressModel = new ProgressModel();
        $this->requestMethod = $_SERVER['REQUEST_METHOD'];
        if (isset($_SESSION['user_role'])) {
            $this->role = $_SESSION['user_role'];
        } else {
            $this->role = false;
        }
    }

    public function index()
    {
        if ($this->role) {
            header("Location: /$this->role/home");
        }

        loadView('head');
        loadView('index');
    }

    public function login()
    {
        if ($this->requestMethod == 'POST') {
            extract($_POST);
            $user = $this->userModel->check($user_email);
            if ($user) {
                if (password_verify($user_password, $user['user_password'])) {
                    
                    if ($user['user_role'] == "admin") {
                        $data = $this->adminModel->getByUserId($user['user_id']);
                        foreach ($data as $key => $value) {
                            if ($key !== 'user_id') {
                                $_SESSION[$key] = $value;
                            }
                        }
                    } else if ($user['user_role'] == "supervisor") {
                        $data = $this->supervisorModel->getByUserId($user['user_id']);
                        foreach ($data as $key => $value) {
                            if ($key !== 'user_id') {
                                $_SESSION[$key] = $value;
                            }
                        }
                    } else if ($user['user_role'] == "employee") {
                        $data = $this->employeeModel->getByUserId($user['user_id']);
                        foreach ($data as $key => $value) {
                            if ($key !== 'user_id') {
                                $_SESSION[$key] = $value;
                            }
                        }

                        // $progressData = $this->progressModel->getByEmployeeId($data['employee_id']);
                        // foreach ($progressData as $key => $value) {
                        //     $_SESSION[$key] = $value;
                        // }
                    }

                    foreach ($user as $key => $value) {
                        if ($key !== 'user_password') {
                            $_SESSION[$key] = $value;
                        }
                    }

                    echo json_encode(['success' => 'true', 'message' => 'Logged in Successfully!', 'user_role' => $user['user_role']]);
                    exit;
                }
            }
            echo json_encode(['success' => 'false', 'message' => 'Invalid username or password']);
            return false;
        } else {
            http_response_code(404);
            die("File not found.");
        }
    }

    public function forgotPassword()
    {
        if ($this->requestMethod === 'POST') {
            extract($_POST);

            $user = $this->userModel->check($user_email);
            if ($user) {
                $data = [
                    "user_id" => $user['user_id'],
                    "forgot_reason" => $forgot_reason
                ];
                $this->forgotRequestModel->create($data);
                echo json_encode(["success" => "true", "message" => "Your request has been sent to the administrator."]);
            } else {
                echo json_encode(["success" => "false", "message" => "Email not found"]);
            }

            return true;
        }
    }

    public function logout()
    {
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params["domain"],
                $params["secure"],
                $params['httpOnly"]']
            );
        }

        session_destroy();
        header("Location: /");
        exit;
    }
}
