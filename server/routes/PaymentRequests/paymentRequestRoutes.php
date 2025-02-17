<?php
// routes/Payments/paymentRequestRoutes.php

require_once './controllers/PaymentRequests/PaymentPortalRequestController.php';

// Instantiate the controller
$pdo = $GLOBALS['pdo'];
$paymentRequestController = new PaymentPortalRequestController($pdo);

// Define an array of routes
return [
    // Get all payment requests
    'GET /payment-portal-requests/$' => function () use ($paymentRequestController) {
        return $paymentRequestController->getAllRecords();
    },

    // Get a payment request by ID
    'GET /payment-portal-requests/(\d+)/$' => function ($id) use ($paymentRequestController) {
        return $paymentRequestController->getRecordById($id);
    },

    // Create a new payment request
    'POST /payment-portal-requests/$' => function () use ($paymentRequestController) {
        return $paymentRequestController->createRecord();
    },

    // Update a payment request by ID
    'PUT /payment-portal-requests/(\d+)/$' => function ($id) use ($paymentRequestController) {
        return $paymentRequestController->updateRecord($id);
    },

    // Delete a payment request by ID
    'DELETE /payment-portal-requests/(\d+)/$' => function ($id) use ($paymentRequestController) {
        return $paymentRequestController->deleteRecord($id);
    },
];
