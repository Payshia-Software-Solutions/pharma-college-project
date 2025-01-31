<?php
require_once './models/PaymentRequests/PaymentPortalRequest.php';

class PaymentPortalRequestController
{
    private $model;

    public function __construct($pdo)
    {
        $this->model = new PaymentPortalRequest($pdo);
    }

    // Get all payment requests
    public function getAllRecords()
    {
        $records = $this->model->getAllRecords();
        echo json_encode($records);
    }

    // Get a payment request by ID
    public function getRecordById($id)
    {
        $record = $this->model->getRecordById($id);
        if ($record) {
            echo json_encode($record);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Payment request not found']);
        }
    }

    // Create a new payment request
    public function createRecord()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if ($this->validateData($data)) {
            // Insert the payment request
            $this->model->createRecord($data);

            // Get the last inserted ID as the reference number
            $reference = $this->pdo->lastInsertId();

            http_response_code(201);
            echo json_encode([
                'success'   => true,
                'message'   => 'Payment recorded successfully!',
                'reference' => (int) $reference
            ]);
        } else {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'error'   => 'Invalid data'
            ]);
        }
    }


    // Update a payment request
    public function updateRecord($id)
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if ($this->validateData($data)) {
            $this->model->updateRecord($id, $data);
            echo json_encode(['message' => 'Payment request updated successfully']);
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid data']);
        }
    }

    // Delete a payment request
    public function deleteRecord($id)
    {
        $this->model->deleteRecord($id);
        echo json_encode(['message' => 'Payment request deleted successfully']);
    }

    // Data validation method
    private function validateData($data)
    {
        return isset(
            $data['unique_number'],
            $data['number_type'],
            $data['payment_reson'],
            $data['paid_amount'],
            $data['payment_reference'],
            $data['bank'],
            $data['branch'],
            $data['slip_path'],
            $data['paid_date'],
            $data['created_at'],
            $data['is_active'],
            $data['hash_value']
        );
    }
}
