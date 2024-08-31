<?php
require_once '../../../../include/configuration.php';
include '../../../../php_handler/function_handler.php';
include '../../php_methods/d-pad-methods.php';

$entryId = $_POST['entryId'];

$resultArray = deletePrescriptionAnswerSubmissions($entryId);
echo $resultArray;
