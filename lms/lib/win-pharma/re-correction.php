<?php
require_once '../../include/configuration.php';
include '../../php_handler/function_handler.php';
include '../../php_handler/course_functions.php';
include '../../php_handler/win-pharma-functions.php';

$UserLevel = $_POST["UserLevel"]; // User level obtained from the form
$LoggedUser = $_POST["LoggedUser"]; // Logged-in user obtained from the form

$SubmissionID = $_POST['SubmissionID'];
$grade = 0;
$grade_status = "Re-Correction";

$result = RequestReCorrection($link, $LoggedUser, $SubmissionID, $grade, $grade_status);
echo json_encode($result);
