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
    public function create($data)
    {
        $stmt = $this->pdo->prepare("INSERT INTO tickets (subject, description, priority, status, created_at, student_name, student_avatar, assigned_to, assignee_avatar, is_locked, locked_by_staff_id) VALUES (?, ?, ?, ?, NOW(), ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$data['subject'], $data['description'], $data['priority'], $data['status'], $data['student_name'], $data['student_avatar'], $data['assigned_to'], $data['assignee_avatar'], $data['is_locked'], $data['locked_by_staff_id']]);
    }
    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM tickets WHERE id = ?");
        $stmt->execute([$id]);
    }

    public function assignToStaff($data)
    {
        $stmt = $this->pdo->prepare("UPDATE tickets SET 
        assigned_to = ?, 
        assignee_avatar = ?, 
        is_locked = ?, 
        locked_by_staff_id = ? 
        WHERE id = ?");

        $stmt->execute([
            $data['assigned_to'],
            $data['assignee_avatar'],
            $data['is_locked'],
            $data['locked_by_staff_id'],
            $data['id'] // ID of the ticket to update
        ]);
    }
}
