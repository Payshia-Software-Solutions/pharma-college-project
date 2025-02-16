<?php
// routes/SMSRoutes.php

require_once './controllers/SMSController.php';

// Access environment variables
$authToken = $_ENV['SMS_AUTH_TOKEN'];
$senderId = $_ENV['SMS_SENDER_ID'];

// Define the path to the template file
$templatePath = __DIR__ . '/../templates/welcome_sms_template.txt';

// Instantiate the SMSController
$smsController = new SMSController($authToken, $senderId, $templatePath);

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

    'POST /send-welcome-sms/$' => function () use ($smsController) {
        // Get JSON input from the request body
        $data = json_decode(file_get_contents('php://input'), true);

        // Validate input
        if (!isset($data['mobile']) || !isset($data['studentName']) || !isset($data['referenceNumber'])) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'Mobile, studentName, and referenceNumber are required']);
            return;
        }

        // Call the controller method
        $smsController->sendWelcomeSMS($data['mobile'], $data['studentName'], $data['referenceNumber']);
    },
];
