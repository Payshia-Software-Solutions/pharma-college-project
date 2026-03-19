<?php

require_once __DIR__ . '/../../controllers/MediMindStudentAnswerController.php';

// Instantiate the controller
$pdo = $GLOBALS['pdo'];
$controller = new MediMindStudentAnswerController($pdo);

// Define routes
return [
    'GET /medi-mind-student-answers/' => [$controller, 'getAll'],
    'GET /medi-mind-student-answers/{id}/' => [$controller, 'getById'],
    'GET /medi-mind-student-answers/student/{studentId}/' => [$controller, 'getByStudent'],
    'GET /medi-mind-student-answers/stats/{studentId}/' => [$controller, 'getStatsByStudent'],
    'POST /medi-mind-student-answers/' => [$controller, 'create'],
    'PUT /medi-mind-student-answers/{id}/' => [$controller, 'update'],
    'DELETE /medi-mind-student-answers/{id}/' => [$controller, 'delete'],
];
