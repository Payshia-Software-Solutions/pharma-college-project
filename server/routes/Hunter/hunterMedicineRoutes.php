<?php
require_once './controllers/Hunter/HunterMedicineController.php';

// Instantiate the controller
$pdo = $GLOBALS['pdo'];
$hunterMedicineController = new HunterMedicineController($pdo);

// Define routes
return [
    'GET /hunter-medicine/' => [$hunterMedicineController, 'getAllRecords'],
    'GET /hunter-medicine/{id}/' => [$hunterMedicineController, 'getRecordById'],
    'POST /hunter-medicine/' => [$hunterMedicineController, 'createRecord'],
    'PUT /hunter-medicine/{id}/' => [$hunterMedicineController, 'updateRecord'],
    'DELETE /hunter-medicine/{id}/' => [$hunterMedicineController, 'deleteRecord']
];
