<?php
require_once '../../../include/configuration.php';
include '../../../php_handler/function_handler.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $LoggedUser = $_POST['LoggedUser'];
    $UserLevel = $_POST['UserLevel'];

    $prescriptionID = $_POST['prescriptionID'];
    $coverID = $_POST['coverID'];
    $envelopeDate = $_POST['envelope-date'];
    $envelopeName = $_POST['envelope-name'];
    $envelopeDrugName = $_POST['envelope-drug-name'];
    $envelopeDrugType = $_POST['envelope-dosage-form'];
    $envelopeDrugQuantity = $_POST['envelope-drug-quantity'];
    $envelopeMorningQuantity = $_POST['envelope-morning-quantity'];
    $envelopeAfternoonQuantity = $_POST['envelope-afternoon-quantity'];
    $envelopeEveningQuantity = $_POST['envelope-evening-quantity'];
    $envelopeNightQuantity = $_POST['envelope-night-quantity'];
    $envelopeMealType = $_POST['envelope-meal-type'];
    $envelopeUsingFrequency = $_POST['envelope-using-frequency'];
    $envelopeAtATime = $_POST['envelope-at-a-time'];
    $envelopeUsingFrequencyHour = $_POST['envelope-using-frequency-hour'];
    $envelopeAdditionalDescription = $_POST['envelope-additional-instruction'];

    $error = saveOrUpdateAnswerDPad($link, $prescriptionID, $coverID, $envelopeName, $envelopeDrugName, $envelopeDrugType, $envelopeDrugQuantity, $envelopeMorningQuantity, $envelopeAfternoonQuantity, $envelopeEveningQuantity, $envelopeNightQuantity, $envelopeMealType, $envelopeUsingFrequency, $envelopeAtATime, $envelopeUsingFrequencyHour, $envelopeAdditionalDescription, $LoggedUser, $envelopeDate);
} else {
    $error = array('status' => 'error', 'message' => 'Invalid Method');
}

// Convert the error array to JSON for AJAX or other response handling
echo $error;
