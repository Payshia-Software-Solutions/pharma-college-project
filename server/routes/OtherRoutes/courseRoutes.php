<?php
// routes/courseRoutes.php

require_once './controllers/CourseController.php';

// Instantiate the controller
$pdo = $GLOBALS['pdo'];
$courseController = new CourseController($pdo);

// Define course routes
return [
    'GET /courses/' => [$courseController, 'getAllCourses'],
    'GET /courses/{id}/' => [$courseController, 'getCourseById'],
    'GET /courses/courseCode/' => [$courseController, 'getAllCourses'],
    'GET /courses/courseCode/{course_code}/' => [$courseController, 'getCourseByCourseCode'],
    'POST /courses/' => [$courseController, 'createCourse'],
    'PUT /courses/{id}/' => [$courseController, 'updateCourse'],
    'DELETE /courses/{id}/' => [$courseController, 'deleteCourse']
];
