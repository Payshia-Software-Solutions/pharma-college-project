<?php
require_once './controllers/Course/CourseModulesController.php';

// Instantiate the controller
$pdo = $GLOBALS['pdo'];
$courseModulesController = new CourseModulesController($pdo);

// Define routes
return [
    'GET /course-modules/' => [$courseModulesController, 'getAllModules'],
    'GET /course-modules/{id}/' => [$courseModulesController, 'getModuleById'],
    'GET /course-modules/active/' => [$courseModulesController, 'getActiveModules'],
    'GET /course-modules/course/{courseCode}/' => [$courseModulesController, 'getModulesByCourseCode'],
    'POST /course-modules/' => [$courseModulesController, 'createModule'],
    'PUT /course-modules/{id}/' => [$courseModulesController, 'updateModule'],
    'DELETE /course-modules/{id}/' => [$courseModulesController, 'deleteModule'],
];
