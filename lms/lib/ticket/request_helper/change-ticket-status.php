<?php
require_once '../../../include/configuration.php';
include '../../../php_handler/function_handler.php';
include '../methods/functions.php';

$ticketId = $_POST['ticketId'];
$ticketStatus = $_POST['ticketStatus'];

$statusMsg = $errorMsg = $insertValuesSQL = $errorUpload = $errorUploadType = '';

$saveResult = UpdateTicketStatus($ticketId, $ticketStatus);
echo json_encode($saveResult);
