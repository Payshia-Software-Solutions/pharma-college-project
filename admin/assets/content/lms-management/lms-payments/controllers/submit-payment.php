<?php
// Load dependencies
require_once '../../../../../vendor/autoload.php';
use Symfony\Component\HttpClient\HttpClient;

// Set up environment variables
$dotenv = Dotenv\Dotenv::createImmutable('../../../../../');
$dotenv->load();

// Define a mapping for reason descriptions to IDs
$reasonMapping = [
    'Course Fee' => 1,
    'Admission Fee' => 2,
    'Web Portal Fee' => 3,
    
];

// Get form data sent via POST
// Get form data sent via POST
$reason_description = $_POST['reason'] ?? null; // Store the reason description from POST
$reason = $reasonMapping[$reason_description] ?? null; // Map description to ID
$payment_request_id = $_POST['payment_request_id'] ?? null;
$paid_amount = $_POST['paid_amount'] ?? null;
$payment_type = $_POST['payment_type'] ?? null;
$created_by = $_POST['LoggedUser'] ?? null;
$course_code = $_POST['courseCode'] ?? null;
$student_name = $_POST['student_name'] ?? null;

// If any required data is missing, return an error
if (!$payment_request_id || !$paid_amount || !$payment_type || !$created_by || !$course_code || !$reason || !$student_name) {
    echo json_encode(['status' => 'fail', 'message' => 'Missing required data']);
    exit;
}

// Set additional data
$payment_status = "Paid";
$paid_date = date('Y-m-d');
$created_at = (new DateTime())->format("Y-m-d H:i:s.u");

// Set up the HttpClient and endpoint URL
$client = HttpClient::create();
$apiUrl = $_ENV["SERVER_URL"] . '/student-payment-with-status-update/';

// Send data to API endpoint
$response = $client->request('POST', $apiUrl, [
    'json' => [
        'payment_request_id' => $payment_request_id,
        'paid_amount' => $paid_amount,
        'payment_type' => $payment_type,
        'created_by' => $created_by,
        'course_code' => $course_code,
        'payment_status' => $payment_status,
        'paid_date' => $paid_date,
        'created_at' => $created_at,
        'reason' => $reason,
        'student_name' => $student_name
    ]
]);

// Get response status code and content for debugging
$status = $response->getStatusCode();
$content = $response->getContent(false); // Capture content for debugging, do not throw exception on error status

if ($status == 201) {
    echo json_encode(['status' => 'success', 'message' => 'Payment Successful']);
} else {
    echo json_encode(['status' => 'fail', 'message' => 'Request failed', 'error' => $content]);
}
?>