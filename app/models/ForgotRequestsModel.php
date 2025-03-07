<?php
class ForgotRequestsModel extends BaseModel
{
    protected $table = 'tbl_forgot_requests';

    public function getAll()
    {
        $query = "SELECT r.*, u.user_username, u.user_id FROM $this->table r INNER JOIN tbl_users u ON r.user_id = u.user_id";
        $result = $this->db->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getAllAdmin()
    {
        $query = "SELECT r.*, u.user_username, u.user_id FROM $this->table r INNER JOIN tbl_users u ON r.user_id = u.user_id WHERE u.user_role <> 'admin' AND u.user_role <> 'super_admin'";
        $result = $this->db->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function create($data)
    {
        extract($data);
        $query = "INSERT INTO $this->table (user_id, forgot_reason) VALUES (?, ?)";
        $params = ["is", $user_id, $forgot_reason];
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
