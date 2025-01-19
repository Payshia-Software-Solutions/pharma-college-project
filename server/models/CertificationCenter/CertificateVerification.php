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
            $indexnumber = $this->GetLmsStudentsByUserName($userName)['username'] ?? $userName;

            $sql = "SELECT * FROM `certificate_user_result` WHERE `index_number` = ? ORDER BY `id` DESC";
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

    public function getGradeDetails($userName)
    {
        try {
            // Get the index number (username in this case)
            $indexnumber = $this->GetLmsStudentsByUserName($userName)['username'] ?? $userName;
    
            // Query to fetch the result
            $sql = "SELECT `result`, `course_code` FROM `certificate_user_result` WHERE `index_number` = ? AND `title_id` = 'OverRAllGrade'";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$indexnumber]);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            // Check if any results were found
            if (empty($rows)) {
                return ["error" => "No result found for the given index number."];
            }
    
            // Use the first result (assuming one record per index number for OverRAllGrade)
            $row = $rows[0];
            $finalPercentage = $row['result'];
            $courseCode = $row['course_code'];
    
            $finalGrade = "Not Graded";
            $gradeResult = "Not Graded";
            $starCount = 0;
    
            // Determine the final grade
            if ($finalPercentage == "Not Graded") {
                $finalGrade = "Not Graded";
            } elseif ($finalPercentage >= 90) {
                $finalGrade = "A+";
            } elseif ($finalPercentage >= 80) {
                $finalGrade = "A";
            } elseif ($finalPercentage >= 75) {
                $finalGrade = "A-";
            } elseif ($finalPercentage >= 70) {
                $finalGrade = "B+";
            } elseif ($finalPercentage >= 65) {
                $finalGrade = "B";
            } elseif ($finalPercentage >= 60) {
                $finalGrade = "B-";
            } elseif ($finalPercentage >= 55) {
                $finalGrade = "C+";
            } elseif ($finalPercentage >= 45) {
                $finalGrade = "C";
            } elseif ($finalPercentage >= 40) {
                $finalGrade = "C-";
            } elseif ($finalPercentage >= 35) {
                $finalGrade = "D+";
            } elseif ($finalPercentage >= 30) {
                $finalGrade = "D";
            } else {
                $finalGrade = "E";
            }
    
            // Determine the grade result and star count
            if ($finalPercentage == "Not Graded") {
                $gradeResult = "Not Graded";
                $starCount = 0;
            } elseif ($finalPercentage >= 80) {
                $gradeResult = "Excellent";
                $starCount = 5;
            } elseif ($finalPercentage >= 75) {
                $gradeResult = "Good";
                $starCount = 4;
            } elseif ($finalPercentage >= 60) {
                $gradeResult = "Pretty Good";
                $starCount = 3;
            } elseif ($finalPercentage >= 40) {
                $gradeResult = "Poor";
                $starCount = 2;
            } else {
                $gradeResult = "Weak";
                $starCount = 1;
            }
    
            // Return the grade details along with course code
            return [
                "finalGrade" => $finalGrade,
                "gradeResult" => $gradeResult,
                "starCount" => $starCount,
                "courseCode" => $courseCode,
            ];
        } catch (PDOException $e) {
            return ["error" => $e->getMessage()];
        }
    }
    

//     public function getGradeDetails($userName)
// {
//     try {
//         // Get the index number (username in this case)
//         $indexnumber = $this->GetLmsStudentsByUserName($userName)['username'] ?? $userName;

//         // Query to fetch the result along with the course code
//         $sql = "SELECT c.course_code, r.result 
//                 FROM certificate_user_result r
//                 INNER JOIN student_course c ON r.index_number = c.student_id
//                 WHERE r.index_number = ? AND r.title_id = 'OverRAllGrade'";
//         $stmt = $this->pdo->prepare($sql);
//         $stmt->execute([$indexnumber]); // Use $indexnumber here
//         $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

//         if (empty($rows)) {
//             return ["error" => "No result found for the given index number."];
//         }

//         // Get the first result
//         $row = $rows[0];

//         $finalPercentage = $row['result'];
//         $courseCode = $row['course_code']; // Get course code from the result
//         $finalGrade = "Not Graded";
//         $gradeResult = "Not Graded";
//         $starCount = 0;

//         // Determine the final grade
//         if ($finalPercentage == "Not Graded") {
//             $finalGrade = "Not Graded";
//         } elseif ($finalPercentage >= 90) {
//             $finalGrade = "A+";
//         } elseif ($finalPercentage >= 80) {
//             $finalGrade = "A";
//         } elseif ($finalPercentage >= 75) {
//             $finalGrade = "A-";
//         } elseif ($finalPercentage >= 70) {
//             $finalGrade = "B+";
//         } elseif ($finalPercentage >= 65) {
//             $finalGrade = "B";
//         } elseif ($finalPercentage >= 60) {
//             $finalGrade = "B-";
//         } elseif ($finalPercentage >= 55) {
//             $finalGrade = "C+";
//         } elseif ($finalPercentage >= 45) {
//             $finalGrade = "C";
//         } elseif ($finalPercentage >= 40) {
//             $finalGrade = "C-";
//         } elseif ($finalPercentage >= 35) {
//             $finalGrade = "D+";
//         } elseif ($finalPercentage >= 30) {
//             $finalGrade = "D";
//         } elseif ($finalPercentage >= 0) {
//             $finalGrade = "E";
//         }

//         // Determine the grade result and star count
//         if ($finalPercentage >= 80) {
//             $gradeResult = "Excellent";
//             $starCount = 5;
//         } elseif ($finalPercentage >= 75) {
//             $gradeResult = "Good";
//             $starCount = 4;
//         } elseif ($finalPercentage >= 60) {
//             $gradeResult = "Pretty Good";
//             $starCount = 3;
//         } elseif ($finalPercentage >= 40) {
//             $gradeResult = "Poor";
//             $starCount = 2;
//         } else {
//             $gradeResult = "Weak";
//             $starCount = 1;
//         }

//         // Adjust for "Not Graded" case
//         if ($finalGrade == "Not Graded") {
//             $gradeResult = "Not Graded";
//             $starCount = 0;
//         }

//         // Return the grade details and course code
//         return [
//             "courseCode" => $courseCode,
//             "finalGrade" => $finalGrade,
//             "gradeResult" => $gradeResult,
//             "starCount" => $starCount,
//         ];
//     } catch (PDOException $e) {
//         return ["error" => $e->getMessage()];
//     }
// }

    
    
}
