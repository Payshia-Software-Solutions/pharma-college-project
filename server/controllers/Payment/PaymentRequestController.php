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
    // Collect POST data
    $data = $_POST;

    // Handle file upload
    if (isset($_FILES['image'])) {
        $imagePath = './uploads/images/Payments/' . basename($_FILES['image']['name']);
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to upload image']);
            return;
        }
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Image is required']);
        return;
    }

    // Pass data and image path to the model
    $this->model->createRecord($data, $imagePath);
    http_response_code(201);
    echo json_encode(['message' => 'Record created successfully']);
}


public function updateRecord($id)
{
    $data = $_POST;

    $imagePath = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imagePath = './uploads/images/Payments/' . basename($_FILES['image']['name']);
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to upload image']);
            return;
        }
    }

    // Pass the data and image path to the model for updating
    $this->model->updateRecord($id, $data, $imagePath);
    http_response_code(200);
    echo json_encode(['message' => 'Record updated successfully']);
}


    public function deleteRecord($id)
    {
        $this->model->deleteRecord($id);
        echo json_encode(['message' => 'Record deleted successfully']);
    }
}