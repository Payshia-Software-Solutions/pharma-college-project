<?php

class CommunityPostReplyRatings
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllRecords()
    {
        $stmt = $this->pdo->query("
            SELECT 
                reply_id, 
                created_by, 
                ratings 
            FROM community_post_reply_ratings
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRecordById($reply_id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM community_post_reply_ratings WHERE reply_id = :reply_id");
        $stmt->execute(['reply_id' => $reply_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createRecord($data)
    {
        $sql = "INSERT INTO community_post_reply_ratings (reply_id, created_by, ratings) 
                VALUES (:reply_id, :created_by, :ratings)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
    }

    public function updateRecord($reply_id, $data)
    {
        $data['reply_id'] = $reply_id;
        $sql = "UPDATE community_post_reply_ratings SET 
                    created_by = :created_by,
                    ratings = :ratings
                WHERE reply_id = :reply_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
    }

    public function deleteRecord($reply_id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM community_post_reply_ratings WHERE reply_id = :reply_id");
        $stmt->execute(['reply_id' => $reply_id]);
    }
}