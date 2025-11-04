<?php
// routes/ceylonPharmacy/CarePatientRoutes.php

require_once './controllers/ceylonPharmacy/CarePatientController.php';

// Instantiate the controller
$pdo = $GLOBALS['pdo'];
$carePatientController = new CarePatientController($pdo);

// Define routes
return [
    'GET /care-patients' => [$carePatientController, 'getAll'],
    'GET /care-patients/{id}' => [$carePatientController, 'getById'],
    'POST /care-patients' => [$carePatientController, 'create'],
    'PUT /care-patients/{id}' => [$carePatientController, 'update'],
    'DELETE /care-patients/{id}' => [$carePatientController, 'delete']
];
