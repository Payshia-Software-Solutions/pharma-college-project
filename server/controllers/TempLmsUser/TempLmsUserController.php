<?php
// controllers/TempLmsUserController.php

require_once './models/TempLmsUser.php';

class TempLmsUserController
{
    private $model;

    public function __construct($pdo)
    {
        $this->model = new TempLmsUser($pdo);
    }

    // Get all users
    public function getUsers()
    {
        $users = $this->model->getAllUsers();
        echo json_encode($users);
    }

    // Get a single user by ID
    public function getUserById($id)
    {
        $user = $this->model->getUserById($id);
        if ($user) {
            echo json_encode($user);
        } else {
            http_response_code(404);
            echo json_encode(['status' => 'User not found']);
        }
    }

    // Create a new user
    public function createUser()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        if ($data) {
            $userId = $this->model->createUser($data);
            echo json_encode(['status' => 'User created', 'id' => $userId]);
        } else {
            http_response_code(400);
            echo json_encode(['status' => 'Invalid input']);
        }
    }

    // Update an existing user
    public function updateUser($id)
    {
        $data = json_decode(file_get_contents('php://input'), true);
        if ($data) {
            $affectedRows = $this->model->updateUser($id, $data);
            if ($affectedRows > 0) {
                echo json_encode(['status' => 'User updated']);
            } else {
                http_response_code(404);
                echo json_encode(['status' => 'User not found']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['status' => 'Invalid input']);
        }
    }

    // Delete a user by ID
    public function deleteUser($id)
    {
        $affectedRows = $this->model->deleteUser($id);
        if ($affectedRows > 0) {
            echo json_encode(['status' => 'User deleted']);
        } else {
            http_response_code(404);
            echo json_encode(['status' => 'User not found']);
        }
    }
}
