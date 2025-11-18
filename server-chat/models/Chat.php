<?php
class Chat
{
    private $pdo;
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }
    public function getAll()
    {
        return $this->pdo->query("SELECT * FROM chats ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM chats WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function getByUsername($user_name)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM chats WHERE user_name = ?");
        $stmt->execute([$user_name]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function create($data)
    {
        $user_name = $data['user_name'] ?? null;
        $user_avatar = $data['user_avatar'] ?? null;
        $last_message_preview = $data['last_message_preview'] ?? null;
        $last_message_time = $data['last_message_time'] ?? null;
        $unread_count = $data['unread_count'] ?? 0;

        $stmt = $this->pdo->prepare("
        INSERT INTO chats (user_name, user_avatar, last_message_preview, last_message_time, unread_count, created_at)
        VALUES (?, ?, ?, ?, ?, NOW())
    ");
        $stmt->execute([$user_name, $user_avatar, $last_message_preview, $last_message_time, $unread_count]);
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM chats WHERE id = ?");
        $stmt->execute([$id]);
    }
}
