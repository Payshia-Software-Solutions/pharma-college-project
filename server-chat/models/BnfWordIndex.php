<?php
class BnfWordIndex
{
    private $pdo;
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAll()
    {
        return $this->pdo->query("SELECT * FROM bnf_word_index ORDER BY word ASC")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByWord($word)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM bnf_word_index WHERE word = ?");
        $stmt->execute([$word]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $word = $data['word'] ?? null;
        $page_id = $data['page_id'] ?? null;

        $stmt = $this->pdo->prepare("INSERT INTO bnf_word_index (word, page_id) VALUES (?, ?)");
        $stmt->execute([$word, $page_id]);
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM bnf_word_index WHERE id = ?");
        $stmt->execute([$id]);
    }
}
