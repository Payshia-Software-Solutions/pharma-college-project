<?php
require_once 'models/BnfListItem.php';

class BnfListItemController
{
    private $model;
    public function __construct($pdo)
    {
        $this->model = new BnfListItem($pdo);
    }

    public function getByPageId($page_id)
    {
        echo json_encode($this->model->getByPageId($page_id));
    }

    public function create()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $this->model->create($data);
        echo json_encode(["message" => "List item created"]);
    }

    public function update($id)
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $this->model->update($id, $data);
        echo json_encode(["message" => "List item updated"]);
    }

    public function delete($id)
    {
        $this->model->delete($id);
        echo json_encode(["message" => "List item deleted"]);
    }
}
