<?php
// routes/TempLmsUserRoutes.php

require_once './controllers/TempLmsUserController.php';

// Instantiate the controller
$pdo = $GLOBALS['pdo']; // Assuming $pdo is available in the global scope
$tempLmsUserController = new TempLmsUserController($pdo);

// Define an array of routes
return [
    // Get all users
    'GET /users/$' => function () use ($tempLmsUserController) {
        return $tempLmsUserController->getUsers();
    },

    // Get a single user by ID
    'GET /users/(\d+)/$' => function ($id) use ($tempLmsUserController) {
        return $tempLmsUserController->getUserById($id);
    },

    // Create a new user
    'POST /users/$' => function () use ($tempLmsUserController) {
        return $tempLmsUserController->createUser();
    },

    // Update an existing user
    'PUT /users/(\d+)/$' => function ($id) use ($tempLmsUserController) {
        return $tempLmsUserController->updateUser($id);
    },

    // Delete a user by ID
    'DELETE /users/(\d+)/$' => function ($id) use ($tempLmsUserController) {
        return $tempLmsUserController->deleteUser($id);
    },

    // Additional routes can be added here
];
