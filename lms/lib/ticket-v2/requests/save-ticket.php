<?php
require_once '../../../vendor/autoload.php';

$senderId = $_POST['LoggedUser'];

use Symfony\Component\HttpClient\HttpClient;
//for use env file data
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../../../');
$dotenv->load();
$client = HttpClient::create();



$userLevel = $_POST['UserLevel'];
$indexNumber = $_POST['LoggedUser'];
$courseCode = $_POST['defaultCourseCode']; // Course will be taken as Batch

$ticketSubject = $_POST['subject'];
$ticketDepartment = $_POST['department'];
$relatedService = $_POST['relatedService'];
$ticketInfo = $_POST['ticketText'];

$fileNames = array_filter($_FILES['files']['name']);
$ticketId = 0;
$targetDir = './../../../uploads/ticket_img/';
$allowTypes = array('jpg', 'png', 'jpeg', 'gif');

$statusMsg = $errorMsg = $insertValuesSQL = $errorUpload = $errorUploadType = '';

if (!empty($fileNames)) {
    foreach ($_FILES['files']['name'] as $key => $val) {
        // File upload path 
        $fileName = basename($_FILES['files']['name'][$key]);
        $targetFilePath = $targetDir . $fileName;

        // Check whether file type is valid 
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
        if (in_array($fileType, $allowTypes)) {
            // Upload file to server 
            if (move_uploaded_file($_FILES["files"]["tmp_name"][$key], $targetFilePath)) {
                $errorResult = "Upload Done";
            } else {
                $errorUpload .= $_FILES['files']['name'][$key] . ' | ';
            }
        } else {
            $errorUploadType .= $_FILES['files']['name'][$key] . ' | ';
        }
    }
} else {
    $statusMsg = 'Please select a file to upload.';
}

// Convert array to comma-separated string
$attachmentList = implode(", ", $fileNames);
$isActive = 1;
$toIndexNumber = 'Admin';
$readStatus = 'unread';
$parentId = 0;


// Define the API endpoint
$apiUrl = $_ENV["SERVER_URL"] . '/tickets/';

// Create an instance of Symfony's HTTP Client
$client = HttpClient::create();

// Define the data to send
$data = [
    'index_number' => $indexNumber,
    'subject' => $ticketSubject,
    'department' => $ticketDepartment,
    'related_service' => $relatedService,
    'ticket' => $ticketInfo,
    'attachments' => $attachmentList, // You can add file paths here if supported by the API
    'is_active' => $isActive,
    'to_index_number' => $toIndexNumber,
    'read_status' => $readStatus,
    'parent_id' => $parentId,
    'rating_value' => 0
];

// Send the POST request
$response = $client->request('POST', $apiUrl, [
    'json' => $data
]);

// Check the response from the POST request
if ($response->getStatusCode() == 201) {
    // If successful, return JSON response
    echo json_encode([
        'status' => 'success',
        'message' => 'Ticket Sent!'
    ]);
} else {
    // Handle error
    echo json_encode([
        'status' => 'error',
        'message' => 'Failed to create appointment'
    ]);
}
