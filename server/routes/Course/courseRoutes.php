<?php
require_once './controllers/Course/CourseController.php';

// Instantiate the controller
$pdo = $GLOBALS['pdo'];
$courseController = new CourseController($pdo);

// Define routes
return [
    'GET /course/' => [$courseController, 'getAllRecords'],
    'GET /course/{id}/' => [$courseController, 'getRecordById'],
    'POST /course/' => [$courseController, 'createRecord'],
    'PUT /course/{id}/' => [$courseController, 'updateRecord'],
    'DELETE /course/{id}/' => [$courseController, 'deleteRecord'],
];