<?php
// routes/userFullDetailsRoutes.php

require_once './controllers/UserFullDetailsController.php';

// Instantiate the controller
$pdo = $GLOBALS['pdo'];
$userFullDetailsController = new UserFullDetailsController($pdo);

// Define user full details routes
return [
    'GET /userFullDetails/' => [$userFullDetailsController, 'getAllUsers'],
    'GET /user-full-details/{id}/' => [$userFullDetailsController, 'getUserById'],
    'POST /user-full-details/' => [$userFullDetailsController, 'createUser'],
    'PUT /user-full-details/{id}/' => [$userFullDetailsController, 'updateUser'],
    'DELETE /user-full-details/{id}/' => [$userFullDetailsController, 'deleteUser']
];
