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
    'DELETE /win_pharma_submission/{id}/' => [$WinPharmaSubmissionController, 'deleteWinPharmaSubmission']
];

?>