<?php
// routes/careInstructionPreRoutes.php

require_once './controllers/Care/CareInstructionPreController.php';

// Instantiate the controller
$pdo = $GLOBALS['pdo'];
$careInstructionPreController = new CareInstructionPreController($pdo);

// Define care instruction routes
return [
    'GET /care-instructions-pre' => [$careInstructionPreController, 'getCareInstructions'],
    'POST /care-instructions-pre' => [$careInstructionPreController, 'createCareInstruction'],
    'GET /care-instructions-pre/{id}' => [$careInstructionPreController, 'getCareInstruction'],
    'PUT /care-instructions-pre/{id}' => [$careInstructionPreController, 'updateCareInstruction'],
    'DELETE /care-instructions-pre/{id}' => [$careInstructionPreController, 'deleteCareInstruction'],
    'GET /care-instructions-pre/role/{role}' => [$careInstructionPreController, 'getInstructionsByRole'],
];