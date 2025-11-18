<?php
require_once 'models/ChatMessage.php';

class ChatMessageController
{
    private $model;
    public function __construct($pdo)
    {
        $this->model = new ChatMessage($pdo);
    }
    public function getByChatId($chatId)
    {
        echo json_encode($this->model->getByChatId($chatId));
    }
    public function create()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $this->model->create($data);
        echo json_encode(["message" => "Chat message sent"]);
    }
    public function delete($id)
    {
        $this->model->delete($id);
        echo json_encode(["message" => "Chat message deleted"]);
    }
}
