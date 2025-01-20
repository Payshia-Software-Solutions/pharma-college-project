<?php
// routes/userFullDetailsRoutes.php

require_once './controllers/UserFullDetailsController.php';

// Instantiate the controller
$pdo = $GLOBALS['pdo'];
$userFullDetailsController = new UserFullDetailsController($pdo);

// Define user full details routes
return [
    'GET /user_full_details/' => [$userFullDetailsController, 'getAllUsers'],
    'GET /user_full_details/{id}/' => [$userFullDetailsController, 'getUserById'],
    'GET /user_full_details/username/{username}/' => [$userFullDetailsController, 'getUserByUserName'],
    'POST /user_full_details/' => [$userFullDetailsController, 'createUser'],
    'PUT /user_full_details/{id}/' => [$userFullDetailsController, 'updateUser'],
    'DELETE /user_full_details/{id}/' => [$userFullDetailsController, 'deleteUser']
];
