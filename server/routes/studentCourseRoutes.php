<?php
// routes/appointmentRoutes.php

require_once './controllers/StudentCourseController.php';

// Instantiate the controller
$pdo = $GLOBALS['pdo'];
$appointmentController = new AppointmentController($pdo);

// Define appointment routes
return [
    'GET /studentEnrollments' => [$studentCourseController, 'getCourses'],
    'POST /studentEnrollments' => [$studentCourseController, 'createCourse'],
    'GET /studentEnrollments/{id}' => [$studentCourseController, 'getCourse'],
    'PUT /studentEnrollments/{id}' => [$studentCourseController, 'updateCourse'],
    'DELETE /studentEnrollments/{id}' => [$studentCourseController, 'deleteCourse']
];
