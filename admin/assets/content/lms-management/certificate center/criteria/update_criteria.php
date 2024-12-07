<?php
require_once('../../../../../include/config.php');
include '../../../../../include/function-update.php';
include '../../../../../include/lms-functions.php';
require __DIR__ . '/../../../../../vendor/autoload.php';

use Dotenv\Dotenv;
use Symfony\Component\HttpClient\HttpClient;

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Load environment variables
$dotenv = Dotenv::createImmutable(dirname(__DIR__, 5)); // Go up 5 directories
$dotenv->load();

// Create the HttpClient
$client = HttpClient::create();

try {
    // Validate POST request
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
        exit;
    }

    // Validate required fields
    $requiredFields = ['list_name', 'moq', 'is_active', 'LoggedUser', 'criteria_id'];
    foreach ($requiredFields as $field) {
        if (empty($_POST[$field])) {
            echo json_encode(['status' => 'error', 'message' => "Missing required field: $field"]);
            exit;
        }
    }

    // Extract POST data
    $criteria_id = $_POST['criteria_id'];
    $list_name = $_POST['list_name'];
    $moq = $_POST['moq'];
    $is_active = $_POST['is_active'];
    $LoggedUser = $_POST['LoggedUser'];
    $timeDate = date("Y-m-d H:i:s");


    // Proceed with updating the record
    // Prepare data to be updated
    $updateData = [
        'list_name' => $list_name,
        'moq' => $moq,
        'is_active' => $is_active,
        'updated_at' => $timeDate,
        'updated_by' => $LoggedUser,
    ];

    // Send PUT request to update the criteria record
    $response = $client->request('PUT', $_ENV["SERVER_URL"] . "/cc_criteria_list/" . $criteria_id, [
        'headers' => [
            'Content-Type' => 'application/json',
        ],
        'json' => $updateData,
    ]);

    // Check server response
    $statusCode = $response->getStatusCode();
    if ($statusCode == 200) {
        // Successfully updated the criteria list
        echo json_encode([
            'status' => 'success',
            'message' => 'Criteria List updated successfully.'
        ]);
    } else {
        // Failed to update the criteria list
        $serverResponse = $response->toArray(false); // Get raw response data
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to update criteria.',
            'debug' => $serverResponse
        ]);
    }
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'An unexpected error occurred.',
        'debug' => $e->getMessage()
    ]);
}
