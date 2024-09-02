<?php

class StudentCourse
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllEnrollments()
    {
        $stmt = $this->pdo->query("SELECT * FROM student_course ORDER BY `id` DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllEnrollmentsByCourse($course_code)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM student_course WHERE course_code = :course_code");
        $stmt->execute(['course_code' => $course_code]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getEnrollmentById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM student_course WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createEnrollment($data)
    {
        $sql = "INSERT INTO student_course (course_code, student_id, enrollment_key, created_at) 
                VALUES (:course_code, :student_id, :enrollment_key, :created_at)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
    }

    public function updateEnrollment($id, $data)
    {
        $data['id'] = $id;
        $sql = "UPDATE student_course SET 
                    course_code = :course_code, 
                    student_id = :student_id, 
                    enrollment_key = :enrollment_key, 
                    created_at = :created_at
                WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
    }

    public function deleteEnrollment($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM student_course WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }
}
