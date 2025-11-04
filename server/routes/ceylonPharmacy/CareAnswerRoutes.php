<?php
// routes/ceylonPharmacy/CareAnswerRoutes.php

require_once './controllers/ceylonPharmacy/CareAnswerController.php';

// Instantiate the controller
$pdo = $GLOBALS['pdo'];
$careAnswerController = new CareAnswerController($pdo);

// Define routes
return [
    'GET /care-answers' => [$careAnswerController, 'getAll'],
    'GET /care-answers/{id}' => [$careAnswerController, 'getById'],
    'POST /care-answers' => [$careAnswerController, 'create'],
    'PUT /care-answers/{id}' => [$careAnswerController, 'update'],
    'DELETE /care-answers/{id}' => [$careAnswerController, 'delete']
];
