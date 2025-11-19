<?php
// server/index.php

// Include the database configuration
require_once __DIR__ . '/config/database.php';

// Get the requested URI and method
$request_uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

// Load the routes
$routes = require_once __DIR__ . '/routes/web.php';

// Route the request
$found_route = false;
foreach ($routes as $route => $handler) {
    list($route_method, $route_pattern) = explode(' ', $route, 2);
    if ($method == $route_method) {
        if (preg_match('#^' . $route_pattern . '#', $request_uri, $matches)) {
            array_shift($matches); // remove the full match
            $handler(...$matches);
            $found_route = true;
            break;
        }
    }
}

// If no route was found, return a 404
if (!$found_route) {
    http_response_code(404);
    echo json_encode(["message" => "Not Found"]);
}
