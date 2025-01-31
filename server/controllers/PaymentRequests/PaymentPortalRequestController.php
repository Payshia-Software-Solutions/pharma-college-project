<?php
require_once './models/PaymentRequests/PaymentPortalRequest.php';

class PaymentPortalRequestController
{
    private $model;
    private $pdo; // Store PDO connection

    public function __construct($pdo)
    {
        $this->pdo = $pdo; // Store PDO for database operations
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
        // Extract data from $_POST
        $data = [
            'unique_number'     => $_POST['studentNumber'] ?? null,
            'number_type'       => 'student_number', // Set a default or map accordingly
            'payment_reson'     => $_POST['paymentReason'] ?? null,
            'paid_amount'       => $_POST['amount'] ?? null,
            'payment_reference' => $_POST['reference'] ?? null,
            'bank'              => $_POST['bank'] ?? null,
            'branch'            => $_POST['branch'] ?? null,
            'slip_path'         => 'test', // Will handle file separately
            'paid_date'         => date('Y-m-d'), // Use current date if not provided
            'created_at'        => date('Y-m-d H:i:s'),
            'is_active'         => 1,
            'hash_value'        => md5(uniqid()), // Generate a unique hash
        ];

        print_r($data);

        // Handle file upload
        if (!empty($_FILES['slip']['name'])) {
            $uploadDir  = './uploads/';
            $fileName   = time() . '_' . basename($_FILES['slip']['name']); // Unique filename
            $uploadFile = $uploadDir . $fileName;

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true); // Ensure the upload directory exists
            }

            if (move_uploaded_file($_FILES['slip']['tmp_name'], $uploadFile)) {
                $data['slip_path'] = $uploadFile;
            } else {
                http_response_code(400);
                echo json_encode([
                    'success' => false,
                    'error'   => 'File upload failed'
                ]);
                return;
            }
        }

        // Validate data
        if ($this->validateData($data)) {
            // Insert into database
            $this->model->createRecord($data);

            // Get last inserted ID as reference number
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
            $data['is_active']
        );
    }
}
