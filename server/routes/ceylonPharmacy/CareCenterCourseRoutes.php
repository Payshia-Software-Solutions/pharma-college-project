<?php
// routes/ceylonPharmacy/CareCenterCourseRoutes.php

require_once './controllers/ceylonPharmacy/CareCenterCourseController.php';

// Instantiate the controller
$pdo = $GLOBALS['pdo'];
$careCenterCourseController = new CareCenterCourseController($pdo);

// Define routes
return [
    'GET /care-center-courses' => [$careCenterCourseController, 'getAll'],
    'GET /care-center-courses/{id}' => [$careCenterCourseController, 'getById'],
    'POST /care-center-courses' => [$careCenterCourseController, 'create'],
    'PUT /care-center-courses/{id}' => [$careCenterCourseController, 'update'],
    'DELETE /care-center-courses/{id}' => [$careCenterCourseController, 'delete'],
    'GET /care-center-courses/course/{courseCode}' => [$careCenterCourseController, 'getPrescriptionIdsByCourseCode']
];
