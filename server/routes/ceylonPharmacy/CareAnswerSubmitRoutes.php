<?php
// routes/ceylonPharmacy/CareAnswerSubmitRoutes.php

require_once './controllers/ceylonPharmacy/CareAnswerSubmitController.php';

// ... (other routes)

// Add this new route
$routes['POST /care-answer-submits/validate'] = function () use ($careAnswerSubmitController) {
    $careAnswerSubmitController->validateAndCreate();
};

return $routes;
