<?php
require_once '../../../include/configuration.php';
include '../../../php_handler/function_handler.php';
include '../methods/functions.php';

$ticketId = $_POST['ticketId'];
$RateValue = $_POST['RateValue'];

$statusMsg = $errorMsg = $insertValuesSQL = $errorUpload = $errorUploadType = '';

$saveResult = RateReply($ticketId, $RateValue);
echo json_encode($saveResult);
