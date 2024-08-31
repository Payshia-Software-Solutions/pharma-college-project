<?php
require_once './models/Course.php';

class CourseController
{
    private $model;

    public function __construct($pdo)
    {
        $this->model = new Course($pdo);
    }

    public function getAllCourses()
    {
        $courses = $this->model->getAllCourses();
        echo json_encode($courses);
    }

    public function getCourseById($id)
    {
        $course = $this->model->getCourseById($id);
        if ($course) {
            echo json_encode($course);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Course not found']);
        }
    }

    public function getCourseByCourseCode($course_code)
    {
        $course = $this->model->getCourseByCourseCode($course_code);
        if ($course) {
            echo json_encode($course);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Course not found']);
        }
    }

    public function createCourse()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $this->model->createCourse($data);
        http_response_code(201);
        echo json_encode(['message' => 'Course created successfully']);
    }

    public function updateCourse($id)
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $this->model->updateCourse($id, $data);
        echo json_encode(['message' => 'Course updated successfully']);
    }

    public function deleteCourse($id)
    {
        $this->model->deleteCourse($id);
        echo json_encode(['message' => 'Course deleted successfully']);
    }
}
