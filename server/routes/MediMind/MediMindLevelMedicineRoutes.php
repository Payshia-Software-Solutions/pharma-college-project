<?php

require_once __DIR__ . '/../../controllers/MediMindLevelMedicineController.php';

// Instantiate the controller
$pdo = $GLOBALS['pdo'];
$controller = new MediMindLevelMedicineController($pdo);

// Define routes
return [
    'GET /medi-mind-level-medicines/' => [$controller, 'getAll'],
    'GET /medi-mind-level-medicines/{id}/' => [$controller, 'getById'],
    'GET /medi-mind-level-medicines/level/{levelId}/' => [$controller, 'getByLevel'],
    'POST /medi-mind-level-medicines/' => [$controller, 'create'],
    'PUT /medi-mind-level-medicines/{id}/' => [$controller, 'update'],
    'DELETE /medi-mind-level-medicines/{id}/' => [$controller, 'delete'],
];
