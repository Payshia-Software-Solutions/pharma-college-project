<?php


// Set CORS headers for every response
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("X-Page-Title: API Service");
// Handle OPTIONS requests (preflight)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit();
}

ini_set('memory_limit', '256M');

// Report all PHP errors
error_reporting(E_ALL);

// Display errors in the browser (for development)
ini_set('display_errors', 1);
// routes/web.php

// Access environment variables
$authToken = $_ENV['SMS_AUTH_TOKEN'];
$senderId = $_ENV['SMS_SENDER_ID'];

// Define the path to the template file
$templatePath = __DIR__ . '/../templates/welcome_sms_template.txt';
$convocationTemplatePath = __DIR__ . '/../templates/convocation-payment-message.txt';

// Include route files
$SupportRoutes = require './routes/SupportRoutes.php';

// Combine all routes

$routes = array_merge(
    $SupportRoutes
);

// Define the home route with trailing slash
$routes['GET /'] = function () {
    // Serve the index.html file
    readfile('./views/index.html');
};

// Get request method and URI
$method = $_SERVER['REQUEST_METHOD'];
$uri = trim($_SERVER['REQUEST_URI'], '/');
// Strip 'api' prefix if present
if (str_starts_with($uri, 'api/')) {
    $uri = substr($uri, 4); // remove 'api/' prefix
}
// Ensure URI always has a trailing slash
if (substr($uri, -1) !== '/') {
    $uri .= '/';
}

// Determine if the application is running on localhost
if ($_SERVER['HTTP_HOST'] === 'localhost') {
    // Adjust URI if needed (only on localhost)
    $uri = str_replace('pharma-college-project/server-chat', '', $uri);
} else {
    // Adjust URI if needed (if using a subdirectory)
    $uri = '/' . $uri;
}



// Set the header for JSON responses, except for HTML pages
if ($uri !== '/') {
    header('Content-Type: application/json');
}

// Debugging
error_log("Method: $method");
error_log("URI: $uri");
// echo $uri . '<br>';


// Route matching
foreach ($routes as $route => $handler) {
    list($routeMethod, $routeUri) = explode(' ', $route, 2);

    // Convert route URI to regex (without query parameters){trackingNumber} student_number
    $routeRegex = str_replace(

        ['{id}', '{reply_id}', '{post_id}', '{created_by}', '{username}', '{role}', '{assignment_id}', '{course_code}', '{offset}', '{limit}', '{setting_name}', '{course_code}', '{loggedUser}', '{title_id}', '{slug}', '{module_code}', '{value}', '{course_code}', '{studentId}', '{tracking_number}', '{index_number}', '{provinceId}', '{student_number}'],
        ['(\d+)', '(\d+)', '(\d+)', '([a-zA-Z0-9_\-]+)', '([a-zA-Z0-9_\-]+)', '([a-zA-Z0-9_\-]+)', '([a-zA-Z0-9_\-]+)', '([a-zA-Z0-9_\-]+)', '(\d+)', '(\d+)', '([a-zA-Z0-9_\-]+)', '([a-zA-Z0-9_\-]+)', '([a-zA-Z0-9_\-]+)', '([a-zA-Z0-9_\-]+)', '([a-zA-Z0-9_\-]+)', '([a-zA-Z0-9_\-]+)', '([a-zA-Z0-9_\-]+)', '([a-zA-Z0-9_\-]+)', '([a-zA-Z0-9_\-\/]+)', '([a-zA-Z0-9_\-\/]+)', '([a-zA-Z0-9_\-\/]+)', '([a-zA-Z0-9_\-\/]+)', '([a-zA-Z0-9_\-\/]+)', '([a-zA-Z0-9_\-\/]+)',],


        $routeUri
    );

    // Ensure route regex matches the path only, not query parameters
    $routeRegex = "#^" . rtrim($routeRegex, '/') . "/?$#";

    // Debugging output
    // echo ("Checking route: $routeRegex <br>");
    // echo ("Uri : $uri<br>");

    // Check if the method and path match
    if ($method === $routeMethod && preg_match($routeRegex, $uri, $matches)) {

        header("X-Page-Title: API Service");
        // Remove the full match
        array_shift($matches);

        // Debugging output
        error_log("Route matched: $route");

        // Call the handler with matched parameters
        call_user_func_array($handler, $matches);
        exit;
    }
}

// Default 404 response if no match is found
header("HTTP/1.1 404 Not Found");
echo json_encode(['error' => 'Route not found']);
