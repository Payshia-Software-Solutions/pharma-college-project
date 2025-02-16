<?php
// routes/SMSRoutes.php

require_once './controllers/SMSController.php';

// Define the authorization token
$authToken = "2218|Ysh7ZLYM83rxJc4Reztir1OYD31UppbEmewtbK9p"; // Replace with your access token

// Instantiate the SMSController
$smsController = new SMSController($authToken);

// Define the routes
return [
    'POST /send-sms/$' => function () use ($smsController) {
        // Get JSON input from the request body
        $data = json_decode(file_get_contents('php://input'), true);

        // Validate input
        if (!isset($data['mobile'])) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'Mobile number is required']);
            return;
        }

        $mobile = $data['mobile'];
        $senderId = $data['senderId'] ?? 'Pharma C.';
        $message = $data['message'] ?? "Waiting..!";

        // Call the controller method
        $smsController->sendSMS($mobile, $senderId, $message);
    },
];
