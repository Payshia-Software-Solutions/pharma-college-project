<?php
require_once 'Topics.php';
class Replies extends Topics
{
    protected $db;
    protected $table_name = "community_post_reply";
    protected $lastError;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function fetchAllByPost($post_id)
    {
        try {
            $query = "SELECT * FROM " . $this->table_name . " WHERE post_id = :post_id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':post_id', $post_id, PDO::PARAM_STR);
            $stmt->execute();

            $resultArray = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $resultArray[$row['id']] = $row;
            }

            return $resultArray;
        } catch (PDOException $e) {
            $this->lastError = $e->getMessage();
            return [];
        }
    }

    public function fetchAllByUser($created_by)
    {
        try {
            $query = "SELECT * FROM " . $this->table_name . " WHERE created_by = :created_by";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':created_by', $created_by, PDO::PARAM_STR);
            $stmt->execute();

            $resultArray = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $resultArray[$row['id']] = $row;
            }

            return $resultArray;
        } catch (PDOException $e) {
            $this->lastError = $e->getMessage();
            return [];
        }
    }
}
