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
          $files = $_FILES;

         // Log received data for debugging
        error_log("POST Data: " . print_r($data, true));
        error_log("Files: " . print_r($files, true));
                  
        // Handle file upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
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

    // Check if 'created_by' is present and valid
    if (!isset($data['created_by']) || empty($data['created_by'])) {
        http_response_code(400);
        echo json_encode(['error' => 'The created_by field is required.']);
        return;
    }

    // Check if 'created_at' is present in the form data
    if (!isset($data['created_at']) || empty($data['created_at'])) {
        http_response_code(400);
        echo json_encode(['error' => 'The created_at field is required.']);
        return;
    }

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

    function getRecordByUserName($created_by)
    {
        $records = $this->model->getRecordByUserName($created_by);
        echo json_encode($records);
    }

    public function getStatistics()
{
    // Fetch the statistics from the model
    $records = $this->model->getStatistics();

    // Set the appropriate content type for JSON
    header('Content-Type: application/json');

    // Send the JSON response
    echo json_encode($records);
}


}