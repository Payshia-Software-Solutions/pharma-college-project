<?php
// routes/ConvocationRegistrationRoutes.php

require_once './controllers/ConvocationRegistrationController.php';

// Instantiate the controller
$pdo = $GLOBALS['pdo'];
$convocationRegistrationController = new ConvocationRegistrationController($pdo);

// Define an array of routes
return [
    // GET all registrations
    'GET /convocation-registrations/$' => function () use ($convocationRegistrationController) {
        return $convocationRegistrationController->getRegistrations();
    },

    // GET a single registration by ID
    'GET /convocation-registrations/(\d+)/$' => function ($registration_id) use ($convocationRegistrationController) {
        return $convocationRegistrationController->getRegistration($registration_id);
    },
    // GET a single registration by student number (alphanumeric)
    'GET /convocation-registrations/check-duplicate/([A-Za-z0-9]+)/$' => function ($studentNumber) use ($convocationRegistrationController) {
        return $convocationRegistrationController->validateDuplicate($studentNumber);
    },


    // GET a single registration by reference number (same as ID)
    'GET /convocation-registrations\?referenceNumber=[\d]+/$' => function () use ($convocationRegistrationController) {
        $reference_number = isset($_GET['referenceNumber']) ? $_GET['referenceNumber'] : null;
        if (!$reference_number) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing required parameter: referenceNumber']);
            return;
        }
        return $convocationRegistrationController->getRegistrationByReference($reference_number);
    },

    // POST create a new registration
    'POST /convocation-registrations/$' => function () use ($convocationRegistrationController) {
        return $convocationRegistrationController->createRegistration();
    },

    // PUT update a registration
    'PUT /convocation-registrations/(\d+)/$' => function ($registration_id) use ($convocationRegistrationController) {
        return $convocationRegistrationController->updateRegistration($registration_id);
    },

    // DELETE a registration
    'DELETE /convocation-registrations/(\d+)/$' => function ($registration_id) use ($convocationRegistrationController) {
        return $convocationRegistrationController->deleteRegistration($registration_id);
    },
];
