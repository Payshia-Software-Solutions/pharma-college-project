<?php

require_once 'models/Ticket.php';

class TicketController
{
    private $model;
    public function __construct($pdo)
    {
        $this->model = new Ticket($pdo);
    }
    public function getAll()
    {
        echo json_encode($this->model->getAll());
    }
    public function getById($id)
    {
        $record = $this->model->getById($id);
        echo $record ? json_encode($record) : json_encode(["error" => "Not found"]);
    }
    public function create()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $this->model->create($data);
        echo json_encode(["message" => "Ticket created"]);
    }
    public function delete($id)
    {
        $this->model->delete($id);
        echo json_encode(["message" => "Ticket deleted"]);
    }
}
