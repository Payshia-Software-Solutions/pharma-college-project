<?php
// server/routes/ceylonPharmacy/careInsAnswerRoutes.php

require_once __DIR__ . '/../../controllers/ceylonPharmacy/CareInsAnswerController.php';

// Instantiate the controller
$pdo = $GLOBALS['pdo'];
$careInsAnswerController = new CareInsAnswerController($pdo);

// Define routes
return [
    // Get all answers
    'GET /care-ins-answers/$' => function () use ($careInsAnswerController) {
        $careInsAnswerController->getAll();
    },
    // Get answer by ID
    'GET /care-ins-answers/(\d+)/$' => function ($id) use ($careInsAnswerController) {
        $careInsAnswerController->getById($id);
    },
    // Create new answer
    'POST /care-ins-answers/$' => function () use ($careInsAnswerController) {
        $careInsAnswerController->create();
    },
    // Update answer
    'PUT /care-ins-answers/(\d+)/$' => function ($id) use ($careInsAnswerController) {
        $careInsAnswerController->update($id);
    },
    // Delete answer
    'DELETE /care-ins-answers/(\d+)/$' => function ($id) use ($careInsAnswerController) {
        $careInsAnswerController->delete($id);
    },
];
