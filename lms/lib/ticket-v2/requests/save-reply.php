<?php
require_once '../../../vendor/autoload.php';

$senderId = $_POST['LoggedUser'];

use Symfony\Component\HttpClient\HttpClient;
//for use env file data
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../../../');
$dotenv->load();
$client = HttpClient::create();



$replyId = $_POST['replyId'];
$userLevel = $_POST['UserLevel'];
$indexNumber = $_POST['LoggedUser'];
$parentId = $_POST['ticketId'];
$ticketText = $_POST['ticketText'];

$statusMsg = $errorMsg = $insertValuesSQL = $errorUpload = $errorUploadType = '';

$isActive = 1;
// $saveResult = SaveTicketReply($replyId, $ticketId, $indexNumber, $ticketInfo, $isActive);


// Get Ticket by Ticket Id
$response = $client->request('GET', $_ENV["SERVER_URL"] . '/tickets/' . $parentId);
$ticketInfo = $response->toArray();
$ticketSubject = $ticketInfo['subject'];
$ticketDepartment = $ticketInfo['department'];
$relatedService = $ticketInfo['related_service'];
$attachmentList = '';

$toIndexNumber = 'Admin';
$readStatus = 'unread';



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
    'ticket' => $ticketText,
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
        'message' => 'Replied'
    ]);
} else {
    // Handle error
    echo json_encode([
        'status' => 'error',
        'message' => 'Failed to create appointment'
    ]);
}
