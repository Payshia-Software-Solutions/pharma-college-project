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

    // Get WinPharma Results
    public function getWinPharmaResults()
    {
        $UserName = isset($_GET['UserName']) ? $_GET['UserName'] : null;
        $batchCode = isset($_GET['batchCode']) ? $_GET['batchCode'] : null;

        if (!$UserName || !$batchCode) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing required parameters: UserName & batchCode']);
            return;
        }

        $results = $this->model->getWinPharmaResults($UserName, $batchCode);

        echo json_encode([
            'success' => true,
            'data' => $results
        ]);
    }
}
