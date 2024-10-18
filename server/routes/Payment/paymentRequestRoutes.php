<?php
require_once './controllers/Payment/PaymentRequestController.php';

// Instantiate the controller
$pdo = $GLOBALS['pdo'];
$paymentRequestController = new PaymentRequestController($pdo);

// Define routes
return [
    'GET /payment-request/' => [$paymentRequestController, 'getAllRecords'],
    'GET /payment-request/getById/{id}/' => [$paymentRequestController, 'getRecordById'],
    'GET /payment-request/getByUserName/{created_by}/' => [$paymentRequestController, 'getRecordByUserName'],
    'GET /payment-request/statics/' => [$paymentRequestController, 'getStatistics'],
    'POST /payment-request/' => [$paymentRequestController, 'createRecord'],
    'PUT /payment-request/{id}/' => [$paymentRequestController, 'updateRecord'],
    'DELETE /payment-request/{id}/' => [$paymentRequestController, 'deleteRecord']
    ];