<?php
// controllers/ceylonPharmacy/CarePatientController.php

require_once __DIR__ . '/../../models/ceylonPharmacy/CarePatient.php';

class CarePatientController
{
    private $carePatientModel;

    public function __construct($pdo)
    {
        $this->carePatientModel = new CarePatient($pdo);
    }

    public function getAll()
    {
        $patients = $this->carePatientModel->getAllCarePatients();
        echo json_encode($patients);
    }

    public function getById($id)
    {
        $patient = $this->carePatientModel->getCarePatientById($id);
        if ($patient) {
            echo json_encode($patient);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Patient not found']);
        }
    }

    public function create()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        if ($data) {
            $lastId = $this->carePatientModel->createCarePatient($data);
            http_response_code(201);
            echo json_encode([
                'message' => 'Patient created successfully',
                'id' => $lastId
            ]);
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid input']);
        }
    }

    public function update($id)
    {
        $data = json_decode(file_get_contents("php://input"), true);
        if ($data) {
            $this->carePatientModel->updateCarePatient($id, $data);
            echo json_encode(['message' => 'Patient updated successfully']);
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid input']);
        }
    }

    public function delete($id)
    {
        $this->carePatientModel->deleteCarePatient($id);
        echo json_encode(['message' => 'Patient deleted successfully']);
    }
}
