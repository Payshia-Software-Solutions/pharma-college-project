<?php
require_once 'models/Chat.php';

class ChatController
{
    private $model;
    public function __construct($pdo)
    {
        $this->model = new Chat($pdo);
    }
    public function getAll()
    {
        echo json_encode($this->model->getAll());
    }
    public function getById($id)
    {
        $chat = $this->model->getById($id);
        echo $chat ? json_encode($chat) : json_encode(["error" => "Not found"]);
    }
    public function getByUsername($user_name)
    {
        $chat = $this->model->getByUsername($user_name);
        echo $chat ? json_encode($chat) : json_encode(["error" => "Not found"]);
    }

    public function create()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        // Check if user_name is present and not empty
        if (!isset($data['user_name']) || trim($data['user_name']) === '') {
            http_response_code(400); // Bad Request
            echo json_encode(["error" => "user_name is required"]);
            return;
        }

        // Set optional fields to null if not provided
        $validatedData = [
            'user_name' => $data['user_name'],
            'user_avatar' => $data['user_avatar'] ?? null,
            'last_message_preview' => $data['last_message_preview'] ?? null,
            'last_message_time' => $data['last_message_time'] ?? null,
            'unread_count' => $data['unread_count'] ?? 0,
        ];

        $this->model->create($validatedData);

        echo json_encode(["message" => "Chat created"]);
    }

    public function delete($id)
    {
        $this->model->delete($id);
        echo json_encode(["message" => "Chat deleted"]);
    }
}
