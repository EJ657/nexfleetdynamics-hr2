<?php
class MessagesModel extends BaseModel
{
    protected $table = 'tbl_chat_permissions', $table1 = "tbl_chat_messages";

    public function checkPermission($sender_id, $receiver_id)
    {
        $sender_id = filter_var($sender_id, FILTER_SANITIZE_NUMBER_INT);
        $receiver_id = filter_var($receiver_id, FILTER_SANITIZE_NUMBER_INT);

        $query = "SELECT u1.user_role AS sender_role, u2.user_role AS receiver_role FROM tbl_users u1, tbl_users u2 WHERE u1.user_id = ? AND u2.user_id = ?";
        $params = ["ii", $sender_id, $receiver_id];
        $result = $this->queryBuilder($query, $params);
        $roles = $result->fetch_assoc();

        $query1 = "SELECT * FROM tbl_chat_permissions WHERE sender_role = ? AND receiver_role = ?";
        $params = ["ss", $roles['sender_role'], $roles['receiver_role']];
        $result1 = $this->queryBuilder($query1, $params);
        return $result1->num_rows > 0;
    }

    public function sendMessage($sender_id, $receiver_id, $message)
    {
        $query = "INSERT INTO tbl_chat_messages (sender_id, receiver_id, message) VALUES (?, ?, ?)";
        $params = ["iis", $sender_id, $receiver_id, $message];
        $result = $this->queryBuilder($query, $params);
        return $result;
    }

    public function getMessages($other_user)
    {
        $current_user = $_SESSION['user_id'];
        $other_user = filter_var($other_user, FILTER_SANITIZE_NUMBER_INT);
        $query = "SELECT m.*, 
                COALESCE(a.admin_name, e.employee_name, s.supervisor_name, 'Super Admin') as sender_name 
                FROM tbl_chat_messages m
                LEFT JOIN tbl_users u ON m.sender_id = u.user_id
                LEFT JOIN tbl_admin a ON u.user_id = a.user_id
                LEFT JOIN tbl_employees e ON u.user_id = e.user_id
                LEFT JOIN tbl_supervisor s ON u.user_id = s.user_id
                WHERE (m.sender_id = ? AND m.receiver_id = ?)
                OR (m.sender_id = ? AND m.receiver_id = ?)
                ORDER BY timestamp ASC";
        $params = ["iiii", $current_user, $other_user, $other_user, $current_user];
        $result = $this->queryBuilder($query, $params);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getContacts()
    {
        $query = "SELECT DISTINCT u.user_id, u.user_role, COALESCE(a.admin_name, e.employee_name, s.supervisor_name, 'Super Administrator') as user_name FROM tbl_users u LEFT JOIN tbl_chat_permissions cp ON cp.receiver_role = u.user_role LEFT JOIN tbl_admin a ON a.user_id = u.user_id LEFT JOIN tbl_employees e ON e.user_id = u.user_id LEFT JOIN tbl_supervisor s ON s.user_id = u.user_id WHERE cp.sender_role = ? AND u.user_id != ?";
        $params = ["si", $_SESSION['user_role'], $_SESSION['user_id']];
        $result = $this->queryBuilder($query, $params);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
