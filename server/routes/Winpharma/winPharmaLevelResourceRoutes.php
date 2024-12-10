<?php
// routes/Winpharma/winPharmaLevelResourceRoutes.php

require_once './controllers/Winpharma/WinPharmaLevelResourceController.php';

// Instantiate the controller
$pdo = $GLOBALS['pdo'];
$WinPharmaLevelResourceController = new WinPharmaLevelResourceController($pdo);

// Define appointment routes
return [
    'GET /win_pharma_level_resources/' => [$WinPharmaLevelResourceController, 'getWinPharmaLevelResources'],
    'GET /win_pharma_level_resources/{id}/' => [$WinPharmaLevelResourceController, 'getWinPharmaLevelResource'],
    'POST /win_pharma_level_resources/' => [$WinPharmaLevelResourceController, 'createWinPharmaLevelResource'],
    'PUT /win_pharma_level_resources/{id}/' => [$WinPharmaLevelResourceController, 'updateWinPharmaLevelResource'],
    'DELETE /win_pharma_level_resources/{id}/' => [$WinPharmaLevelResourceController, 'deleteWinPharmaLevelResource']
];


?>