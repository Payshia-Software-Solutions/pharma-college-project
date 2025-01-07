<?php

class CertificateVerification
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

 


    public function GetLmsStudentsByUserName($userName)
    {
        $ArrayResult = [];
        try {
            global $link;
            $sql = "SELECT `id`, `student_id`, `username`, `civil_status`, `first_name`, `last_name`, `gender`, `address_line_1`, `address_line_2`, `city`, `district`, `postal_code`, `telephone_1`, `telephone_2`, `nic`, `e_mail`, `birth_day`, `updated_by`, `updated_at`, `full_name`, `name_with_initials`, `name_on_certificate` FROM `user_full_details` WHERE `username` LIKE ? ORDER BY `id` DESC";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$userName]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $ArrayResult[$row['username']] = $row;
        } catch (PDOException $e) {
            return ["error" => $e->getMessage()];
        }

        return $ArrayResult[$userName] ?? null;
    }

    public function getUserEnrollments($userName)
    {
        $ArrayResult = [];
        try {
            $studentId = $this->GetLmsStudentsByUserName($userName)['student_id'];
            $sql = "SELECT `id`, `course_code`, `student_id`, `enrollment_key`, `created_at` FROM `student_course` WHERE `student_id` LIKE ? ORDER BY `id` DESC";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$studentId]);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($rows as $row) {
                $ArrayResult[] = $row;
            }
        } catch (PDOException $e) {
            return ["error" => $e->getMessage()];
        }

        return $ArrayResult;
    }


    public function GetResultByUserName($userName)
    {
        $ArrayResult = [];
        try {

    
            // Use 'username' as 'index_number' if it doesn't exist
            $indexnumber = $studentDetails['index_number'] ?? $userName;
    
            // Query certificate_user_result table using the determined index number
            $sql = "SELECT * FROM `certificate_user_result` WHERE `index_number` = ?  ORDER BY `id` DESC";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$indexnumber]);
            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            if ($row) {
                $ArrayResult[$userName] = $row;
            } else {
                return ["error" => "No results found for the index number: " . $indexnumber];
            }
        } catch (PDOException $e) {
            return ["error" => $e->getMessage()];
        }
    
        return $ArrayResult[$userName] ?? null;
    }
    


}