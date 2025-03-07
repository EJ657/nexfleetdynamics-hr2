<?php
session_start();
require 'vendor/autoload.php';

class MessageController
{
    private $requestMethod, $role, $messageModel, $options, $pusher;

    public function __construct()
    {
        $this->messageModel = new MessagesModel();
        $this->requestMethod = $_SERVER['REQUEST_METHOD'];
        $this->role = $_SESSION['user_role'];

        if (!isset($this->role)) {
            header("Location: /logout");
        }

        $this->options = array(
            'cluster' => 'ap1',
            'useTLS' => true
        );
        $this->pusher = new Pusher\Pusher(
            '79462a5abaa97adfea67',
            '939c74783501ce5c6026',
            '1950550',
            $this->options
        );

        header("Content-Type: application/json");
    }

    public function sendMessage() 
    {
        if ($this->requestMethod == 'POST') {
            $sender_id = $_SESSION['user_id'];
            $receiver_id = $_POST['receiver_id'];
            $message = $_POST['message'];

            $result = $this->messageModel->checkPermission($sender_id, $receiver_id);

            if ($result) {
                $this->messageModel->sendMessage($sender_id, $receiver_id, $message);
                $this->pusher->trigger('chat-channel-' . $receiver_id, 'new-message', [
                    'sender' => $sender_id,
                    'message' => $message,
                    'timestamp' => date('Y-m-d H:i:s')
                ]);
                echo json_encode(['status' => 'success', 'message' => 'Message sent successfully']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'You do not have permission to send message to this user']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
        }
    }

    public function getMessages($other_user)
    {
        $messages = $this->messageModel->getMessages($other_user);
        echo json_encode(['status' => 'success', 'messages' => $messages]);
    }
}
