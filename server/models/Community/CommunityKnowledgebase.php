<?php

class CommunityKnowledgebase
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllRecords()
    {
        $stmt = $this->pdo->query("SELECT * FROM community_knowledgebase");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRecordById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM community_knowledgebase WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createRecord($data)
    {
        $sql = "INSERT INTO community_knowledgebase (title, user_account, submitted_time, type, category, content, current_status, is_active, views) 
                VALUES (:title, :user_account, :submitted_time, :type, :category, :content, :current_status, :is_active, :views)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
    }

    public function updateRecord($id, $data)
    {
        $data['id'] = $id;
        $sql = "UPDATE community_knowledgebase SET 
                    title = :title, 
                    user_account = :user_account,
                    submitted_time = :submitted_time,
                    type = :type,
                    category = :category,
                    content = :content,
                    current_status = :current_status,
                    is_active = :is_active,
                    views = :views
                WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
    }

    public function deleteRecord($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM community_knowledgebase WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }
}