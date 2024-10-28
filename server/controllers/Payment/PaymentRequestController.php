<?php
require_once './models/payment/PaymentRequest.php';

class PaymentRequestController
{
    private $model;
    private $ftpConfig;

    public function __construct($pdo)
    {
        $this->model = new PaymentRequest($pdo);
        $this->ftpConfig = include('./config/ftp.php');
    }

    // Function to upload file via FTP with original filename
    private function uploadFileToFtp($localFilePath, $originalFileName, $userName)
    {
        $ftp_target_dir = '/content-provider/payments/payment-slips/' . $userName . '/';

        // Connect to FTP server
        $ftpCon = ftp_connect($this->ftpConfig['ftp_server'], $this->ftpConfig['ftp_port']);
        if (!$ftpCon) {
            throw new Exception("Failed to connect to FTP Server");
        }

        // Login to FTP server
        $login = ftp_login($ftpCon, $this->ftpConfig['ftp_username'], $this->ftpConfig['ftp_password']);
        if (!$login) {
            ftp_close($ftpCon);
            throw new Exception("Failed to login to FTP Server");
        }

        // Set passive mode if needed
        ftp_pasv($ftpCon, true);

        // Recursively create directories if they don't exist
        $pathParts = explode('/', trim($ftp_target_dir, '/'));
        $currentDir = '';
        foreach ($pathParts as $part) {
            $currentDir .= '/' . $part;
            if (!@ftp_chdir($ftpCon, $currentDir)) {
                if (!ftp_mkdir($ftpCon, $currentDir)) {
                    ftp_close($ftpCon);
                    throw new Exception("Failed to create directory: $currentDir");
                }
            }
        }

        // Explicitly set a unique local path to rename the file temporarily
        $tempLocalPath = sys_get_temp_dir() . DIRECTORY_SEPARATOR . uniqid() . '-' . $originalFileName;
        if (!move_uploaded_file($localFilePath, $tempLocalPath)) {
            throw new Exception("Failed to move uploaded file to temporary location.");
        }

        // Upload the file with the original filename
        $remoteFilePath = $ftp_target_dir . $originalFileName;
        if (!ftp_put($ftpCon, $remoteFilePath, $tempLocalPath, FTP_BINARY)) {
            ftp_close($ftpCon);
            throw new Exception("Failed to upload file to FTP Server");
        }

        // Remove the temporary file
        unlink($tempLocalPath);

        // Close FTP connection
        ftp_close($ftpCon);

        return $remoteFilePath;
    }

    public function createRecord()
    {
        // Collect POST data
        $data = $_POST;

        // Handle file upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            // $localFilePath = $_FILES['image']['tmp_name'];
            error_log(json_encode($_FILES));
            $originalFileName = basename($_FILES['image']['name']); // Original name with extension
            return;
            

            try {
                // Upload to FTP server using the original file name (with extension)
                $imagePath = $this->uploadFileToFtp($localFilePath, $originalFileName, $data['created_by']);
            } catch (Exception $e) {
                http_response_code(500);
                echo json_encode(['error' => $e->getMessage()]);
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

        // Handle file upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $localFilePath = $_FILES['image']['tmp_name'];
            $originalFileName = $_FILES['image']['name']; // Original name with extension

            try {
                // Upload to FTP server using the original file name (with extension)
                $imagePath = $this->uploadFileToFtp($localFilePath, $originalFileName, $data['created_by']);
            } catch (Exception $e) {
                http_response_code(500);
                echo json_encode(['error' => $e->getMessage()]);
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

    public function getRecordByUserName($created_by)
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

    public function getByCourseCode($courseCode)
    {
        $records = $this->model->getByCourseCode($courseCode);
        echo json_encode($records);
    }

    public function getStatisticsByCourse($courseCode)
    {
        $records = $this->model->getStatisticsByCourseCode($courseCode);
        echo json_encode($records);
    }
}