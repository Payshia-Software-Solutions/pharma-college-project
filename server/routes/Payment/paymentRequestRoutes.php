<?php
require_once './controllers/Payment/PaymentRequestController.php';

// Instantiate the controller
$pdo = $GLOBALS['pdo'];
$paymentRequestController = new PaymentRequestController($pdo);

// Define routes
return [
    'GET /payment-request/' => [$paymentRequestController, 'getAllRecords'],
    'GET /payment-request/{id}/' => [$paymentRequestController, 'getRecordById'],
    'GET /payment-request/{created_by}/' => [$paymentRequestController, 'getRecordByUserName'],
    'POST /payment-request/' => [$paymentRequestController, 'createRecord'],
    'PUT /payment-request/{id}/' => [$paymentRequestController, 'updateRecord'],
    'DELETE /payment-request/{id}/' => [$paymentRequestController, 'deleteRecord']
];