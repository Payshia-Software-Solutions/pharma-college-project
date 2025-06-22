<?php

class Ticket
{
    private $pdo;
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }
    public function getAll()
    {
        return $this->pdo->query("SELECT * FROM tickets ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM tickets WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function create(array $data): void
    {
        $sql = "
        INSERT INTO tickets (
            subject, description, priority, status, created_at,
            student_name, student_avatar, assigned_to,
            assignee_avatar, is_locked, locked_by_staff_id
        )
        VALUES (
            ?, ?, ?, ?, NOW(),
            ?, ?, ?, ?, ?, ?
        )";

        $stmt = $this->pdo->prepare($sql);

        // Use ?? null so any missing key becomes NULL
        $stmt->execute([
            $data['subject']            ?? null,
            $data['description']        ?? null,
            $data['priority']           ?? null,
            $data['status']             ?? null,
            $data['student_name']       ?? null,
            $data['student_avatar']     ?? null,
            $data['assigned_to']        ?? null,
            $data['assignee_avatar']    ?? null,
            $data['is_locked']          ?? 0,
            $data['locked_by_staff_id'] ?? null,
        ]);
    }
    public function updateStatus($ticketId, $newStatus)
    {
        $stmt = $this->pdo->prepare("UPDATE tickets SET status = ?, updated_at = NOW() WHERE id = ?");
        $stmt->execute([$newStatus, $ticketId]);
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM tickets WHERE id = ?");
        $stmt->execute([$id]);
    }
}