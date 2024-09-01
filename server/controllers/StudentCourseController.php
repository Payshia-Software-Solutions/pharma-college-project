<?php

require_once './models/StudentCourse.php';
class StudentCourseController
{
    private $model;

    public function __construct($pdo)
    {
        $this->model = new StudentCourse($pdo);
    }

    public function getAllEnrollments()
    {
        $enrollments = $this->model->getAllEnrollments();
        echo json_encode($enrollments);
    }

    public function getEnrollmentById($id)
    {
        $enrollment = $this->model->getEnrollmentById($id);
        if ($enrollment) {
            echo json_encode($enrollment);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Enrollment not found']);
        }
    }

    public function createEnrollment()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $this->model->createEnrollment($data);
        http_response_code(201);
        echo json_encode(['message' => 'Enrollment created successfully']);
    }

    public function updateEnrollment($id)
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $this->model->updateEnrollment($id, $data);
        echo json_encode(['message' => 'Enrollment updated successfully']);
    }

    public function deleteEnrollment($id)
    {
        $this->model->deleteEnrollment($id);
        echo json_encode(['message' => 'Enrollment deleted successfully']);
    }
}
