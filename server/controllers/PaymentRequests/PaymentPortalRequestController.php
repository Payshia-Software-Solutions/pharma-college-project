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
            'number_type'       => 'default', // Set a default value
            'payment_reson'     => $_POST['paymentReason'] ?? null,
            'paid_amount'       => $_POST['amount'] ?? null,
            'payment_reference' => $_POST['reference'] ?? null,
            'bank'              => $_POST['bank'] ?? null,
            'branch'            => $_POST['branch'] ?? null,
            'slip_path'         => null, // Will be assigned after upload
            'paid_date'         => date('Y-m-d'),
            'created_at'        => date('Y-m-d H:i:s'),
            'is_active'         => 1,
            'hash_value'        => null, // Image hash
        ];

        // Handle file upload
        if (!empty($_FILES['slip']['tmp_name'])) {
            $fileTmpPath = $_FILES['slip']['tmp_name'];

            // Generate SHA-256 hash of the image file
            $imageHash = hash_file('sha256', $fileTmpPath);
            $data['hash_value'] = $imageHash; // Store in the database

            // Check if the image already exists in the database
            if ($this->isDuplicateImage($imageHash)) {
                http_response_code(409); // Conflict
                echo json_encode([
                    'success' => false,
                    'error'   => 'Duplicate image detected. The same image has already been uploaded.'
                ]);
                return;
            }

            // Define upload path
            $uploadDir  = './uploads/';
            $fileName   = $imageHash . '.' . pathinfo($_FILES['slip']['name'], PATHINFO_EXTENSION); // Name file using hash
            $uploadFile = $uploadDir . $fileName;

            // Ensure the upload directory exists
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            // Move the file to the upload directory
            if (move_uploaded_file($fileTmpPath, $uploadFile)) {
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

    /**
     * Check if an image with the same hash already exists in the database
     */
    private function isDuplicateImage($imageHash)
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM payment_requests WHERE hash_value = :hash_value");
        $stmt->execute(['hash_value' => $imageHash]);
        return $stmt->fetchColumn() > 0;
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
