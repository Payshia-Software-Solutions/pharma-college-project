<?php
// controllers/CertificationCenter/CcCertificateListController.php

require_once './models/CertificationCenter/CcCertificateList.php';

class CcCertificateListController
{
    private $model;

    public function __construct($pdo)
    {
        $this->model = new CcCertificateList($pdo);
    }

    public function getCertificates()
    {
        $certificates = $this->model->getAllCertificates();
        echo json_encode($certificates);
    }

    public function getCertificate($id)
    {
        $certificate = $this->model->getCertificateById($id);
        echo json_encode($certificate);
    }

    public function createCertificate()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $this->model->createCertificate($data);
        echo json_encode(['status' => 'CcCertificateList created']);
    }

    public function updateCertificate($id)
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $this->model->updateCertificate($id, $data);
        echo json_encode(['status' => 'CcCertificateList updated']);
    }

    public function deleteCertificate($id)
    {
        $this->model->deleteCertificate($id);
        echo json_encode(['status' => 'CcCertificateList deleted']);
    }
}
