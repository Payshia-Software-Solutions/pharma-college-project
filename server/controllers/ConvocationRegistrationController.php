<?php
// controllers/ConvocationRegistrationController.php

require_once './models/ConvocationRegistration.php';
require_once './controllers/TransactionPaymentController.php';
require_once './controllers/UserFullDetailsController.php';
require_once './models/SMSModel.php';

class ConvocationRegistrationController
{
    private $model;
    private $ftpConfig;
    private $transactionPaymentController;
    private $userFullDetailsController;
    private $smsModel;
    private $templatePath;
    private $convocationTemplatePath;

    public function __construct($pdo, $convocationTemplatePath)
    {
        $this->model = new ConvocationRegistration($pdo);
        $this->convocationTemplatePath = $convocationTemplatePath;
        $this->ftpConfig = include('./config/ftp.php');
        $this->transactionPaymentController = new TransactionPaymentController($pdo);
        $this->userFullDetailsController = new UserFullDetailsController($pdo);
        $this->smsModel = new SMSModel($_ENV['SMS_AUTH_TOKEN'], $_ENV['SMS_SENDER_ID'], $convocationTemplatePath);
    }

    private function ensureDirectoryExists($ftp_conn, $dir)
    {
        $parts = explode('/', $dir);
        $path = '';
        foreach ($parts as $part) {
            if (empty($part)) {
                continue;
            }
            $path .= '/' . $part;
            if (!@ftp_chdir($ftp_conn, $path)) {
                if (!ftp_mkdir($ftp_conn, $path)) {
                    throw new Exception("Could not create directory: $path on FTP server.");
                }
            }
        }
    }

    private function uploadToFTP($localFile, $ftpFilePath)
    {
        ini_set('memory_limit', '256M'); // Increase to 256 MB or higher if needed
        // FTP credentials from config
        $ftp_server   = $this->ftpConfig['ftp_server'];
        $ftp_username = $this->ftpConfig['ftp_username'];
        $ftp_password = $this->ftpConfig['ftp_password'];

        // Connect to FTP server
        $ftp_conn = ftp_connect($ftp_server);
        if (!$ftp_conn) {
            error_log("FTP connection failed: $ftp_server");
            return false;
        }

        // Login to FTP
        if (!ftp_login($ftp_conn, $ftp_username, $ftp_password)) {
            ftp_close($ftp_conn);
            error_log("FTP login failed for user: $ftp_username");
            return false;
        }

        // Enable passive mode
        ftp_pasv($ftp_conn, true);


        // Ensure that the target directory exists
        try {
            $this->ensureDirectoryExists($ftp_conn, dirname($ftpFilePath));
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
            ftp_close($ftp_conn);
            return;
        }

        // Upload file
        if (!ftp_put($ftp_conn, $ftpFilePath, $localFile, FTP_BINARY)) {
            ftp_close($ftp_conn);
            error_log("Failed to upload: $localFile to $ftpFilePath");
            return false;
        }

        // Close FTP connection
        ftp_close($ftp_conn);
        return true;
    }
    // GET all registrations
    public function getRegistrations()
    {
        $registrations = $this->model->getAllRegistrations();
        echo json_encode($registrations);
    }

    public function getCountsBySessions()
    {
        $registrations = $this->model->getCountsBySessions();
        echo json_encode($registrations);
    }


    public function getAdditionalSeatsCountsBySessions($sessionId)
    {
        $registrations = $this->model->getAdditionalSeatsCountsBySessions($sessionId);
        echo json_encode($registrations);
    }
    // GET a single registration by ID
    public function getRegistration($registration_id)
    {
        $registration = $this->model->getRegistrationById($registration_id);
        if ($registration) {
            echo json_encode($registration);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Registration not found']);
        }
    }

    // GET a single registration by ID
    public function validateDuplicate($student_number)
    {
        $registration = $this->model->validateDuplicate($student_number);
        if ($registration) {
            echo json_encode($registration);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Registration not found']);
        }
    }

    // GET a single registration by ID
    public function checkHashDupplicate($generated_hash)
    {
        $registration = $this->model->checkHashDupplicate($generated_hash);
        if ($registration) {
            echo json_encode($registration);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Registration not found']);
        }
    }


    // GET a single registration by reference number
    public function getRegistrationByReference($reference_number)
    {
        $registration = $this->model->getRegistrationByReference($reference_number);
        if ($registration) {
            echo json_encode($registration);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Registration not found']);
        }
    }

