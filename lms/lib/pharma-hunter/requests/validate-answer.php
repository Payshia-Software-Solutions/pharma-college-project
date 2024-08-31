<?php
require_once '../../../include/configuration.php';
include '../../../php_handler/function_handler.php';
include '../php_methods/pharma-hunter-methods.php';

// Include Classes
include_once '../classes/Database.php';
include_once '../classes/SaveAnswer.php';
include_once '../classes/Medicine.php';
include_once '../classes/MedicineStore.php';

// Create a new Database object with the path to the configuration file
$config_file = '../../../include/env.txt';
$database = new Database($config_file);
$db = $database->getConnection();

// Create objects
$saveAnswer = new saveAnswer($database);
$medicines = new Medicine($database);
$medicineStore = new MedicineStore($database);

$medicineId = $_POST["medicineId"];
$racksId = $_POST["racksId"];
$dosageFormId = $_POST["dosageFormId"];
$drugCategoryId = $_POST["drugCategoryId"];
$AttemptValue = $_POST['AttemptValue'];

$loggedUser = $_POST["loggedUser"];
$courseCode = $_POST["courseCode"];
$userLevel = $_POST["userLevel"];

$error = "";
$savedAnswers = $saveAnswer->savedAnswersByUserMedicine($medicineId, $loggedUser);
$Medicine = $medicineStore->fetchByMedicineId($medicineId);
$medicineInfo = $medicines->fetchById($medicineId);

$Mark = $WrongCount = $AttemptCount = 0;

$AttemptCount = (!empty($savedAnswers)) ? count($savedAnswers) : '';
// Validate Answer
if ($Medicine['rack_id'] == $racksId) {
    $Mark += 10;
} else {
    $WrongCount = 1;
    $Mark -= 5;
}

if ($medicineInfo['category_id'] == $drugCategoryId) {
    $Mark += 10;
} else {
    $WrongCount = 1;
    $Mark -= 5;
}

if ($Medicine['dosageID'] == $dosageFormId) {
    $Mark += 10;
} else {
    $WrongCount = 1;
    $Mark -= 5;
}

if ($WrongCount == 0) {
    $AnswerStatus = "Correct";
    if ($AttemptValue == 1) {
        $ScoreType = "Jem";
    } else {
        $ScoreType = "Coin";
    }

    $error = array('status' => 'success', 'message' => 'Your stored the Drug correctly');
} else {
    $AnswerStatus = "In-Correct";
    $ScoreType = "Non";
    $error = array('status' => 'error', 'message' => 'Your Answer is In-Correct');
}

$dataset = [
    'index_number' => $loggedUser,
    'category_id' => $drugCategoryId,
    'medicine_id' => $medicineId,
    'rack_id' => $racksId,
    'dosage_id' => $dosageFormId,
    'answer_status' => $AnswerStatus,
    'score' => $Mark,
    'score_type' => $ScoreType,
    'attempts' => $AttemptValue,
    'created_at' => date("Y-m-d H:i")
];

// Insert a new employee
if ($saveAnswer->add($dataset)) {
    $query_result = array('status' => 'success', 'message' => 'Record added successfully.');
} else {
    $query_result = array('status' => 'error', 'message' => 'Failed to add employee.' . $saveAnswer->getLastError());
}

// echo 'rack_id ' . $Medicine['rack_id'] . '<br> Answer ' . $racksId . '<br>';
// echo 'category_id ' . $medicineInfo['category_id'] . '<br>  Answer ' . $drugCategoryId . '<br>';
// echo 'dosageID ' . $Medicine['dosageID'] . '<br> Answer ' . $dosageFormId . '<br>';

echo json_encode($error);
