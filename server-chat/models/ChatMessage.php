<?php
class ChatMessage
{
    private $pdo;
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }
    public function getByChatId($chatId)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM chat_messages WHERE chat_id = ? ORDER BY created_at ASC");
        $stmt->execute([$chatId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function create($data)
    {
        $stmt = $this->pdo->prepare("INSERT INTO chat_messages (chat_id, from_role, text, time, avatar, attachment_type, attachment_url, attachment_name, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())");
        $stmt->execute([$data['chat_id'], $data['from_role'], $data['text'], $data['time'], $data['avatar'], $data['attachment_type'], $data['attachment_url'], $data['attachment_name']]);
    }
    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM chat_messages WHERE id = ?");
        $stmt->execute([$id]);
    }
}
