<?php
// server/routes/Care/careInstructionRoutes.php

require_once __DIR__ . '/../../controllers/ceylonPharmacy/CareInstructionController.php';

// Instantiate the controller
$pdo = $GLOBALS['pdo'];
$careInstructionController = new CareInstructionController($pdo);

// Define routes
return [
    // Get all care instructions
    'GET /updated-care-instructions/$' => function () use ($careInstructionController) {
        $careInstructionController->getAll();
    },
    // Get care instruction by ID
    'GET /updated-care-instructions/(\d+)/$' => function ($id) use ($careInstructionController) {
        $careInstructionController->getById($id);
    },
    // Create new care instruction
    'POST /updated-care-instructions/$' => function () use ($careInstructionController) {
        $careInstructionController->create();
    },
    // Update care instruction
    'PUT /updated-care-instructions/(\d+)/$' => function ($id) use ($careInstructionController) {
        $careInstructionController->update($id);
    },
    // Delete care instruction
    'DELETE /updated-care-instructions/(\d+)/$' => function ($id) use ($careInstructionController) {
        $careInstructionController->delete($id);
    },
];
