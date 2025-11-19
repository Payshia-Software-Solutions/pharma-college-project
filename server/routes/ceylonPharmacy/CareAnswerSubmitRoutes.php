<?php
// routes/ceylonPharmacy/CareAnswerSubmitRoutes.php

require_once './controllers/ceylonPharmacy/CareAnswerSubmitController.php';

// Instantiate the controller
$pdo = $GLOBALS['pdo'];
$careAnswerSubmitController = new CareAnswerSubmitController($pdo);

// Define routes
return [
    // Get all care answer submissions
    'GET /care-answer-submits/$' => function () use ($careAnswerSubmitController) {
        $careAnswerSubmitController->getAll();
    },
    // Get care answer submission by ID
    'GET /care-answer-submits/(\d+)/$' => function ($id) use ($careAnswerSubmitController) {
        $careAnswerSubmitController->getById($id);
    },
    // Create new care answer submission
    'POST /care-answer-submits/$' => function () use ($careAnswerSubmitController) {
        $careAnswerSubmitController->create();
    },
    // Update care answer submission
    'PUT /care-answer-submits/(\d+)/$' => function ($id) use ($careAnswerSubmitController) {
        $careAnswerSubmitController->update($id);
    },
    // Delete care answer submission
    'DELETE /care-answer-submits/(\d+)/$' => function ($id) use ($careAnswerSubmitController) {
        $careAnswerSubmitController->delete($id);
    },
    // Submit an answer
    'POST /care-answer-submits/submit-answer/$' => function () use ($careAnswerSubmitController) {
        $careAnswerSubmitController->submitAnswer();
    },
];
