<?php

require_once __DIR__ . '/../../controllers/MediMindAnswerController.php';

// Instantiate the controller
$pdo = $GLOBALS['pdo'];
$controller = new MediMindAnswerController($pdo);

// Define routes
return [
    'GET /medi-mind-answers/' => [$controller, 'getAll'],
    'GET /medi-mind-answers/{id}/' => [$controller, 'getById'],
    'GET /medi-mind-answers/medicine/{medicineId}/' => [$controller, 'getByMedicineId'],
    'POST /medi-mind-answers/' => [$controller, 'create'],
    'PUT /medi-mind-answers/{id}/' => [$controller, 'update'],
    'DELETE /medi-mind-answers/{id}/' => [$controller, 'delete'],
];
