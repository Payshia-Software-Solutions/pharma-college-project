<?php

require_once './models/Users/TempLmsUser.php';

class TempLmsUserController
{
    private $model;

    public function __construct($pdo)
    {
        $this->model = new TempLmsUser($pdo);
    }

    // Get count of all users
    public function countUsers()
    {
        $count = $this->model->countUsers();
        echo json_encode(['user_count' => $count]);
    }

    // Get all users
    public function getAllUsers()
    {
        $users = $this->model->getAllUsers();
        echo json_encode($users);
    }

    // Get a user by ID
    public function getUserById($id)
    {
        $user = $this->model->getUserById($id);
        if ($user) {
            echo json_encode($user);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'User not found']);
        }
    }

    // Create a new user
    public function createUser()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        try {
            $this->model->createUser($data);
            http_response_code(201);
            echo json_encode(['message' => 'User created successfully']);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(['error' => 'Failed to create user', 'details' => $e->getMessage()]);
        }
    }

    // Update a user by ID
    public function updateUser($id)
    {
        $data = json_decode(file_get_contents("php://input"), true);
        try {
            $this->model->updateUser($id, $data);
            echo json_encode(['message' => 'User updated successfully']);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(['error' => 'Failed to update user', 'details' => $e->getMessage()]);
        }
    }

    // Delete a user by ID
    public function deleteUser($id)
    {
        try {
            $this->model->deleteUser($id);
            echo json_encode(['message' => 'User deleted successfully']);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(['error' => 'Failed to delete user', 'details' => $e->getMessage()]);
        }
    }

    // Get users by approval status
    public function getUsersByApprovalStatus($status)
    {
        $users = $this->model->getUsersByApprovalStatus($status);
        echo json_encode($users);
    }

    // Get users by selected course
    public function getUsersByCourse($course)
    {
        $users = $this->model->getUsersByCourse($course);
        echo json_encode($users);
    }
}
