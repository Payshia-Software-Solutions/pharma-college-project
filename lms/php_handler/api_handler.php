<?php
function sendPostRequestWithBearerToken($api_url, $post_data, $bearer_token)
{
    // Validate input parameters if needed

    // Encode the data as JSON
    $json_data = json_encode($post_data);

    // Initialize cURL session
    $ch = curl_init($api_url);

    // Set cURL options for the POST request, including the "Authorization" header
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($json_data),
        'Authorization: Bearer ' . $bearer_token  // Add the Bearer token here
    ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Execute the cURL session and retrieve the response
    $response = curl_exec($ch);

    return $response;

    // Check for cURL errors
    if (curl_errno($ch)) {
        // Handle the error, don't terminate the script
        return "cURL Error: " . curl_error($ch);
    }

    // Check if the request was successful
    if ($response === false) {
        // Handle the error, don't terminate the script
        return "Failed to retrieve API data.";
    }

    // Check the HTTP status code
    $http_status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if ($http_status_code < 200 || $http_status_code >= 300) {
        // Handle the HTTP error, e.g., return the status code and response
        return "HTTP Error: {$http_status_code}\nResponse: " . $response;
    }

    // Decode the JSON response into a PHP array or object
    $data = json_decode($response, true); // Set the second argument to true for an associative array

    // Check if JSON decoding was successful
    if ($data === null) {
        // Handle the error, don't terminate the script
        return "Failed to parse JSON data from the API.";
    }

    return $data;
}



function validateToken($link, $token)
{
    $user_id = getUserIdFromToken($link, $token);
    if ($user_id) {
        return $user_id;
    }
    return null;
}


require __DIR__ . '/../vendor/autoload.php';

use \Firebase\JWT\JWT;
use \Firebase\JWT\Key; // Import the Key class

function getUserIdFromToken($token)
{
    // Your secret key used to sign and verify tokens
    $secretKey = "9135f35f51caadb092c3597af0df9d841e64cbc027d7a88af87a3310a5aac9af"; // Replace with your actual secret key

    try {
        // Create a Key instance
        $key = new Key($secretKey, 'HS256');

        // Verify and decode the token using the key
        $decoded = JWT::decode($token, $key, array('HS256'));

        // Extract the user ID from the decoded token
        $user_id = $decoded->user_id;

        return $user_id; // Return the user ID
    } catch (Exception $e) {
        // Handle token verification errors
        return $e->getMessage(); // Return the error message
        return null;
    }
}


function generateToken($userId)
{
    // Create a JSON Web Token (JWT) with user's ID and an expiration time
    $payload = array(
        "user_id" => $userId,
        "exp" => time() + 3600 * 24 // Token expires in 1 hour (adjust as needed)
    );

    // Your secret key to sign the token
    $secretKey = "9135f35f51caadb092c3597af0df9d841e64cbc027d7a88af87a3310a5aac9af";

    // Create the token
    $token = JWT::encode($payload, $secretKey, 'HS256');

    return $token;
}


function getBearerToken()
{
    $headers = getallheaders();
    if (isset($headers['Authorization'])) {
        $authHeader = $headers['Authorization'];
        if (strpos($authHeader, 'Bearer ') === 0) {
            return trim(substr($authHeader, 7));
        }
    }
    return null;
}
