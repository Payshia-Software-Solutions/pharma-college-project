<?php
require_once __DIR__ . '/../models/MediMindMedicine.php';

class MediMindMedicineController
{
    private $model;

    public function __construct($pdo)
    {
        $this->model = new MediMindMedicine($pdo);
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

    public function create()
    {
        $data = $_POST; // Use $_POST to access form data
        $file = $_FILES['medicine_image']; // Access uploaded file

        // FTP configuration
        $ftp_server = "your_ftp_server";
        $ftp_user_name = "your_ftp_username";
        $ftp_user_pass = "your_ftp_password";
        $remote_file = "/public_html/your_project_folder/server/uploads/" . basename($file["name"]);

        // Set up basic connection
        $conn_id = ftp_connect($ftp_server);

        // Login with username and password
        $login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);

        // Upload the file
        if (ftp_put($conn_id, $remote_file, $file["tmp_name"], FTP_BINARY)) {
            // File uploaded successfully, now create the DB record
            $data['medicine_image_url'] = "/uploads/" . basename($file["name"]);
            $id = $this->model->create($data);
            http_response_code(201);
            echo json_encode(['id' => $id, 'message' => 'Record created successfully']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'FTP upload failed']);
        }

        // Close the connection
        ftp_close($conn_id);
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
