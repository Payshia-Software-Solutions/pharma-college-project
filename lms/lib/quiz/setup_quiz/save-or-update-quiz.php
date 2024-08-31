<?php
require_once '../../../include/configuration.php';
include '../../../php_handler/function_handler.php';
include '../../../php_handler/course_functions.php';
include '../php_method/quiz_methods.php';

$userLevel = $_POST['UserLevel'];
$loggedUser = $_POST['LoggedUser'];
$courseCode = $_POST['defaultCourseCode']; // Course will be taken as Batch

$topicId = $_POST['topicId'];
$courseCode = $_POST['courseCode'];

$saveResult = SaveCourseTopic($topicId, $courseCode, $loggedUser);
echo $saveResult;
