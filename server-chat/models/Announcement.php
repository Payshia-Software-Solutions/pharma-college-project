<?php
// --- models/Support/Announcement.php ---
class Announcement
{
    private $pdo;
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }
    public function getAll()
    {
        $stmt = $this->pdo->query("SELECT * FROM announcements ORDER BY date DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM announcements WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function create($data)
    {
        $stmt = $this->pdo->prepare("INSERT INTO announcements (title, content, date, author, category, is_new) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$data['title'], $data['content'], $data['date'], $data['author'], $data['category'], $data['is_new']]);
    }
    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM announcements WHERE id = ?");
        $stmt->execute([$id]);
    }
}
