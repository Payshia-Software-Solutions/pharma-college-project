<?php
include_once 'StudentGrade.php';
class AssignmentSubmissions extends StudentGrade
{
    protected $db;
    protected $table_name = "assignment_submittion";
    protected $lastError;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function fetchByStudentId($student_id)
    {
        try {
            $query = "SELECT * FROM " . $this->table_name . " WHERE `created_by` = :student_id";
            $stmt = $this->db->prepare($query); // Use the PDO connection
            $stmt->bindParam(':student_id', $student_id, PDO::PARAM_STR);
            $stmt->execute();

            $resultArray = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $resultArray[$row['assignment_id']] = $row;
            }
            return $resultArray;
        } catch (PDOException $e) {
            $this->lastError = $e->getMessage();
            return null;
        }
    }
}
