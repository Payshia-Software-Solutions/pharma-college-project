<?php

class Course
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllCourses()
    {
        $stmt = $this->pdo->query("SELECT * FROM course");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCourseById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM course WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getCourseByCourseCode($course_code)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM course WHERE course_code = :course_code");
        $stmt->execute(['course_code' => $course_code]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createCourse($data)
    {
        $sql = "INSERT INTO course (course_name, course_code, instructor_id, course_description, course_duration, course_fee, registration_fee, other, created_at, created_by, update_by, update_at, enroll_key, display, CertificateImagePath, course_img, certification, mini_description) 
                VALUES (:course_name, :course_code, :instructor_id, :course_description, :course_duration, :course_fee, :registration_fee, :other, :created_at, :created_by, :update_by, :update_at, :enroll_key, :display, :CertificateImagePath, :course_img, :certification, :mini_description)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
    }

    public function updateCourse($id, $data)
    {
        $data['id'] = $id;
        $sql = "UPDATE course SET 
                    course_name = :course_name, 
                    course_code = :course_code, 
                    instructor_id = :instructor_id, 
                    course_description = :course_description, 
                    course_duration = :course_duration, 
                    course_fee = :course_fee, 
                    registration_fee = :registration_fee, 
                    other = :other, 
                    created_at = :created_at, 
                    created_by = :created_by, 
                    update_by = :update_by, 
                    update_at = :update_at, 
                    enroll_key = :enroll_key, 
                    display = :display, 
                    CertificateImagePath = :CertificateImagePath, 
                    course_img = :course_img, 
                    certification = :certification, 
                    mini_description = :mini_description
                WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
    }

    public function deleteCourse($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM course WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }
}
