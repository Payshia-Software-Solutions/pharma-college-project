<?php
class BnfListItem
{
    private $pdo;
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getByPageId($page_id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM bnf_page_list_items WHERE page_id = ? ORDER BY item_order ASC");
        $stmt->execute([$page_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $page_id = $data['page_id'] ?? null;
        $bold_text = $data['bold_text'] ?? null;
        $regular_text = $data['regular_text'] ?? null;
        $item_order = $data['item_order'] ?? 0;

        $stmt = $this->pdo->prepare("
            INSERT INTO bnf_page_list_items (page_id, bold_text, regular_text, item_order, created_at)
            VALUES (?, ?, ?, ?, NOW())
        ");
        $stmt->execute([$page_id, $bold_text, $regular_text, $item_order]);
    }

    public function update($id, $data)
    {
        $bold_text = $data['bold_text'] ?? null;
        $regular_text = $data['regular_text'] ?? null;
        $item_order = $data['item_order'] ?? 0;

        $stmt = $this->pdo->prepare("
            UPDATE bnf_page_list_items
            SET bold_text = ?, regular_text = ?, item_order = ?, updated_at = NOW()
            WHERE id = ?
        ");
        $stmt->execute([$bold_text, $regular_text, $item_order, $id]);
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM bnf_page_list_items WHERE id = ?");
        $stmt->execute([$id]);
    }
}
