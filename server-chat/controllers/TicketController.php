<?php

require_once 'models/Ticket.php';

class TicketController
{
    private $model;
    private $ftpConfig;

    public function __construct($pdo)
    {
        $this->model = new Ticket($pdo);
        $this->ftpConfig = include('./config/ftp.php');
    }

    // FTP Helper Methods (copied from ConvocationRegistrationController)
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
        ini_set('memory_limit', '256M'); // Increase memory limit for image processing

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
            error_log("Directory creation failed: " . $e->getMessage());
            ftp_close($ftp_conn);
            return false;
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

    // Validate image file
    private function validateImage($file)
    {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $maxSize = 5 * 1024 * 1024; // 5MB

        if (!in_array($file['type'], $allowedTypes)) {
            return 'Invalid file type. Only JPEG, PNG, GIF, and WebP are allowed.';
        }

        if ($file['size'] > $maxSize) {
            return 'File size too large. Maximum 5MB allowed.';
        }

        return null; // No errors
    }


    public function getAll()
    {
        echo json_encode($this->model->getAll());
    }
    public function getById($id)
    {
        $record = $this->model->getById($id);
        echo $record ? json_encode($record) : json_encode(["error" => "Not found"]);
    }

    public function getByUsername($user_name)
    {
        echo json_encode($this->model->getByUsername($user_name));
    }

    public function create()
    {

        // Check if the request is multipart/form-data (with file upload)
        if ($_SERVER['CONTENT_TYPE'] && strpos($_SERVER['CONTENT_TYPE'], 'multipart/form-data') !== false) {

            $data = $_POST;
            $file = $_FILES['image'] ?? null; // Uploaded image file

            $newTicketId = $this->model->create($data);
            if (!$newTicketId) {
                http_response_code(500);
                echo json_encode(['error' => 'Failed to create ticket']);
                return;
            }

            //  Handle image upload if provided
            $imageUrl = $data['imageUrl'] ?? null; // Default/fallback image URL

            if (!empty($file) && $file['error'] === UPLOAD_ERR_OK) {
                // Validate image
                $validationError = $this->validateImage($file);
                if ($validationError) {
                    http_response_code(400);
                    echo json_encode(['error' => $validationError]);
                    return;
                }

                $fileTmpPath = $file['tmp_name'];

                // Create directory structure based on event ID
                $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);
                $originalFileName = pathinfo($file['name'], PATHINFO_FILENAME);
                $sanitizedFileName = preg_replace('/[^a-zA-Z0-9\-_]/', '', $originalFileName);
                $fileName = $sanitizedFileName . '-' . uniqid() . '.' . $fileExtension;

                $localUploadPath = './uploads/' . $fileName;
                $ftpFilePath = "/ticket-images/" . $fileName; // Path: event-images/eventid/imagename

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
                    $imageUrl = $ftpFilePath; // Use FTP path as image URL
                    unlink($localUploadPath); // Remove local file after successful FTP upload

                    // Update the event with the image URL

                } else {
                    http_response_code(500);
                    echo json_encode(['error' => 'FTP upload failed']);
                    return;
                }
            }

            echo json_encode([
                "message" => "Ticket message created",
                "id" => $newTicketId
            ]);
        } else {
            // Handle JSON request (without file upload)
            echo json_encode(['error' => 'Invalid JSON data']);
            return;
        }
    }
    public function updateStatus($id)
    {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['newStatus'])) {
            echo json_encode(["error" => "New status is required"]);
            return;
        }
        $newStatus = $data['newStatus'];
        $this->model->updateStatus($id, $newStatus);
        echo json_encode(["message" => "Ticket status updated"]);
    }

    public function assignTicket($id)
    {
        $data = json_decode(file_get_contents("php://input"), true);

        // Validate required fields
        if (!isset($data['assignedTo']) || !isset($data['assigneeAvatar'])) {
            echo json_encode(["error" => "Assigned to and assignee avatar are required"]);
            return;
        }

        // Default optional fields
        $isLocked = isset($data['isLocked']) ? (int)$data['isLocked'] : 0;
        $lockedBy = $data['lockedByStaffId'] ?? null;

        // Assign ticket
        $this->model->assignTicket($id, $data['assignedTo'], $data['assigneeAvatar'], $lockedBy, $isLocked);

        // Return full ticket details
        $ticket = $this->model->getById($id);
        if ($ticket) {
            echo json_encode($ticket);
        } else {
            http_response_code(404);
            echo json_encode(["error" => "Ticket not found"]);
        }
    }

    public function unlockTicket($id)
    {
        $this->model->unlockTicket($id);

        $ticket = $this->model->getById($id);
        if ($ticket) {
            echo json_encode($ticket);
        } else {
            http_response_code(404);
            echo json_encode(["error" => "Ticket not found"]);
        }
    }


    public function delete($id)
    {
        $this->model->delete($id);
        echo json_encode(["message" => "Ticket deleted"]);
    }

    // public function assignTicket($id)
    // {
    //     // Decode the incoming JSON request body
    //     $data = json_decode(file_get_contents("php://input"), true);

    //     // Merge the ticket ID into the data array (if not already included)
    //     $data['id'] = $id;

    //     // Assign the ticket using the model
    //     $this->model->assignToStaff($data);

    //     // Return a success response
    //     echo json_encode(["message" => "Ticket Assigned"]);
    // }
}