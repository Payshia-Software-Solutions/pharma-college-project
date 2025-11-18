<?php
// routes/ceylonPharmacy/CareCenterRecoveryRoutes.php

require_once './controllers/ceylonPharmacy/CareCenterRecoveryController.php';

// Instantiate the controller
$pdo = $GLOBALS['pdo'];
$careCenterRecoveryController = new CareCenterRecoveryController($pdo);

// Define routes
return [
    'GET /care-center-recoveries' => [$careCenterRecoveryController, 'getAll'],
    'GET /care-center-recoveries/{id}' => [$careCenterRecoveryController, 'getById'],
    'POST /care-center-recoveries' => [$careCenterRecoveryController, 'create'],
    'PUT /care-center-recoveries/{id}' => [$careCenterRecoveryController, 'update'],
    'DELETE /care-center-recoveries/{id}' => [$careCenterRecoveryController, 'delete']
];
