<?php
// routes/Winpharma/winPharmaSubmissionRoutes.php

require_once './controllers/Winpharma/WinPharmaSubmissionController.php';

// Instantiate the controller
$pdo = $GLOBALS['pdo'];
$WinPharmaSubmissionController = new WinPharmaSubmissionController($pdo);

// Define appointment routes
return [
    'GET /win_pharma_submission/' => [$WinPharmaSubmissionController, 'getWinPharmaSubmissions'],
    'GET /win_pharma_submission/{id}/' => [$WinPharmaSubmissionController, 'getWinPharmaSubmission'],
    'POST /win_pharma_submission/' => [$WinPharmaSubmissionController, 'createWinPharmaSubmission'],
    'PUT /win_pharma_submission/{id}/' => [$WinPharmaSubmissionController, 'updateWinPharmaSubmission'],
    'DELETE /win_pharma_submission/{id}/' => [$WinPharmaSubmissionController, 'deleteWinPharmaSubmission'],

    // Get Winpharma GetSubmissionLevelCount
    'GET /win_pharma_submission/get-submission-level-count\?UserName=[\d]+/$+&batchCode=[\w]+/$' => function () use ($WinPharmaSubmissionController) {
        $UserName = isset($_GET['UserName']) ? $_GET['UserName'] : null;
        $batchCode = isset($_GET['batchCode']) ? $_GET['batchCode'] : null;

        if (!$batchCode || !$UserName) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing required parameters. batchCode & UserName is required']);
            return;
        }

        return $WinPharmaSubmissionController->GetSubmissionLevelCount($UserName, $batchCode);
    },
];
