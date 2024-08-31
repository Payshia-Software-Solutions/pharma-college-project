<?php
require_once '../../../../include/configuration.php';
include '../../../../php_handler/function_handler.php';
include '../../php_methods/d-pad-methods.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $postDataArray = $_POST;
    $result = SaveProductLInk($postDataArray);
} else {
    // Invalid request method
    http_response_code(405); // Method Not Allowed
    echo json_encode(['error' => 'Invalid request method']);
}
