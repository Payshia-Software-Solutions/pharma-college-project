<?php
// controllers/Winpharma/WinPharmaSubmissionController.php

require_once './models/Winpharma/WinPharmaSubmission.php';


class WinPharmaSubmissionController
{
    private $model;

    public function __construct($pdo)
    {
        $this->model = new WinPharmaSubmission($pdo);
    }

    public function getWinPharmaSubmissions()
    {
        $WinPharmaSubmissions = $this->model->getAllWinPharmaSubmissions();
        echo json_encode($WinPharmaSubmissions);
    }

    public function getWinPharmaSubmissionById($resource_id)
    {
        $WinPharmaSubmission = $this->model->getWinPharmaSubmissionById($resource_id);
        echo json_encode($WinPharmaSubmission);
    }

    public function GetSubmissionLevelCount($UserName, $batchCode)
    {
        $WinPharmaSubmissionCount = $this->model->GetSubmissionLevelCount($UserName, $batchCode);
        echo json_encode($WinPharmaSubmissionCount);
    }

    public function getLevels($batchCode)
    {
        $getWinpharmaLevels = $this->model->getLevels($batchCode);
        echo json_encode($getWinpharmaLevels);
    }

    public function createWinPharmaSubmission()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $this->model->createWinPharmaSubmission($data);
        echo json_encode(['status' => 'WinPharmaSubmission created']);
    }

    public function updateWinPharmaSubmission($id)
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $this->model->updateWinPharmaSubmission($id, $data);
        echo json_encode(['status' => 'WinPharmaSubmission updated']);
    }

    public function deleteWinPharmaSubmission($id)
    {
        $this->model->deleteWinPharmaSubmission($id);
        echo json_encode(['status' => 'WinPharmaSubmission deleted']);
    }
}
