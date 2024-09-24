<?php
// routes/careInstructionRoutes.php

require_once './controllers/Care/CareInstructionController.php';

// Instantiate the controller
$pdo = $GLOBALS['pdo'];
$careInstructionController = new CareInstructionController($pdo);

// Define care instruction routes
return [
    'GET /care-instructions' => [$careInstructionController, 'getCareInstructions'],
    'POST /care-instructions' => [$careInstructionController, 'createCareInstruction'],
    'GET /care-instructions/{id}' => [$careInstructionController, 'getCareInstruction'],
    'PUT /care-instructions/{id}' => [$careInstructionController, 'updateCareInstruction'],
    'DELETE /care-instructions/{id}' => [$careInstructionController, 'deleteCareInstruction']
];