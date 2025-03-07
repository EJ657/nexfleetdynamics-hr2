<?php
class ProgressModel extends BaseModel
{
    protected $table = 'tbl_employee_module_progress', $table1 = "tbl_missed_tasks";

    public function getByEmployeeId($employee_id, $module_id)
    {
        $query = "SELECT progress_status FROM $this->table WHERE employee_id = ? AND module_id = ?";
        $params = ["ii", $employee_id, $module_id];
        $result = $this->queryBuilder($query, $params);
        return $result->fetch_assoc();
    }

    public function getAll()
    {
        $query = "SELECT p.*, e.employee_name, m.module_name FROM $this->table p INNER JOIN tbl_employees e ON p.employee_id = e.employee_id INNER JOIN tbl_modules m ON p.module_id = m.module_id";
        $result = $this->db->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getEmployeeProgressCount()
    {
        $query = "SELECT COUNT(*) as total FROM $this->table WHERE progress_status = 'In Progress' GROUP BY employee_id";
        $result = $this->db->query($query);
        return $result->fetch_assoc();
    }

    public function getEmployeeCompletedCount()
    {
        $query = "SELECT COUNT(*) as total FROM $this->table WHERE progress_status = 'Completed' GROUP BY employee_id";
        $result = $this->db->query($query);
        return $result->fetch_assoc();
    }

    public function getTotalMissingModuleTasks()
    {
        $query = "SELECT COUNT(*) as total FROM $this->table1 GROUP BY task_id";
        $result = $this->db->query($query);
        return $result->fetch_assoc();
    }

    public function create($data)
    {
        extract($data);
        $query = "INSERT INTO $this->table (employee_id, module_id) VALUES (?, ?)";
        $params = ["ii", $employee_id, $module_id];
        $result = $this->queryBuilder($query, $params);
        return $result;
    }
    
    public function updateStatus($employee_id, $module_id, $progress_status)
    {
        $query = "UPDATE $this->table SET progress_status = ? WHERE employee_id = ? AND module_id = ?";
        $params = ["sii", $progress_status, $employee_id, $module_id];
        $result = $this->queryBuilder($query, $params);
        return $result;
    }

    public function createMissedTask($data)
    {
        extract($data);
        $query = "INSERT INTO $this->table1 (employee_id, task_id) VALUES (?, ?)";
        $params = ["ii", $employee_id, $task_id];
        $result = $this->queryBuilder($query, $params);
        return $result;
    }
}
