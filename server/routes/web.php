<?php
// routes/web.php

// Include route files
$userRoutes = require './routes/userRoutes.php';
$assignmentRoutes = require './routes/assignmentRoutes.php';
$appointmentRoutes = require './routes/appointmentRoutes.php';
$eCertificateRoutes = require './routes/eCertificateRoutes.php';
$courseAssignmentRoutes = require './routes/courseAssignmentRoutes.php';
$courseAssignmentSubmissionRoutes = require './routes/courseAssignmentSubmissionRoutes.php';
$hpSaveAnswerRoutes = require './routes/hpSaveAnswerRoutes.php';
$reportRoutes = require './routes/reportRoutes.php';
$courseRoutes = require './routes/courseRoutes.php';


// Combine all routes
$routes = array_merge($userRoutes, $assignmentRoutes, $appointmentRoutes, $eCertificateRoutes, $courseAssignmentRoutes, $courseAssignmentSubmissionRoutes, $hpSaveAnswerRoutes, $reportRoutes, $courseRoutes);

// Define the home route with trailing slash
$routes['GET /'] = function () {
    // Serve the index.html file
    readfile('./views/index.html');
};

// Get request method and URI
$method = $_SERVER['REQUEST_METHOD'];
$uri = trim($_SERVER['REQUEST_URI'], '/');

// Ensure URI always has a trailing slash
if (substr($uri, -1) !== '/') {
    $uri .= '/';
}

// Adjust URI if needed (if using a subdirectory)
$uri =  str_replace('pharmacollege/server', '', $uri);

// Set the header for JSON responses, except for HTML pages
if ($uri !== '/') {
    header('Content-Type: application/json');
}

// Debugging
error_log("Method: $method");
// echo ("URI: $uri");

// Route matching
foreach ($routes as $route => $handler) {
    list($routeMethod, $routeUri) = explode(' ', $route, 2);

    // Convert route URI to regex
    $routeRegex = str_replace(
        ['{id}', '{username}', '{assignment_id}', '{course_code}'],  // Replace placeholders
        ['(\d+)', '([a-zA-Z0-9_\-]+)', '([a-zA-Z0-9_\-]+)', '([a-zA-Z0-9_\-]+)'], // Allow alphanumeric, hyphens, underscores for username
        $routeUri
    );
    $routeRegex = "#^" . rtrim($routeRegex, '/') . "/?$#";

    error_log("Checking route: $routeRegex");

    if ($method === $routeMethod && preg_match($routeRegex, $uri, $matches)) {
        array_shift($matches); // Remove the full match
        error_log("Route matched: $route");
        call_user_func_array($handler, $matches);
        exit;
    }
}

// Default 404 response
header("HTTP/1.1 404 Not Found");
echo json_encode(['error' => 'Route not found']);
