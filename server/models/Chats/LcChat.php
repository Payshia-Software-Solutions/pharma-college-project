<?php
// models/Chat.php

class Chat
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllChats()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM `lc_chats`");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getChatById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM `lc_chats` WHERE `id` = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function getChatByUser($username)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM `lc_chats` WHERE `created_by` = ?");
        $stmt->execute([$username]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createChat($data)
    {
        $stmt = $this->pdo->prepare("INSERT INTO `lc_chats` (`name`, `created_by`) VALUES (?, ?)");
        $stmt->execute([$data['name'], $data['created_by']]);

        // Return the last inserted ID
        return $this->pdo->lastInsertId();
    }

    public function updateChat($id, $data)
    {
        $stmt = $this->pdo->prepare("UPDATE `lc_chats` SET `name` = ?, `created_by` = ? WHERE `id` = ?");
        $stmt->execute([$data['name'], $data['created_by'], $id]);
    }

    public function deleteChat($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM `lc_chats` WHERE `id` = ?");
        $stmt->execute([$id]);
    }
}
