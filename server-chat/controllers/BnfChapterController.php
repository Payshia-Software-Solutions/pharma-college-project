<?php
require_once 'models/BnfChapter.php';

class BnfChapterController
{
    private $model;
    public function __construct($pdo)
    {
        $this->model = new BnfChapter($pdo);
    }

    public function getAll()
    {
        echo json_encode($this->model->getAll());
    }

    public function getById($id)
    {
        echo json_encode($this->model->getById($id));
    }

    public function create()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $this->model->create($data);
        echo json_encode(["message" => "BNF Chapter created"]);
    }

    public function update($id)
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $this->model->update($id, $data);
        echo json_encode(["message" => "BNF Chapter updated"]);
    }

    public function delete($id)
    {
        $this->model->delete($id);
        echo json_encode(["message" => "BNF Chapter deleted"]);
    }
}
