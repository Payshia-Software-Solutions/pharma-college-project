<?php

require '../../../vendor/autoload.php';

use Dotenv\Dotenv;
use Symfony\Component\HttpClient\HttpClient;

// Load environment variables
$dotenv = Dotenv::createImmutable(__DIR__ . '../../../../');
$dotenv->load();

// Create the HttpClient
$client = HttpClient::create();

// Get the form data
$paymentData = $_POST;
$image = $_FILES['image'];
$timeDate = date("Y-m-d H:i:s");

// Check if image is uploaded
if ($image['error'] === UPLOAD_ERR_OK) {
    // Get original file name and extension
    $originalFileName = basename($image['name']);
    $fileExtension = pathinfo($originalFileName, PATHINFO_EXTENSION);
    
    // Make the POST request to send the payment data along with the image
    $response = $client->request('POST', $_ENV["SERVER_URL"] . '/payment-request/', [
        'headers' => [
            'Content-Type' => 'multipart/form-data',
        ],
        'body' => [
            'created_by' => $paymentData['LoggedUser'],      // Send created_by
            'created_at' => $timeDate,                       // Send created_at
            'course_id' => $paymentData['CourseCode'],       // Send course_id
            'reason' => $paymentData['reason'],               // Send reason
            'extra_note' => $paymentData['extra_note'],      // Send extra_note
            'reference_number' => $paymentData['reference_number'], // Send reference_number
            
            // Include the original file name and the image file itself
            'original_filename' => $originalFileName,       
            'image' => fopen($image['tmp_name'], 'r'), 
        ]
    ]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Image upload error.']);
    exit;
}

// Check for success response
$statusCode = $response->getStatusCode();
if ($statusCode == 201) {
    echo json_encode(['status' => 'success', 'message' => 'Payment submitted successfully.']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Payment submission failed.']);
}