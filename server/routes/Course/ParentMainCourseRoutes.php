<?php
require_once './controllers/Course/ParentMainCourseController.php';

// Instantiate the controller
$pdo = $GLOBALS['pdo'];
$parentMainCourseController = new ParentMainCourseController($pdo);

// Define routes
return [
    // Retrieve all courses
    'GET /parent-main-course' => [$parentMainCourseController, 'getAllCourses'],

    // Retrieve a single course by slug
    'GET /parent-main-course/{slug}' => [$parentMainCourseController, 'getCourseBySlug'],

    // Retrieve all active courses
    'GET /parent-main-course/get/active' => [$parentMainCourseController, 'getActiveCourses'],

    // Count courses by mode (Free or Paid)
    'GET /parent-main-course/get/count-by-mode' => [$parentMainCourseController, 'countCoursesByMode'],

   // In routing file (assuming this is correct)
   'GET /parent-main-course/get/counts' => [$parentMainCourseController, 'countAllCourses'],



    // Retrieve courses by skill level
    'GET /parent-main-course/skill-level/{skill_level}' => [$parentMainCourseController, 'getCoursesBySkillLevel'],

    // Create a new course
    'POST /parent-main-course' => [$parentMainCourseController, 'createCourse'],

    // Update an existing course by slug
    'PUT /parent-main-course/{slug}' => [$parentMainCourseController, 'updateCourse'],

    // Delete a course by slug
    'DELETE /parent-main-course/{slug}' => [$parentMainCourseController, 'deleteCourse'],

    // Delete a course by ID
    'DELETE /parent-main-course/{id}' => [$parentMainCourseController, 'deleteCourseById']
];
