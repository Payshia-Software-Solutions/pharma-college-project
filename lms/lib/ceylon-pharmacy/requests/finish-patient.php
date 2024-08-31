<?php
require_once '../../../include/configuration.php';
include '../../../php_handler/function_handler.php';

$loggedUser = $_POST['LoggedUser'];
$UserLevel = $_POST['UserLevel'];
$prescriptionID = $_POST['prescriptionID'];
$paymentValue = $_POST['paymentValue'];

$AnswerPaymentValue =  GetPaymentValue($link, $prescriptionID);

if ($UserLevel == "Student") {
    if ($AnswerPaymentValue == $paymentValue) {
        $return_message = FinishTreatments($link, $loggedUser, $prescriptionID);
    } else {
        $return_message = json_encode(array("status" => "error", "message" => "Payment Value is not correct"));
    }
} else {
    $return_message = SetPaymentValue($link, $prescriptionID, $paymentValue);
}

echo $return_message;
