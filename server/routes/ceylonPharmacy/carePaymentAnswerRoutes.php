<?php
// routes/ceylonPharmacy/carePaymentAnswerRoutes.php

require_once __DIR__ . '/../../controllers/ceylonPharmacy/CarePaymentAnswerController.php';

// Instantiate the controller
$pdo = $GLOBALS['pdo'];
$carePaymentAnswerController = new CarePaymentAnswerController($pdo);

// Define routes
return [
    'GET /care-payment-answers' => [$carePaymentAnswerController, 'getAll'],
    'GET /care-payment-answers/{id}' => [$carePaymentAnswerController, 'getById'],
    'POST /care-payment-answers' => [$carePaymentAnswerController, 'create'],
    'PUT /care-payment-answers/{id}' => [$carePaymentAnswerController, 'update'],
    'DELETE /care-payment-answers/{id}' => [$carePaymentAnswerController, 'delete']
];
