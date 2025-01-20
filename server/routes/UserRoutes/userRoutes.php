<?php
// routes/userRoutes.php

require_once './controllers/UserController.php';

// Instantiate the controller
$pdo = $GLOBALS['pdo'];
$userController = new UserController($pdo);

// Define user routes
return [
    'GET /users' => [$userController, 'getUsers'],
    'POST /users' => [$userController, 'createUser'],
    'GET /users/{id}' => [$userController, 'getUser'],
    'GET /users/username/{username}' => [$userController, 'getUserByUsername'],
    'PUT /users/selectusername/{username}' => [$userController, 'updateUserPasswordByUsername'],

    'PUT /users/username/{username}' => [$userController, 'UpdateUserByUsername'],
    'PUT /users/{id}' => [$userController, 'updateUser'],
    'DELETE /users/{id}' => [$userController, 'deleteUser']
];
