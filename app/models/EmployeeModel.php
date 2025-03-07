<?php
class EmployeeModel extends BaseModel
{
    protected $table = 'tbl_employees';

    public function get($id)
    {
        $query = "SELECT * FROM $this->table WHERE employee_id = ?";
        $params = ["i", $id];
        $result = $this->queryBuilder($query, $params);
        return $result->fetch_assoc();
    }

    public function getByUserId($user_id)
    {
        $query = "SELECT * FROM $this->table WHERE user_id = ?";
        $params = ["i", $user_id];
        $result = $this->queryBuilder($query, $params);
        return $result->fetch_assoc();
    }

    public function getAll()
    {
        $query = "SELECT a.*, u.user_username, u.user_id FROM $this->table a INNER JOIN tbl_users u ON a.user_id = u.user_id";
        $result = $this->db->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function create($data)
    {
        extract($data);
        $query = "INSERT INTO $this->table (user_id, employee_name, employee_hire_date, employee_position, employee_department, employee_soft_skills, employee_hard_skills, is_active) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $params = ["issssssi", $user_id, $employee_name, $employee_hire_date, $employee_position, $employee_department, $employee_soft_skills, $employee_hard_skills, $is_active];
        $result = $this->queryBuilder($query, $params);
        return $result;
    }

    public function edit($data)
    {
        extract($data);
        $query = "UPDATE $this->table SET employee_name = ?, employee_hire_date = ?, employee_position = ?, employee_department = ?, employee_soft_skills = ?, employee_hard_skills = ?, is_active = ? WHERE user_id = ?";
        $params = ["ssssssii", $employee_name, $employee_hire_date, $employee_position, $employee_department, $employee_soft_skills, $employee_hard_skills, $is_active, $user_id];
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
}