<?php
require_once './models/community/CommunityPostReplyRatings.php';

class CommunityPostReplyRatingsController
{
    private $model;

    public function __construct($pdo)
    {
        $this->model = new CommunityPostReplyRatings($pdo);
    }

    public function getAllRecords()
    {
        $records = $this->model->getAllRecords();
        echo json_encode($records);
    }

    public function getRecordById($reply_id)
    {
        $record = $this->model->getRecordById($reply_id);
        if ($record) {
            echo json_encode($record);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Record not found']);
        }
    }

    public function createRecord()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $this->model->createRecord($data);
        http_response_code(201);
        echo json_encode(['message' => 'Record created successfully']);
    }

    public function updateRecord($reply_id)
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $this->model->updateRecord($reply_id, $data);
        echo json_encode(['message' => 'Record updated successfully']);
    }

    public function deleteRecord($reply_id)
    {
        $this->model->deleteRecord($reply_id);
        echo json_encode(['message' => 'Record deleted successfully']);
    }
}