<?php
require_once 'models/BnfWordIndex.php';

class BnfWordIndexController
{
    private $model;
    public function __construct($pdo)
    {
        $this->model = new BnfWordIndex($pdo);
    }

    public function getAll()
    {
        echo json_encode($this->model->getAll());
    }

    public function getByWord($word)
    {
        echo json_encode($this->model->getByWord($word));
    }

    public function create()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $this->model->create($data);
        echo json_encode(["message" => "Word index entry created"]);
    }

    public function delete($id)
    {
        $this->model->delete($id);
        echo json_encode(["message" => "Word index entry deleted"]);
    }
}
