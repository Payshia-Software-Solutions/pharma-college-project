<?php
// SaveAnswer.php
include_once 'SaveAnswer.php';
class MedicineStore extends SaveAnswer
{
    protected $db;
    protected $table_name = "hunter_store";
    protected $lastError;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function fetchByMedicineId($medicineId)
    {
        try {
            $query = "SELECT * FROM " . $this->table_name . " WHERE medicine_id = :medicine_id";
            $stmt = $this->db->prepare($query); // Use the PDO connection
            $stmt->bindParam(':medicine_id', $medicineId, PDO::PARAM_STR);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->lastError = $e->getMessage();
            return null;
        }
    }

    public function fetchAllStored()
    {
        try {
            $query = "SELECT * FROM " . $this->table_name;
            $stmt = $this->db->prepare($query);
            $stmt->execute();

            $resultArray = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $resultArray[$row['medicine_id']] = $row["medicine_id"];
            }

            return $resultArray;
        } catch (PDOException $e) {
            $this->lastError = $e->getMessage();
            return [];
        }
    }
}
