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
        // Get the data from the request body
        $data = json_decode(file_get_contents("php://input"), true);

        try {
            // Call the model to insert the new user and get the last inserted ID
            $userId = $this->model->createUser($data);

            // Return success response with the new user's ID
            http_response_code(201); // Created successfully
            echo json_encode(['message' => 'User created successfully', 'user_id' => $userId]);
        } catch (Exception $e) {
            // Handle error
            http_response_code(400); // Bad Request
            echo json_encode(['error' => 'Failed to create user', 'details' => $e->getMessage()]);
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
