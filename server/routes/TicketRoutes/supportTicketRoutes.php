<?php

require_once './controllers/SupportTicketController.php';

// Instantiate the controller
$pdo = $GLOBALS['pdo'];
$supportTicketController = new SupportTicketController($pdo);

// Define routes for support tickets
return [
    'GET /tickets/' => [$supportTicketController, 'getAllRecords'],
    'GET /tickets/{ticket_id}/' => [$supportTicketController, 'getRecordById'],
    'GET /tickets/username/{username}/' => [$supportTicketController, 'getRecordByUsername'],
    'POST /tickets/' => [$supportTicketController, 'createRecord'],
    'PUT /tickets/{ticket_id}/' => [$supportTicketController, 'updateRecord'],
    'DELETE /tickets/{ticket_id}/' => [$supportTicketController, 'deleteRecord']
];
