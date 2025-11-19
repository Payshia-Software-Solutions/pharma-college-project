<?php
// routes/ceylonPharmacy/CareAnswerSubmitRoutes.php

require_once __DIR__ . '/../../controllers/ceylonPharmacy/CareAnswerSubmitController.php';

// Instantiate the controller
$pdo = $GLOBALS['pdo'];
$careAnswerSubmitController = new CareAnswerSubmitController($pdo);


// Define routes
return [
    // Get all care answer submits
    'GET /care-answer-submits$' => function () use ($careAnswerSubmitController) {
        $careAnswerSubmitController->getAll();
    },
    // Get care answer submit by ID
    'GET /care-answer-submits/(\d+)$' => function ($id) use ($careAnswerSubmitController) {
        $careAnswerSubmitController->getById($id);
    },
    // Create new care answer submit
    'POST /care-answer-submits$' => function () use ($careAnswerSubmitController) {
        $careAnswerSubmitController->create();
    },
    // Validate and create a new submission
    'POST /care-answer-submits/validate$' => function () use ($careAnswerSubmitController) {
        $careAnswerSubmitController->validateAndCreate();
    },
    // Update care answer submit
    'PUT /care-answer-submits/(\d+)$' => function ($id) use ($careAnswerSubmitController) {
        $careAnswerSubmitController->update($id);
    },
    // Delete care answer submit
    'DELETE /care-answer-submits/(\d+)$' => function ($id) use ($careAnswerSubmitController) {
        $careAnswerSubmitController->delete($id);
    },
];
