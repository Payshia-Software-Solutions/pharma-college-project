<?php
require_once __DIR__ . '/../models/MediMindMedicine.php';

class MediMindMedicineController
{
    private $model;
    private $ftpConfig;

    public function __construct($pdo)
    {
        $this->model = new MediMindMedicine($pdo);
        $this->ftpConfig = include('./config/ftp.php');
    }

    public function getAll()
    {
        $records = $this->model->getAll();
        echo json_encode($records);
    }

    public function getById($id)
    {
        $record = $this->model->getById($id);
        if ($record) {
            echo json_encode($record);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Record not found']);
        }
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

    public function create()
    {
        $data = $_POST; // Use $_POST to access form data
        $file = $_FILES['medicine_image']; // Access uploaded file


         // Handle file upload
         if (!empty($_FILES['medicine_image']['tmp_name'])) {
            $fileTmpPath = $_FILES['medicine_image']['tmp_name'];

            // File details
            $fileExtension = pathinfo($_FILES['medicine_image']['name'], PATHINFO_EXTENSION);
            $fileName = uniqid() . '.' . $fileExtension;
            $localUploadPath = './uploads/' . $fileName; // Temporary local storage
            $ftpFilePath = "/medi_mind_images/" . $fileName; // Path on FTP

            // Ensure the local upload directory exists
            if (!is_dir('./uploads/')) {
                mkdir('./uploads/', 0777, true);
            }

            // Move the file locally first
            if (!move_uploaded_file($fileTmpPath, $localUploadPath)) {
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => 'File upload failed']);
                return;
            }

            // Upload to FTP server
            if ($this->uploadToFTP($localUploadPath, $ftpFilePath)) {
                unlink($localUploadPath); // Remove local file after successful FTP upload

                // File uploaded successfully, now create the DB record
                $data['medicine_image_url'] = $ftpFilePath;
                $id = $this->model->create($data);
                http_response_code(201);
                echo json_encode(['id' => $id, 'message' => 'Record created successfully']);


            } else {
                http_response_code(500);
                echo json_encode(['success' => false, 'error' => 'FTP upload failed']);
                return;
            }
        }

      
    }

    public function update($id)
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $this->model->update($id, $data);
        echo json_encode(['message' => 'Record updated successfully']);
    }

    public function delete($id)
    {
        $this->model->delete($id);
        echo json_encode(['message' => 'Record deleted successfully']);
    }
}
