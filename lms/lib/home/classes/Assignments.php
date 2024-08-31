<?php
include_once 'StudentGrade.php';
class Assignments extends StudentGrade
{
    protected $db;
    protected $table_name = "assignment";
    protected $lastError;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function fetchByCourseId($course_code)
    {
        try {
            $query = "SELECT * FROM " . $this->table_name . " WHERE `course_code` = :course_code";
            $stmt = $this->db->prepare($query); // Use the PDO connection
            $stmt->bindParam(':course_code', $course_code, PDO::PARAM_STR);
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
