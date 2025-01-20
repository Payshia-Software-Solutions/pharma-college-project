<?php
require_once('../../../../include/config.php');
require __DIR__ . '/../../../../vendor/autoload.php';

use Dotenv\Dotenv;
use Symfony\Component\HttpClient\HttpClient;

// Load environment variables
$dotenv = Dotenv::createImmutable(dirname(__DIR__, 4));
$dotenv->load();

// Initialize HTTP client
$client = HttpClient::create();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selectedUsername = $_POST['selectedUserName'] ?? '';
    $newPassword = $_POST['new_password'] ?? '';
    $retypePassword = $_POST['retype_password'] ?? '';

    // Validate input
    if (empty($newPassword) || empty($retypePassword)) {
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
        exit;
    }

    if ($newPassword !== $retypePassword) {
        echo json_encode(['success' => false, 'message' => 'Passwords do not match.']);
        exit;
    }

    if (strlen($newPassword) < 6) {
        echo json_encode(['success' => false, 'message' => 'Password must be at least 6 characters long.']);
        exit;
    }

    // Hash the new password
    $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

    try {
        // Make a PUT request to update the user password
        $response = $client->request('PUT', $_ENV["SERVER_URL"] . '/users/selectusername/' . $selectedUsername, [
            'json' => [
                'password' => $hashedPassword,  // Only send the hashed password
            ],
        ]);

        $responseData = $response->toArray(false); // Convert response to associative array

        if (isset($responseData['status']) && $responseData['status'] === 'success') {
            echo json_encode(['success' => true, 'message' => 'Password updated successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update the password.']);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
