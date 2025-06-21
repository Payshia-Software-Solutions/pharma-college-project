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
    public function create()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $this->model->create($data);
        echo json_encode(["message" => "Chat created"]);
    }
    public function delete($id)
    {
        $this->model->delete($id);
        echo json_encode(["message" => "Chat deleted"]);
    }
}
