<?php
require_once '../../../include/configuration.php';
include '../../../php_handler/function_handler.php';


$prescriptionID = $_POST['prescriptionID'];
$coverID = $_POST['coverID'];


$save_result = ClearSetupInstructions($link, $prescriptionID, $coverID);
echo $save_result;
