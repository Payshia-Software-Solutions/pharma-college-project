<?php
require_once './controllers/Hunter/HunterSaveAnswerController.php';

// Instantiate the controller
$pdo = $GLOBALS['pdo'];
$hunterSaveAnswerController = new HunterSaveAnswerController($pdo);

// Define routes
return [
    'GET /hunter-saveanswer/' => [$hunterSaveAnswerController, 'getAllRecords'],
    'GET /hunter-saveanswer/{id}/' => [$hunterSaveAnswerController, 'getRecordById'],
    'POST /hunter-saveanswer/' => [$hunterSaveAnswerController, 'createRecord'],
    'PUT /hunter-saveanswer/{id}/' => [$hunterSaveAnswerController, 'updateRecord'],
    'DELETE /hunter-saveanswer/{id}/' => [$hunterSaveAnswerController, 'deleteRecord']
];
