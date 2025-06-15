<?php

// controllers/CertificationCenter/UserCertificatePrintStatusController.php

require_once 'models/UserCertificatePrintStatusNew.php';
require_once './controllers/ConvocationRegistrationController.php';

class UserCertificatePrintStatusControllerNew
{
    private $model;
    private $convocationRegistrationController;
    private $convocationTemplatePath;

    public function __construct($pdo, $convocationTemplatePath)
    {
        $this->model = new UserCertificatePrintStatusNew($pdo);
        $this->convocationRegistrationController = new ConvocationRegistrationController($pdo, $convocationTemplatePath);
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

    public function getStatusByCertificateId($certificate_id)
    {
        $status = $this->model->getStatusByCertificateId($certificate_id);
        if ($status) {
            echo json_encode($status);
        } else {
            echo json_encode(["error" => "Status not found"]);
        }
    }

    // controllers/CertificationCenter/UserCertificatePrintStatusController.php
    public function createStatus()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $parentCourseCode = $data['parentCourseCode'] ?? null;
        $reference_number = $data['referenceId'] ?? null;

        // The model now gives us the generated certificate_id
        $certificateId = $this->model->createStatus($data);
        if ($parentCourseCode) {
            // Update the convocation registration with the new certificate_id
            $this->convocationRegistrationController->model->updateCertificatePrintStatus($reference_number, "Generated");
            $this->convocationRegistrationController->model->updateAdvancedCertificatePrintStatus($reference_number, "Generated");
        }

        http_response_code(201);
        echo json_encode([
            "message"        => "Status created successfully",
            "certificate_id" => $certificateId
        ]);
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
