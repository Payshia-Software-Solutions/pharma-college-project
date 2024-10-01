<?php

class CommunityPostReply
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllRecords()
    {
        $stmt = $this->pdo->query("SELECT * FROM community_post_reply");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRecordById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM community_post_reply WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createRecord($data)
    {
        $sql = "INSERT INTO community_post_reply (post_id, reply_content, created_by, created_at, likes, dislikes, is_active) 
                VALUES (:post_id, :reply_content, :created_by, :created_at, :likes, :dislikes, :is_active)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
    }

    public function updateRecord($id, $data)
    {
        $data['id'] = $id;
        $sql = "UPDATE community_post_reply SET 
                    post_id = :post_id, 
                    reply_content = :reply_content, 
                    created_by = :created_by,
                    created_at = :created_at,
                    likes = :likes,
                    dislikes = :dislikes,
                    is_active = :is_active
                WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
    }

    public function deleteRecord($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM community_post_reply WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }
}