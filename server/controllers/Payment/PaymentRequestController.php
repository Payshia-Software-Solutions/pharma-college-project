<?php
require_once './models/payment/PaymentRequest.php';

class PaymentRequestController
{
    private $model;

    public function __construct($pdo)
    {
        $this->model = new PaymentRequest($pdo);
    }

    public function getAllRecords()
    {
        $records = $this->model->getAllRecords();
        echo json_encode($records);
    }

    public function getRecordById($id)
    {
        $record = $this->model->getRecordById($id);
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
        
        // Handle file upload
        if (isset($_FILES['image'])) {
            $imagePath = './uploads/images/Payments' . basename($_FILES['image']['name']);
            move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'Image is required']);
            return;
        }

        $this->model->createRecord($data, $imagePath);
        http_response_code(201);
        echo json_encode(['message' => 'Record created successfully']);
    }

    public function updateRecord($id)
    {
        $data = json_decode(file_get_contents("php://input"), true);

        $imagePath = null;
        if (isset($_FILES['image'])) {
            $imagePath = './uploads/images/Payments' . basename($_FILES['image']['name']);
            move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
        }

        $this->model->updateRecord($id, $data, $imagePath);
        echo json_encode(['message' => 'Record updated successfully']);
    }

    public function deleteRecord($id)
    {
        $this->model->deleteRecord($id);
        echo json_encode(['message' => 'Record deleted successfully']);
    }
}