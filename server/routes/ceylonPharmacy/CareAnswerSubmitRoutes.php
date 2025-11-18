<?php
// routes/ceylonPharmacy/CareAnswerSubmitRoutes.php

require_once './controllers/ceylonPharmacy/CareAnswerSubmitController.php';

// Instantiate the controller
$pdo = $GLOBALS['pdo'];
$careAnswerSubmitController = new CareAnswerSubmitController($pdo);

// Define routes
return [
    'GET /care-answer-submits' => [$careAnswerSubmitController, 'getAll'],
    'GET /care-answer-submits/{id}' => [$careAnswerSubmitController, 'getById'],
    'POST /care-answer-submits' => [$careAnswerSubmitController, 'create'],
    'PUT /care-answer-submits/{id}' => [$careAnswerSubmitController, 'update'],
    'DELETE /care-answer-submits/{id}' => [$careAnswerSubmitController, 'delete']
];
