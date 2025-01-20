<?php
// models/User.php

class User
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllUsers()
    {
        $stmt = $this->pdo->query("SELECT * FROM users");
        return $stmt->fetchAll();
    }

    public function getUserById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function getByUsername($username)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch();
    }

    public function createUser($data)
    {
        $stmt = $this->pdo->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
        return $stmt->execute([$data['name'], $data['email']]);
    }

    public function updateUser($id, $data)
    {
        $stmt = $this->pdo->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
        return $stmt->execute([$data['name'], $data['email'], $id]);
    }

    public function updateUserPasswordByUsername($selectusername, $data)
    {
        // Only update the password field using the username to match
        $stmt = $this->pdo->prepare("UPDATE users SET password = ? WHERE username = ?");

        if (!$stmt) {
            // Log or print the error
            error_log("Prepare statement failed: " . implode(":", $this->pdo->errorInfo()));
            return false;
        }

        $result = $stmt->execute([$data['password'], $selectusername]);

        if (!$result) {
            // Log or print the error
            error_log("Execute statement failed: " . implode(":", $stmt->errorInfo()));
        }

        return $result;
    }


    public function updateUserByUsername($username, $data)
    {
        $stmt = $this->pdo->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
        return $stmt->execute([$data['name'], $data['email'], $username]);
    }



    public function deleteUser($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM users WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
