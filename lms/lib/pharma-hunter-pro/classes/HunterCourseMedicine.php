<?php
include_once 'HunterMedicine.php';
class HunterCourseMedicine extends HunterMedicine
{
    protected $table_name = "hp_course_medicine"; // Override table name if needed

    public function __construct($db)
    {
        parent::__construct($db); // Call the parent constructor to initialize $db
    }

    public function GetProMedicines($CourseCode)
    {
        try {
            $query = "SELECT * FROM " . $this->table_name . " WHERE `status` LIKE 'Active' AND `CourseCode` LIKE '$CourseCode'";
            $stmt = $this->db->prepare($query);
            $stmt->execute();

            $resultArray = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $resultArray[$row['MediID']] = $row["MediID"];
            }

            return $resultArray;
        } catch (PDOException $e) {
            $this->lastError = $e->getMessage();
            return [];
        }
    }
}
