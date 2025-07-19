<?php

class StudentCourse
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Get all records
    public function getAllRecords()
    {
        $stmt = $this->pdo->query("SELECT * FROM student_course");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get a single record by ID
    public function getRecordById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM student_course WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Get LMS student details by username
    public function getLmsStudentByUsername($userName = null)
    {
        $query = "
        SELECT 
            sc.id AS student_course_id,
            sc.course_code,
            sc.student_id,
            sc.enrollment_key,
            sc.created_at,
            sc.updated_at,
            
            ufd.id AS user_id,
            ufd.username,
            ufd.civil_status,
            ufd.first_name,
            ufd.last_name,
            ufd.gender,
            ufd.address_line_1,
            ufd.address_line_2,
            ufd.city,
            ufd.district,
            ufd.postal_code,
            ufd.telephone_1,
            ufd.telephone_2,
            ufd.nic,
            ufd.e_mail,
            ufd.birth_day,
            ufd.updated_by,
            ufd.updated_at,
            ufd.full_name,
            ufd.name_with_initials,
            ufd.name_on_certificate
        FROM student_course sc
        INNER JOIN user_full_details ufd ON sc.student_id = ufd.student_id
    ";

        if ($userName) {
            // Adding filter based on username if provided
            $cleanUsername = rtrim($userName, "/");
            $query .= " WHERE ufd.username = :username";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute(['username' => $cleanUsername]);
        } else {
            // Otherwise, return all data
            $stmt = $this->pdo->query($query);
        }

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }




    // Create a new record
    public function createRecord($data)
    {
        $sql = "INSERT INTO student_course (course_code, student_id, enrollment_key) 
                VALUES (:course_code, :student_id, :enrollment_key)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
    }

    // Update an existing record by ID
    public function updateRecord($id, $data)
    {
        $data['id'] = $id;
        $sql = "UPDATE student_course SET 
                    course_code = :course_code,
                    student_id = :student_id,
                    enrollment_key = :enrollment_key
                WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
    }

    // Delete a record by ID
    public function deleteRecord($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM student_course WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }

    // Get records by course code
    public function getRecordsByCourseCode($courseCode)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM student_course WHERE course_code = :course_code");
        $stmt->execute(['course_code' => $courseCode]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get records by student ID
    public function getRecordsByStudentId($userName)
    {

        $studentId = $this->getLmsStudentByUsername($userName)['student_id'];
        $stmt = $this->pdo->prepare("SELECT * FROM student_course WHERE student_id = :student_id");
        $stmt->execute(['student_id' => $studentId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
