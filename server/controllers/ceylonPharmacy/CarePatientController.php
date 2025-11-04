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
        return $this->carePatientModel->getAllCarePatients();
    }

    public function getById($id)
    {
        return $this->carePatientModel->getCarePatientById($id);
    }

    public function create($data)
    {
        return $this->carePatientModel->createCarePatient($data);
    }

    public function update($id, $data)
    {
        return $this->carePatientModel->updateCarePatient($id, $data);
    }

    public function delete($id)
    {
        return $this->carePatientModel->deleteCarePatient($id);
    }
}
