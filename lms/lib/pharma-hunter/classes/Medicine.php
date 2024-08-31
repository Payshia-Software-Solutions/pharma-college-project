<?php
// SaveAnswer.php
include_once 'SaveAnswer.php';
class Medicine extends SaveAnswer
{
    protected $db;
    protected $table_name = "hunter_medicine";
    protected $lastError;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function fetchNotDeletedAll()
    {
        try {
            $query = "SELECT * FROM " . $this->table_name . " WHERE `active_status` NOT LIKE 'Deleted' ORDER BY `id` DESC";
            $stmt = $this->db->prepare($query);
            $stmt->execute();

            $resultArray = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $resultArray[$row['id']] = $row["id"];
            }

            return $resultArray;
        } catch (PDOException $e) {
            $this->lastError = $e->getMessage();
            return [];
        }
    }
}
