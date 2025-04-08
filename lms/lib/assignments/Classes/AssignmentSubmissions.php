<?php
// AssignmentSubmissions.php
class AssignmentSubmissions extends Assignments
{
    protected $db;
    protected $table_name = "course_assignments_submissions";
    protected $lastError;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function fetchAllByAssignmentId($assignment_id)
    {
        try {
            $query = "SELECT * FROM " . $this->table_name . " WHERE assignment_id  = :assignment_id AND `is_active` LIKE 1";
            $stmt = $this->db->prepare($query); // Use the PDO connection
            $stmt->bindParam(':assignment_id', $assignment_id, PDO::PARAM_STR);
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

    public function fetchAllByAssignmentIdAndUser($assignment_id, $created_by)
    {
        try {
            $query = "SELECT * FROM " . $this->table_name . " WHERE assignment_id  = :assignment_id AND `is_active` LIKE 1 AND `created_by` LIKE :created_by";
            $stmt = $this->db->prepare($query); // Use the PDO connection
            $stmt->bindParam(':assignment_id', $assignment_id, PDO::PARAM_STR);
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

    public function fetchAllByAssignmentIdAndUserDeleted($assignment_id, $created_by)
    {
        try {
            $query = "SELECT * FROM " . $this->table_name . " WHERE assignment_id  = :assignment_id AND `is_active` LIKE 0 AND `created_by` LIKE :created_by";
            $stmt = $this->db->prepare($query); // Use the PDO connection
            $stmt->bindParam(':assignment_id', $assignment_id, PDO::PARAM_STR);
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
