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
       
    try {
             // Send DELETE request
            $response = $client->request('DELETE', $_ENV["SERVER_URL"] . '/community-knowledgebase/' . $postId);
      
        if ($response->getStatusCode() == 200) {
            $error = ['status' => 'success', 'message' => 'Topic deleted successfully.'];
        } else {
            $error = ['status' => 'error', 'message' => 'Failed to delete topic.'];
        }
    } catch (\Exception $e) {
        $error = ['status' => 'error', 'message' => 'Exception: ' . $e->getMessage()];
    }

    echo json_encode($error);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}