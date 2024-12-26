<?php
// controllers/UserController.php

require_once './models/User.php';

class UserController
{
    private $model;

    public function __construct($pdo)
    {
        $this->model = new User($pdo);
    }

    public function getUsers()
    {
        $users = $this->model->getAllUsers();
        echo json_encode($users);
    }

    public function getUser($id)
    {
        $user = $this->model->getUserById($id);
        echo json_encode($user);
    }

    public function getUserByUsername($username)
    {
        $user = $this->model->getByUsername($username);
        echo json_encode($user);
    }

    public function createUser()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $this->model->createUser($data);
        echo json_encode(['status' => 'User created']);
    }

    public function updateUser($id)
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $this->model->updateUser($id, $data);
        echo json_encode(['status' => 'User updated']);
    }

    public function UpdateUserByUsername($username)
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $this->model->updateUserByUsername($username, $data);
        echo json_encode(['status' => 'User updated']);
    }


    public function deleteUser($id)
    {
        $this->model->deleteUser($id);
        echo json_encode(['status' => 'User deleted']);
    }

    public function getUserCount()
    {
        $count = $this->model->getUserCount();
        echo json_encode(['user_count' => $count]);
    }
}
