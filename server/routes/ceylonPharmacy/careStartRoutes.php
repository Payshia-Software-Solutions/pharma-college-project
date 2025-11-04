<?php
// routes/ceylonPharmacy/careStartRoutes.php

require_once __DIR__ . '/../../controllers/ceylonPharmacy/CareStartController.php';

// Instantiate the controller
$pdo = $GLOBALS['pdo'];
$careStartController = new CareStartController($pdo);

// Define routes
return [
    'GET /care-starts' => [$careStartController, 'getAll'],
    'GET /care-starts/{id}' => [$careStartController, 'getById'],
    'POST /care-starts' => [$careStartController, 'create'],
    'PUT /care-starts/{id}' => [$careStartController, 'update'],
    'DELETE /care-starts/{id}' => [$careStartController, 'delete']
];
