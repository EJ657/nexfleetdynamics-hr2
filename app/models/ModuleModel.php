<?php
class ModuleModel extends BaseModel
{
    protected $table = 'tbl_modules', $table1 = "tbl_module_tasks", $table2 = "tbl_task_questions";

    public function getAllModules()
    {
        if ($_SESSION['user_role'] == 'employee') {
            $query = "SELECT * FROM $this->table WHERE is_active = 1 AND module_position = ?";
            $params = ["s", $_SESSION['employee_position']];
            $result = $this->queryBuilder($query, $params);
        } else {
            $query = "SELECT * FROM $this->table";
            $result = $this->db->query($query);
        }
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getTotalActiveModule()
    {
        $query = "SELECT COUNT(*) as total FROM $this->table WHERE is_active = 1";
        $result = $this->db->query($query);
        return $result->fetch_assoc();
    }

    public function getTotalActiveModuleTasks()
    {
        $query = "SELECT COUNT(*) as total FROM $this->table1 WHERE is_active = 1";
        $result = $this->db->query($query);
        return $result->fetch_assoc();
    }

    public function getAllTasks($module_id)
    {
        $query = "SELECT * FROM $this->table1 WHERE module_id = ?";
        $params = ["i", $module_id];
        $result = $this->queryBuilder($query, $params);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getAllQuestions($task_id)
    {
        $query = "SELECT * FROM $this->table2 WHERE task_id = ?";
        $params = ["i", $task_id];
        $result = $this->queryBuilder($query, $params);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function create($data)
    {
        extract($data);
        $query = "INSERT INTO $this->table (module_name, module_description, module_position, module_content, is_active) VALUES (?, ?, ?, ?, ?)";
        $params = ["ssssi", $module_name, $module_description, $module_position, $module_content, $is_active];
        $result = $this->queryBuilder($query, $params);
        return $result;
    }

    public function createTask($module_id, $data)
    {
        extract($data);
        $query = "INSERT INTO $this->table1 (module_id, task_name, task_description, task_expiration_date, is_active) VALUES (?, ?, ?, ?, ?)";
        $params = ["isssi", $module_id, $task_name, $task_description, $task_expiration_date, $is_active];
        $result = $this->queryBuilder($query, $params);
        return $result;
    }

    public function createQuestion($task_id, $data)
    {
        extract($data);
        $query = "INSERT INTO $this->table2 (task_id, question_text, question_answer, question_data) VALUES (?, ?, ?, ?)";
        $params = ["isss", $task_id, $question_text, $question_answer, $question_data];
        $result = $this->queryBuilder($query, $params);
        return $result;
    }

    public function edit($data)
    {
        extract($data);
        $query = "UPDATE $this->table SET module_name = ?, module_description = ?, module_position = ?, module_content = ?, is_active = ? WHERE module_id = ?";
        $params = ["ssssii", $module_name, $module_description, $module_position, $module_content, $is_active, $module_id];
        $result = $this->queryBuilder($query, $params);
        return $result;
    }

    public function editTask($module_id, $task_id, $data)
    {
        extract($data);
        $query = "UPDATE $this->table1 SET task_name = ?, task_description = ?, task_expiration_date = ?, is_active = ? WHERE module_id = ? AND task_id = ?";
        $params = ["sssiii", $task_name, $task_description, $task_expiration_date, $is_active, $module_id, $task_id];
        $result = $this->queryBuilder($query, $params);
        return $result;
    }

    public function editQuestion($question_id, $data)
    {
        extract($data);
        $query = "UPDATE $this->table2 SET question_text = ?, question_answer = ?, question_data = ? WHERE question_id = ?";
        $params = ["sssi", $question_text, $question_answer, $question_data, $question_id];
        $result = $this->queryBuilder($query, $params);
        return $result;
    }

    public function delete($module_id)
    {
        $query = "DELETE FROM $this->table WHERE module_id = ?";
        $params = ["i", $module_id];
        $result = $this->queryBuilder($query, $params);
        return $result;
    }

    public function deleteTask($task_id)
    {
        $query = "DELETE FROM $this->table1 WHERE task_id = ?";
        $params = ["i", $task_id];
        $result = $this->queryBuilder($query, $params);
        return $result;
    }

    public function deleteQuestion($question_id)
    {
        $query = "DELETE FROM $this->table2 WHERE question_id = ?";
        $params = ["i", $question_id];
        $result = $this->queryBuilder($query, $params);
        return $result;
    }
}
