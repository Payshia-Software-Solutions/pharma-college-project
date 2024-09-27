<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require '../../../vendor/autoload.php';

use Dotenv\Dotenv;
use Symfony\Component\HttpClient\HttpClient;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../../../'); 
$dotenv->load();

$client = HttpClient::create();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $postId = $_POST['postId'];
    $postData = [
        'title' => $_POST['topic_title'],
        'user_account' => $_POST['loggedUser'] ,
        'submitted_time' => date("Y-m-d H:i:s"),
        'type' => 1,
        'category' => $_POST['topic_category'],
        'content' => $_POST['topicContent'],
        'current_status' => 1,
        'is_active' => 1,
        'views' => 0
    ];


    $responseMsg = 'created';

    try {
        if ($postId == 0) {
            // Send POST request
            $postResponse = $client->request('POST', $_ENV["SERVER_URL"] . '/community-knowledgebase/', [
                'json' => $postData
            ]);
        } else {
            // Send PUT request
            $postResponse = $client->request('PUT', $_ENV["SERVER_URL"] . '/community-knowledgebase/' . $postId, [
                'json' => $postData
            ]);
            $responseMsg = 'updated';
        }

        if ($postResponse->getStatusCode() == 201) {
            $error = ['status' => 'success', 'message' => 'Topic ' . $responseMsg . ' successfully.'];
        } else {
            $error = ['status' => 'error', 'message' => 'Failed to save topic.'];
        }
    } catch (\Exception $e) {
        $error = ['status' => 'error', 'message' => 'Exception: ' . $e->getMessage()];
    }

    echo json_encode($error);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}