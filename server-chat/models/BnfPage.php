<?php
class BnfPage
{
    private $pdo;
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAll()
    {
        return $this->pdo->query("SELECT * FROM bnf_pages ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM bnf_pages WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByChapterId($chapterId)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM bnf_pages WHERE chapter_id = ? ORDER BY created_at DESC");
        $stmt->execute([$chapterId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $chapter_id = $data['chapter_id'];
        $title = $data['title'] ?? null;
        $index_words = $data['index_words'] ?? null;
        $left_heading = $data['left_content_heading'] ?? null;
        $left_paragraphs = json_encode($data['left_content_paragraphs'] ?? []);
        $left_subheading = $data['left_content_subheading'] ?? null;
        $right_list = json_encode($data['right_content_list'] ?? []);
        $right_note = $data['right_content_note'] ?? null;

        $stmt = $this->pdo->prepare("
            INSERT INTO bnf_pages (
                chapter_id, title, index_words, 
                left_content_heading, left_content_paragraphs, 
                left_content_subheading, right_content_list, right_content_note
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $chapter_id,
            $title,
            $index_words,
            $left_heading,
            $left_paragraphs,
            $left_subheading,
            $right_list,
            $right_note
        ]);
    }

    public function update($id, $data)
    {
        $title = $data['title'] ?? null;
        $index_words = $data['index_words'] ?? null;
        $left_heading = $data['left_content_heading'] ?? null;
        $left_paragraphs = json_encode($data['left_content_paragraphs'] ?? []);
        $left_subheading = $data['left_content_subheading'] ?? null;
        $right_list = json_encode($data['right_content_list'] ?? []);
        $right_note = $data['right_content_note'] ?? null;

        $stmt = $this->pdo->prepare("
            UPDATE bnf_pages SET
                title = ?, index_words = ?, left_content_heading = ?,
                left_content_paragraphs = ?, left_content_subheading = ?,
                right_content_list = ?, right_content_note = ?
            WHERE id = ?
        ");
        $stmt->execute([
            $title,
            $index_words,
            $left_heading,
            $left_paragraphs,
            $left_subheading,
            $right_list,
            $right_note,
            $id
        ]);
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM bnf_pages WHERE id = ?");
        $stmt->execute([$id]);
    }
}
