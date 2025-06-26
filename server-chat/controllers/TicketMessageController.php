<?php

require_once 'models/TicketMessage.php';

class TicketMessageController
{
    private $model;
    public function __construct($pdo)

    {
        $this->model = new TicketMessage($pdo);
    }

    public function getAll()
    {
        echo json_encode($this->model->getAll());
    }

    public function getByUsername($user_name)
    {
        echo json_encode($this->model->getByUsername($user_name));
    }
    public function getByTicketId($ticketId)
    {
        echo json_encode($this->model->getByTicketId($ticketId));
    }
    public function create()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $this->model->create($data);
        echo json_encode(["message" => "Message added"]);
    }
    public function delete($id)
    {
        $this->model->delete($id);
        echo json_encode(["message" => "Message deleted"]);
    }
}
