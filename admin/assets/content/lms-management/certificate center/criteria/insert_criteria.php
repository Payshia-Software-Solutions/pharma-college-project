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
    $requiredFields = ['list_name', 'moq', 'is_active', 'LoggedUser'];
    foreach ($requiredFields as $field) {
        if (empty($_POST[$field])) {
            echo json_encode(['status' => 'error', 'message' => "Missing required field: $field"]);
            exit;
        }
    }

    // Extract POST data
    $list_name = $_POST['list_name'];
    $moq = $_POST['moq'];
    $is_active = $_POST['is_active'];
    $LoggedUser = $_POST['LoggedUser'];
    $timeDate = date("Y-m-d H:i:s");

    // Correct the spelling of $response
    $response1 = $client->request('GET', $_ENV["SERVER_URL"] . '/cc_criteria_list/');
    $criteriaData = $response1->toArray(); // Convert JSON response to an associative array

    // Check if list_name exists in the fetched data
    $existingRecord = null; // Initialize to avoid undefined variable warnings
    foreach ($criteriaData as $record) {
        if ($record['list_name'] === $list_name) {
            $existingRecord = $record;
            break;
        }
    }

    // Handle existing record scenario
    if ($existingRecord) {
        echo json_encode(['status' => 'error', 'message' => 'Criteria with this name already exists.']);
        exit;
    }

    // Proceed with further logic if no record exists
    echo json_encode(['status' => 'success', 'message' => 'Criteria does not exist and can be added.']);
    exit;

    // Make the POST request to the server
    $response = $client->request('POST', $_ENV["SERVER_URL"] . '/cc_criteria_list/', [
        'headers' => [
            'Content-Type' => 'application/json',
        ],
        'json' => [
            'list_name' => $list_name,
            'moq' => $moq,
            'created_at' => $timeDate,
            'created_by' => $LoggedUser,
            'is_active' => $is_active,
        ],
    ]);

    // Check server response
    $statusCode = $response->getStatusCode();
    if ($statusCode == 200) {
        // Successfully created the criteria list
        echo json_encode([
            'status' => 'success',
            'message' => 'Criteria List created successfully.'
        ]);
    } else {
        // Failed to create the criteria list
        $serverResponse = $response->toArray(false); // Get raw response data
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to submit criteria.',
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
