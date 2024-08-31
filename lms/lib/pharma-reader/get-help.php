<?php
require_once '../../include/configuration.php';
include '../../php_handler/function_handler.php';
include '../../php_handler/course_functions.php';
include './php_methods/pharma-reader-methods.php';

$prescriptionId = $_POST['prescriptionId'];
$questionArray = GetPrescriptions()[$prescriptionId];
$helpText = $questionArray['PresHelp'];
?>

<div class="alert alert-info fw-bold pb-0 mt-3"><?= $helpText ?></div>