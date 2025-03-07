<?php
class UserModel extends BaseModel
{
    protected $table = 'tbl_users';

    public function get($id)
    {
        $query = "SELECT * FROM $this->table WHERE user_id = ?";
        $params = ["i", $id];
        $result = $this->queryBuilder($query, $params);
        return $result->fetch_assoc();
    }

    public function getAll()
    {
        $query = "SELECT * FROM $this->table";
        $result = $this->db->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    public function getAllSuperAdmin()
    {
        $query = "SELECT u.*, COALESCE(a.admin_name, s.supervisor_name) as user_name, s.supervisor_name, a.admin_name FROM $this->table u LEFT JOIN tbl_admin a ON a.user_id = u.user_id LEFT JOIN tbl_supervisor s ON s.user_id = u.user_id WHERE u.user_role <> 'super_admin' AND u.user_role <> 'employee'";
        $result = $this->db->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function check($user_username)
    {
        $query = "SELECT * FROM $this->table WHERE user_username = ?";
        $params = ["s", $user_username];
        $result = $this->queryBuilder($query, $params);
        return $result->fetch_assoc();
    }

    public function create($data)
    {
        extract($data);
        $user_password = password_hash($user_password, PASSWORD_DEFAULT);
        $query = "INSERT INTO $this->table (user_username, user_password, user_role) VALUES (?, ?, ?)";
        $params = ["sss", $user_username, $user_password, $user_role];
        $result = $this->queryBuilder($query, $params);
        return $result;
    }

    public function edit($data)
    {
        extract($data);
        if ($user_password != '') {
            $password = ", user_password = ?";
            $user_password = password_hash($user_password, PASSWORD_DEFAULT);
            $params = ["ssi", $user_username, $user_password, $user_id];
        } else {
            $password = "";
            $params = ["si", $user_username, $user_id];
        }
        $query = "UPDATE $this->table SET user_username = ?$password WHERE user_id = ?";
        $result = $this->queryBuilder($query, $params);
        return $result;
    }

    public function delete($user_id)
    {
        $query = "DELETE FROM $this->table WHERE user_id = ?";
        $params = ["i", $user_id];
        $result = $this->queryBuilder($query, $params);
        return $result;
    }

    public function updatePassword($user_id, $password)
    {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $query = "UPDATE $this->table SET user_password = ? WHERE user_id = ?";
        $params = ['si', $password, $user_id];
        $result = $this->queryBuilder($query, $params);
        return $result;
    }
}