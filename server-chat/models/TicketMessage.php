<?php
class TicketMessage
{
    private $pdo;
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }
    public function getAll()
    {
        $stmt = $this->pdo->query("SELECT * FROM ticket_messages ORDER BY created_at ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getByTicketId($ticketId)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM ticket_messages WHERE ticket_id = ? ORDER BY created_at ASC");
        $stmt->execute([$ticketId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function create($data)
    {
        $stmt = $this->pdo->prepare("INSERT INTO ticket_messages (ticket_id, from_role, text, time, created_at) VALUES (?, ?, ?, ?, NOW())");
        $stmt->execute([
            $data['ticket_id'],
            $data['from_role'],
            $data['text'],
            $data['time'],
        ]);

        // Get last inserted ID
        return $this->pdo->lastInsertId();
    }




    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM ticket_messages WHERE id = ?");
        $stmt->execute([$id]);
    }
}