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

    // Get Levels by Course Code
    'GET /win_pharma/get-levels\?CourseCode=[\w]+/$' => function () use ($WinPharmaSubmissionController) {
        $CourseCode = isset($_GET['CourseCode']) ? $_GET['CourseCode'] : null;

        if (!$CourseCode) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing required parameter: CourseCode']);
            return;
        }

        return $WinPharmaSubmissionController->getLevels($CourseCode);
    },


    // Get Submission Level Count
    'GET /win_pharma_submission/get-submission-level-count\?UserName=[^&]+&batchCode=[^&]+$' => function () use ($WinPharmaSubmissionController) {
        $UserName = isset($_GET['UserName']) ? $_GET['UserName'] : null;
        $batchCode = isset($_GET['batchCode']) ? $_GET['batchCode'] : null;

        if (!$batchCode || !$UserName) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing required parameters. batchCode & UserName are required']);
            return;
        }

        return $WinPharmaSubmissionController->GetSubmissionLevelCount($UserName, $batchCode);
    },

    // Get WinPharma Results
    'GET /win_pharma_submission/get-results\?UserName=[\w]+&batchCode=[\w]+/$' => function () use ($WinPharmaSubmissionController) {
        return $WinPharmaSubmissionController->getWinPharmaResults();
    },
];
