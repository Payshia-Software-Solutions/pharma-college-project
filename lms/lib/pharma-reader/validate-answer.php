<?php
require_once '../../include/configuration.php';
include '../../php_handler/function_handler.php';
include '../../php_handler/course_functions.php';
include './php_methods/pharma-reader-methods.php';


$userLevel = $_POST['UserLevel'];
$loggedUser = $_POST['LoggedUser'];
$courseCode = $_POST['defaultCourseCode']; // Course will be taken as Batch

$prescriptionId = $_POST['prescriptionId'];
$selectedAnswer = $_POST['selectedAnswer'];

$answerSaveResult = ValidateAnswer($prescriptionId, $loggedUser, $selectedAnswer);
echo json_encode($answerSaveResult);
