<?php
class BnfChapter
{
    private $pdo;
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAll()
    {
        return $this->pdo->query("SELECT * FROM bnf_chapters ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM bnf_chapters WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $title = $data['title'] ?? null;

        $stmt = $this->pdo->prepare("INSERT INTO bnf_chapters (title) VALUES (?)");
        $stmt->execute([$title]);
    }

    public function update($id, $data)
    {
        $title = $data['title'] ?? null;

        $stmt = $this->pdo->prepare("UPDATE bnf_chapters SET title = ? WHERE id = ?");
        $stmt->execute([$title, $id]);
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM bnf_chapters WHERE id = ?");
        $stmt->execute([$id]);
    }
}
