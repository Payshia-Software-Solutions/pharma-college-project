<?php
require_once '../../../include/configuration.php';
include '../../../php_handler/function_handler.php';
include '../php_methods/pharma-hunter-methods.php';

$medicineId = $_POST["medicineId"];
$racksId = $_POST["racksId"];
$dosageFormId = $_POST["dosageFormId"];
$drugCategoryId = $_POST["drugCategoryId"];
$drugGroupId = $_POST["drugGroupId"];

$loggedUser = $_POST["loggedUser"];
$courseCode = $_POST["courseCode"];
$userLevel = $_POST["userLevel"];

$error = "";
$savedAnswers = savedAnswersByUserMedicine($link, $loggedUser, $medicineId);
$Medicine = GetProMedicineByID($link, $medicineId);
$Mark = $WrongCount = 0;
$displayMessage =  $rackError = $dosageError = $categoryError = $drugError = '';

$AttemptCount = count($savedAnswers);
// Validate Answer
if ($Medicine[0]['rack_id'] == $racksId) {
    $Mark += 10;
} else {
    $WrongCount = 1;
    $Mark -= 5;
    $rackError = "Your selected Rack is Wrong!";
}

if ($Medicine[0]['drug_type_id'] == $drugGroupId) {
    $Mark += 10;
} else {
    $WrongCount = 1;
    $Mark -= 5;
    $drugError = "Your selected Drug Type is Wrong!";
}

if ($Medicine[0]['category_id'] == $drugCategoryId) {
    $Mark += 10;
} else {
    $WrongCount = 1;
    $Mark -= 5;
    $categoryError = "Your selected Category is Wrong!";
}

if ($Medicine[0]['dosage_form_id'] == $dosageFormId) {
    $Mark += 10;
} else {
    $WrongCount = 1;
    $Mark -= 5;
    $dosageError = "Your selected Dosage form is Wrong!";
}

if ($WrongCount == 0) {
    $AnswerStatus = "Correct";
    if ($AttemptCount == 0) {
        $ScoreType = "Gem";
    } else {
        $ScoreType = "Coin";
    }

    $error = array('status' => 'success', 'message' => 'Your stored the Drug correctly');
} else {
    $AnswerStatus = "In-Correct";
    $ScoreType = "Non";
    $error = array('status' => 'error', 'message' => 'Your Answer is In-Correct', 'rackError' => $rackError, 'drugError' => $drugError, 'categoryError' => $categoryError, 'dosageError' => $dosageError);
}



// Answer Submit
$result = SaveAnswerToDatabase($link, $loggedUser, $medicineId, $racksId, $dosageFormId, $AnswerStatus, $Mark, $AttemptCount, $ScoreType, $drugCategoryId, $drugGroupId);

echo json_encode($error);
