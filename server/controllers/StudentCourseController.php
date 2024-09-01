<?php
require_once './models/StudentCourseModel.php';

class StudentCourseController
{
    private $model;

    public function __construct($pdo)
    {
        $this->model = new StudentCourseModel($pdo);
    }

    // Handle GET /student_course
    public function getCourses()
    {
        $courses = $this->model->getAll();
        echo json_encode($courses);
    }

    // Handle GET /student_course/{id}
    public function getCourse($id)
    {
        $course = $this->model->getById($id);
        if ($course) {
            echo json_encode($course);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Course not found']);
        }
    }

    // Handle POST /student_course
    public function createCourse()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        if (isset($data['course_code'], $data['student_id'], $data['enrollment_key'])) {
            $id = $this->model->create($data['course_code'], $data['student_id'], $data['enrollment_key']);
            http_response_code(201);
            echo json_encode(['id' => $id]);
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid input']);
        }
    }

    // Handle PUT /student_course/{id}
    public function updateCourse($id)
    {
        $data = json_decode(file_get_contents('php://input'), true);
        if (isset($data['course_code'], $data['student_id'], $data['enrollment_key'])) {
            $rows = $this->model->update($id, $data['course_code'], $data['student_id'], $data['enrollment_key']);
            if ($rows > 0) {
                echo json_encode(['message' => 'Course updated']);
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'Course not found']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid input']);
        }
    }

    // Handle DELETE /student_course/{id}
    public function deleteCourse($id)
    {
        $rows = $this->model->delete($id);
        if ($rows > 0) {
            echo json_encode(['message' => 'Course deleted']);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Course not found']);
        }
    }
}
