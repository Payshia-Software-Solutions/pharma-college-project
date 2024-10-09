<?php
require '../../../vendor/autoload.php';

//for use env file data
use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__ . '../../../../');
$dotenv->load();

// echo json_encode(['message' => 'Record updated successfully']);


use Symfony\Component\HttpClient\HttpClient;

$client = HttpClient::create();

// Get POST data
$inputData = json_decode(file_get_contents('php://input'), true);
$replyId = $inputData['reply_id'];
$userId = $inputData['user_id'];
$rating = $inputData['ratings'];

// Prepare the data for the request
$payload = [
    'reply_id' => $replyId,
    'created_by' => $userId,
    'ratings' => $rating,
    'created_at' => date('Y-m-d H:i:s')
];

// Send request to API to update or create a new rating
$response = $client->request('POST', $_ENV["SERVER_URL"] . 'community-post-reply-ratings/', [
    'json' => $payload,
]);

// Handle the response
$statusCode = $response->getStatusCode();
$responseData = $response->toArray();

if ($statusCode === 200) {
    echo json_encode(['message' => 'Record updated successfully']);
} else {
    echo json_encode(['error' => 'Failed to update record', 'details' => $responseData]);
}
?>