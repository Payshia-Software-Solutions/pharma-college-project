<?php
class StudentCourseModel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Get all student courses
    public function getAll()
    {
        $stmt = $this->pdo->query("SELECT id, course_code, student_id, enrollment_key, created_at FROM student_course");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get a specific student course by ID
    public function getById($id)
    {
        $stmt = $this->pdo->prepare("SELECT id, course_code, student_id, enrollment_key, created_at FROM student_course WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Create a new student course
    public function create($course_code, $student_id, $enrollment_key)
    {
        $stmt = $this->pdo->prepare("INSERT INTO student_course (course_code, student_id, enrollment_key, created_at) VALUES (:course_code, :student_id, :enrollment_key, NOW())");
        $stmt->execute([
            ':course_code' => $course_code,
            ':student_id' => $student_id,
            ':enrollment_key' => $enrollment_key
        ]);
        return $this->pdo->lastInsertId();
    }

    // Update an existing student course
    public function update($id, $course_code, $student_id, $enrollment_key)
    {
        $stmt = $this->pdo->prepare("UPDATE student_course SET course_code = :course_code, student_id = :student_id, enrollment_key = :enrollment_key WHERE id = :id");
        $stmt->execute([
            ':id' => $id,
            ':course_code' => $course_code,
            ':student_id' => $student_id,
            ':enrollment_key' => $enrollment_key
        ]);
        return $stmt->rowCount();
    }

    // Delete a student course by ID
    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM student_course WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->rowCount();
    }
}
