<?php

class CommunityPost
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllRecords()
    {
        $stmt = $this->pdo->query("SELECT * FROM community_post");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRecordById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM community_post WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createRecord($data)
    {
        // Set submitted_time to the current date and time
        $data['submitted_time'] = date('Y-m-d H:i:s'); // Format: YYYY-MM-DD HH:MM:SS
        
        $sql = "INSERT INTO community_post (title, user_account, submitted_time, type, category, content, current_status, is_active, views) 
                VALUES (:title, :user_account, :submitted_time, :type, :category, :content, :current_status, :is_active, :views)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
    }

    public function updateRecord($id, $data)
    {
        $data['id'] = $id;
        $sql = "UPDATE community_post SET 
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
        $stmt = $this->pdo->prepare("DELETE FROM community_post WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }
}