<?php
// routes/ceylonPharmacy/CarePaymentRoutes.php

require_once './controllers/ceylonPharmacy/CarePaymentController.php';

// Instantiate the controller
$pdo = $GLOBALS['pdo'];
$carePaymentController = new CarePaymentController($pdo);

// Define routes
return [
    'GET /care-payments' => [$carePaymentController, 'getAll'],
    'GET /care-payments/{id}' => [$carePaymentController, 'getById'],
    'POST /care-payments' => [$carePaymentController, 'create'],
    'PUT /care-payments/{id}' => [$carePaymentController, 'update'],
    'DELETE /care-payments/{id}' => [$carePaymentController, 'delete']
];
