<?php
require_once '../../../include/configuration.php';
include '../../../php_handler/function_handler.php';
include '../../../php_handler/course_functions.php';
include '../php_method/quiz_methods.php';

$userLevel = $_POST['UserLevel'];
$loggedUser = $_POST['LoggedUser'];
$courseCode = $_POST['defaultCourseCode']; // Course will be taken as Batch

// Topic Parameters
$activeStatus = 1;

if ($activeStatus == 1) {
    $activeResult = 'Active';
} else {
    $activeResult = 'Deleted';
}

$topicId = $_POST['topicId'];
$topicName = $_POST['topicName'];

$saveResult = SaveTopic($topicId, $topicName, $activeResult);
echo $saveResult;
