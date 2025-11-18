<?php
require_once 'models/BnfPage.php';

class BnfPageController
{
    private $model;
    public function __construct($pdo)
    {
        $this->model = new BnfPage($pdo);
    }

    public function getAll()
    {
        echo json_encode($this->model->getAll());
    }

    public function getById($id)
    {
        echo json_encode($this->model->getById($id));
    }

    public function getByChapterId($chapterId)
    {
        echo json_encode($this->model->getByChapterId($chapterId));
    }

    public function create()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $this->model->create($data);
        echo json_encode(["message" => "BNF Page created"]);
    }

    public function update($id)
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $this->model->update($id, $data);
        echo json_encode(["message" => "BNF Page updated"]);
    }

    public function delete($id)
    {
        $this->model->delete($id);
        echo json_encode(["message" => "BNF Page deleted"]);
    }
}
