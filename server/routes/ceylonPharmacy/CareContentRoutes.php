<?php
// routes/ceylonPharmacy/CareContentRoutes.php

require_once './controllers/ceylonPharmacy/CareContentController.php';

// Instantiate the controller
$pdo = $GLOBALS['pdo'];
$careContentController = new CareContentController($pdo);

// Define routes
return [
    'GET /care-contents' => [$careContentController, 'getAll'],
    'GET /care-contents/{id}' => [$careContentController, 'getById'],
    'POST /care-contents' => [$careContentController, 'create'],
    'PUT /care-contents/{id}' => [$careContentController, 'update'],
    'DELETE /care-contents/{id}' => [$careContentController, 'delete']
];
