<?php
// routes/StudentCourseRoutes.php

require_once './controllers/StudentCourseController.php';

// Instantiate the controller
$pdo = $GLOBALS['pdo'];
$studentCourseController = new StudentCourseController($pdo);

// Define an array of routes
return [
    // GET all student course enrollments with user details
    'GET /student-courses/$' => function () use ($studentCourseController) {
        return $studentCourseController->getAll();
    },

    // GET a single student course enrollment with user details by ID
    'GET /student-courses/(\d+)/$' => function ($id) use ($studentCourseController) {
        return $studentCourseController->getById($id);
    },

    // POST create a new student course enrollment
    'POST /student-courses/$' => function () use ($studentCourseController) {
        return $studentCourseController->create();
    },

    // PUT update a student course enrollment
    'PUT /student-courses/(\d+)/$' => function ($id) use ($studentCourseController) {
        return $studentCourseController->update($id);
    },

    // DELETE a student course enrollment
    'DELETE /student-courses/(\d+)/$' => function ($id) use ($studentCourseController) {
        return $studentCourseController->delete($id);
    },
];
