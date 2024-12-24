<?php
require_once './models/Course/ParentMainCourse.php';

class ParentMainCourseController
{
    private $model;

    public function __construct($pdo)
    {
        $this->model = new ParentMainCourse($pdo);
    }

    // Get all course records
    public function getAllCourses()
    {
        $courses = $this->model->getAllCourses();
        echo json_encode($courses);
    }

    // Get a single course by slug
    public function getCourseBySlug($slug)
    {
        $course = $this->model->getCourseBySlug($slug);
        if ($course) {
            echo json_encode($course);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Course not found']);
        }
    }

    // Create a new course record
    public function createCourse()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $this->model->createCourse($data);
        http_response_code(201);
        echo json_encode(['message' => 'Course created successfully']);
    }

    // Update an existing course record by slug
    public function updateCourse($slug)
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $this->model->updateCourse($slug, $data);
        echo json_encode(['message' => 'Course updated successfully']);
    }

    // Delete a course record by slug
    public function deleteCourse($slug)
    {
        $this->model->deleteCourse($slug);
        echo json_encode(['message' => 'Course deleted successfully']);
    }

    // Delete a course record by ID
    public function deleteCourseById($id)
    {
        $deleted = $this->model->deleteCourseById($id);
        if ($deleted) {
            echo json_encode(['message' => 'Course deleted successfully']);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Course not found']);
        }
    }

    // Get all active courses
    public function getActiveCourses()
    {
        $activeCourses = $this->model->getActiveCourses();
        echo json_encode($activeCourses);
    }

    // Count courses by mode (Free or Paid)
    public function countCoursesByMode()
    {
        $courseCounts = $this->model->countCoursesByMode();
        echo json_encode($courseCounts);
    }

    // Get courses by skill level
    public function getCoursesBySkillLevel($skill_level)
    {
        $courses = $this->model->getCoursesBySkillLevel($skill_level);
        echo json_encode($courses);
    }
}
