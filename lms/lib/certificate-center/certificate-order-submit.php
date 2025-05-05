<?php

require '../../vendor/autoload.php';

use Dotenv\Dotenv;
use Symfony\Component\HttpClient\HttpClient;

// Load environment variables
$dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

// Create the HttpClient
$client = HttpClient::create();

$LoggedUser = $_POST['LoggedUser'];
$certificateId = $_POST['certificateId'];
$CourseCode = $_POST['CourseCode'];

// Get the form data
$formdata = $_POST;
$timeDate = date("Y-m-d H:i:s");



// Make the POST request to send the payment data along with the image
$response = $client->request('POST', $_ENV["SERVER_URL"] . '/cc_certificate_order', [
    'headers' => [
        'Content-Type' => 'application/json',
    ],
    'json' => [
        'created_by' => $LoggedUser,
        'created_at' => $timeDate,
        'updated_at' => $timeDate,
        'course_code' => $CourseCode,
        'mobile' => $formdata['mobile'],
        'address_line1' => $formdata['address_line1'],
        'address_line2' => $formdata['address_line2'],
        'city_id' => $formdata['city_id'],
        'type' => $formdata['type'],
        'payment' => $formdata['payment'],
        'package_id' => $formdata['package_id'],
        'certificate_id' => $certificateId,
        'certificate_status' => $formdata['certificate_status'],
        'cod_amount' => $formdata['cod_amount'],
        'is_active' => $formdata['is_active'],
    ]
]);

// Check for success response
$statusCode = $response->getStatusCode();
if ($statusCode == 201) {
    echo json_encode(['status' => 'success', 'message' => 'order submitted successfully.']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'order submission failed.']);
}
