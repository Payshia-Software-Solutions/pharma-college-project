<?php
// routes/Winpharma/winPharmaLevelRoutes.php

require_once './controllers/Winpharma/WinPharmaLevelController.php';

// Instantiate the controller
$pdo = $GLOBALS['pdo'];
$WinPharmaLevelController = new WinPharmaLevelController($pdo);

// Define appointment routes
return [
    'GET /win_pharma_level/' => [$WinPharmaLevelController, 'getWinPharmaLevels'],
    'GET /win_pharma_level/{id}/' => [$WinPharmaLevelController, 'getWinPharmaLevel'],
    'POST /win_pharma_level/' => [$WinPharmaLevelController, 'createWinPharmaLevel'],
    'PUT /win_pharma_level/{id}/' => [$WinPharmaLevelController, 'updateWinPharmaLevel'],
    'DELETE /win_pharma_level/{id}/' => [$WinPharmaLevelController, 'deleteWinPharmaLevel']
];

?>