    // POST create a new registration (no reference_number in input)
    public function createRegistration()
    {
        $paymentSlipPath = '';
        // Check if the request is multipart/form-data
        if ($_SERVER['CONTENT_TYPE'] && strpos($_SERVER['CONTENT_TYPE'], 'multipart/form-data') !== false) {
            $data = $_POST; // Form fields
            $file = $_FILES['payment_slip'] ?? null; // Uploaded file (matches frontend FormData key)

            // var_dump($data);

            // Extract course_ids directly from $_POST['course_id']
            $courseIds = isset($data['course_id']) && is_array($data['course_id']) ? $data['course_id'] : [];

            // Debugging: Log or output the incoming data
            error_log("Received data: " . print_r($data, true)); // Log to PHP error log
            error_log("Extracted courseIds: " . print_r($courseIds, true)); // Log courseIds array

            // Required fields validation
            if (
                !isset($data['student_number']) ||
                empty($courseIds) || // Check if $courseIds array is empty
                !isset($data['package_id'])
            ) {
                http_response_code(400);
                echo json_encode(['error' => 'Missing required fields: student_number, course_id, package_id']);
                return;
            }

            // Convert course_ids array to a comma-separated string
            $courseIdsString = implode(',', $courseIds);

            // Handle file upload if provided
            $paymentSlipPath = null;
            if (!empty($file) && $file['error'] === UPLOAD_ERR_OK) {
                $fileTmpPath = $file['tmp_name'];

                // Generate SHA-256 hash of the image file (optional for duplicate checking)
                $imageHash = hash_file('sha256', $fileTmpPath);
                $data['hash_value'] = $imageHash;

                // File details
                $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);
                $fileName = $data['student_number'] . "-payment-" . uniqid() . '.' . $fileExtension;
                $localUploadPath = './uploads/' . $fileName; // Temporary local storage
                $ftpFilePath = "/payment-slips/" . $fileName; // Path on FTP server

                // Ensure the local upload directory exists
                if (!is_dir('./uploads/')) {
                    mkdir('./uploads/', 0777, true);
                }

                // Move the file locally first
                if (!move_uploaded_file($fileTmpPath, $localUploadPath)) {
                    http_response_code(400);
                    echo json_encode(['error' => 'File upload failed']);
                    return;
                }

                // Upload to FTP server
                if ($this->uploadToFTP($localUploadPath, $ftpFilePath)) {
                    $paymentSlipPath = $ftpFilePath; // Store FTP path
                    unlink($localUploadPath); // Remove local file after successful FTP upload
                } else {
                    http_response_code(500);
                    echo json_encode(['error' => 'FTP upload failed']);
                    return;
                }
            }

            // Create registration in the database
            $registration_id = $this->model->createRegistration(
                $data['student_number'],
                $courseIdsString,
                $data['package_id'],
                $data['event_id'] ?? null,
                $data['payment_status'] ?? 'pending',
                $data['payment_amount'] ?? null,
                $data['registration_status'] ?? 'pending',
                $data['hash_value'] ?? null,
                $paymentSlipPath,
                $data['additional_seats'] ?? 0,
                $data['session'] ?? 1
            );
            http_response_code(201);
            echo json_encode([
                'package_id' => $data['package_id'],
                'registration_id' => $registration_id,
                'reference_number' => $registration_id,
                'message' => 'Registration created successfully',
                'payment_slip_path' => $paymentSlipPath
            ]);
        } else {
            // Fallback for JSON (if no file is sent)
            $data = json_decode(file_get_contents('php://input'), true);
            $courseIds = isset($data['course_id']) ? (is_array($data['course_id']) ? $data['course_id'] : [$data['course_id']]) : [];

            // Debugging: Log or output the incoming data
            error_log("Received JSON data: " . print_r($data, true));
            error_log("Extracted courseIds: " . print_r($courseIds, true));

            if (
                !isset($data['student_number']) ||
                empty($courseIds) ||
                !isset($data['package_id'])
            ) {
                http_response_code(400);
                echo json_encode(['error' => 'Missing required fields: student_number, course_id, package_id']);
                return;
            }

            $courseIdsString = implode(',', $courseIds);

            $registration_id = $this->model->createRegistration(
                $data['student_number'],
                $courseIdsString,
                $data['package_id'],
                $data['event_id'] ?? null,
                $data['payment_status'] ?? 'pending',
                $data['payment_amount'] ?? null,
                $data['registration_status'] ?? 'pending',
                $data['hash_value'] ?? null,
                $paymentSlipPath,
                $data['additional_seats'] ?? 0,
                $data['session'] ?? 1
            );
            http_response_code(201);
            echo json_encode([
                'registration_id' => $registration_id,
                'reference_number' => $registration_id,
                'message' => 'Registration created successfully'
            ]);
        }
    }

    // PUT update a registration
    public function updateRegistration($registration_id)
    {
        $data = json_decode(file_get_contents('php://input'), true);
        if (
            !isset($data['student_number']) || !isset($data['course_id']) ||
            !isset($data['package_id'])
        ) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing required fields']);
            return;
        }

        $success = $this->model->updateRegistration(
            $registration_id,
            $data['student_number'],
            $data['course_id'],
            $data['package_id'],
            $data['event_id'] ?? null,
            $data['payment_status'] ?? 'pending',
            $data['payment_amount'] ?? null,
            $data['registration_status'] ?? 'pending'
        );
        if ($success) {
            echo json_encode(['message' => 'Registration updated successfully']);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Registration not found or update failed']);
        }
    }

    // DELETE a registration
    public function deleteRegistration($registration_id)
    {
        $success = $this->model->deleteRegistration($registration_id);
        if ($success) {
            echo json_encode(['message' => 'Registration deleted successfully']);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Registration not found or deletion failed']);
        }
    }

    public function updateSession($reference_number)
    {
        if (!isset($_POST['session'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing required session field']);
            return;
        }

        $session = $_POST['session'];

        $updated = $this->model->updateSession($reference_number, $session);
        if ($updated) {
            http_response_code(201);
            echo json_encode([
                'status' => 'Success',
                'message' => 'Session updated to ' . $session,
                'reference_number' => $reference_number,
            ]);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to update convocation registration']);
        }
    }


    public function updatePayment($reference_number)
    {
        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data['payment_status']) || !isset($data['payment_amount'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing required payment fields']);
            return;
        }

        $paymentAmount = $data['payment_amount'];
        $recInfo = $this->model->getRegistrationByReference($reference_number);
        $student_number = $recInfo['student_number'];
        $recAmount = $recInfo['payment_amount'];

        $paybleAmount = $this->model->getPayableAmount($reference_number);
        $paidAmount = $this->transactionPaymentController->model->getPaidAmount($student_number, 'covocation-payment');
        $studentInfo = $this->userFullDetailsController->model->getUserByUserName($student_number);
        $txnNumber = $this->transactionPaymentController->generateTransactionId();

        $paymentData = [
            'transaction_id'    => $txnNumber,
            'rec_time'          => date('Y-m-d H:i:s'),
            'reference'         => 'Convocation Payment',
            'ref_id'            => '1',
            'created_by'        => $data['created_by'] ?? '',
            'created_at'        => date('Y-m-d H:i:s'),
            'student_number'    => $student_number,
            'transaction_type'  => "CREDIT",
            'reference_key'     => 'covocation-payment',
            'payment_amount'    => $paymentAmount
        ];

        $updatePaymentAmount = $paidAmount + $recAmount;

        $created = $this->transactionPaymentController->model->createPayment($paymentData);

        if (!$created) {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to create payment record']);
            return;
        } else {
            // Log the payment creation
            echo json_encode("Payment record created successfully for reference number: $reference_number");
        }


        $updated = $this->model->updatePayment($reference_number, $data['payment_status'], $updatePaymentAmount);

        if ($updated) {
            // Prepare the welcome message
            $mobile = $studentInfo['telephone_1']; // Assuming 'phone_number' is the key for the user's mobile number
            $studentName = $studentInfo['name_on_certificate']; // Combine first and last name
            $referenceNumber = $reference_number; // Use the user ID as the reference number

            // Send the welcome SMS
            $smsResponse = $this->smsModel->sendConvocationPaymentApprovedSMS($mobile, $studentName, $referenceNumber, $txnNumber, $paymentAmount);

            // Check if the SMS was sent successfully
            if ($smsResponse['status'] === 'error') {
                throw new Exception('Failed to send welcome SMS: ' . $smsResponse['message']);
            }

            // Return success response with the new user's ID
            http_response_code(201); // Created successfully
            echo json_encode([
                'status' => 'Success',
                'message' => 'Payment record created and convocation updated',
                'reference_number' => $reference_number,
                'sms_status' => $smsResponse['status'],
                'sms_message' => $smsResponse['message']
            ]);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to update convocation registration']);
        }
    }
}
