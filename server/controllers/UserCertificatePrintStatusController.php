<?php

// controllers/CertificationCenter/UserCertificatePrintStatusController.php

require_once 'models/UserCertificatePrintStatus.php';

class UserCertificatePrintStatusController
{
    private $model;

    public function __construct($pdo)
    {
        $this->model = new UserCertificatePrintStatus($pdo);
    }

    public function getAllStatuses()
    {
        $statuses = $this->model->getAllStatuses();
        echo json_encode($statuses);
    }

    public function getStatusById($id)
    {
        $status = $this->model->getStatusById($id);
        if ($status) {
            echo json_encode($status);
        } else {
            echo json_encode(["error" => "Status not found"]);
        }
    }

    public function createStatus()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        $this->model->createStatus($data);
        http_response_code(201);
        echo json_encode(["message" => "Status created successfully"]);
    }

    public function updateStatus($id)
    {
        $data = json_decode(file_get_contents("php://input"), true);

        $this->model->updateStatus($id, $data);
        echo json_encode(["message" => "Status updated successfully"]);
    }

    public function deleteStatus($id)
    {
        $this->model->deleteStatus($id);
        echo json_encode(["message" => "Status deleted successfully"]);
    }
}
