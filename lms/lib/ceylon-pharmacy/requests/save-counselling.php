<?php
require_once '../../../include/configuration.php';
include '../../../php_handler/function_handler.php';


$LoggedUser = $_POST['LoggedUser'];
$prescriptionID = $_POST['prescriptionID'];
$coverID = $_POST['coverID'];
$addedInstructions = $_POST['addedInstructions'];


$save_result = insertInstructionsSetup($link, $prescriptionID, $coverID, $addedInstructions);
echo $save_result;
