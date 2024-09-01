<?php
// routes/studentCourseRoutes.php

require_once './controllers/StudentCourseController.php';

// Instantiate the controller
$pdo = $GLOBALS['pdo'];
$studentCourseController = new StudentCourseController($pdo);

// Define student course routes
return [
    'GET /studentEnrollments/' => [$studentCourseController, 'getAllEnrollments'],
    'GET /studentEnrollments/{id}/' => [$studentCourseController, 'getEnrollmentById'],
    'POST /studentEnrollments/' => [$studentCourseController, 'createEnrollment'],
    'PUT /studentEnrollments/{id}/' => [$studentCourseController, 'updateEnrollment'],
    'DELETE /studentEnrollments/{id}/' => [$studentCourseController, 'deleteEnrollment']
];
