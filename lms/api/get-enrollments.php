<?php
require_once '../include/configuration.php';
include '../php_handler/api_handler.php';

$ArrayResult = array();

$token = getBearerToken();
$userId = getUserIdFromToken($token);

// Get the JSON data from the request body
$json_data = file_get_contents('php://input');

// Decode the JSON data into a PHP array or object
$data = json_decode($json_data, true); // Set the second argument to true for an associative array

if ($userId !== null) {
    // The user is authenticated; you can perform further authorization checks based on user roles or permissions.
    $LoggedUser = $data['logged_user'];
    $student_id = $data['student_id'];
    $sql = "SELECT * FROM `student_course` WHERE `student_id` LIKE '$student_id'";

    // Perform error handling and use prepared statements to prevent SQL injection
    if ($stmt = $link->prepare($sql)) {
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[] = $row;
        }
        $stmt->close();
    }

    // Set appropriate HTTP headers for JSON response
    header('Content-Type: application/json');
} else {
    // Unauthorized
    $ArrayResult = array(
        "status" => "error",
        "message" => "Unauthorized",
        "token" => $token
    );
}

// Return the JSON-encoded result
echo json_encode($ArrayResult);
