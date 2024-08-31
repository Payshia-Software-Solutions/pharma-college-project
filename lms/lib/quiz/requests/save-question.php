<?php
require_once '../../../include/configuration.php';
include '../../../php_handler/function_handler.php';
include '../../../php_handler/course_functions.php';
include '../php_method/quiz_methods.php';

$userLevel = $_POST['UserLevel'];
$loggedUser = $_POST['LoggedUser'];
$courseCode = $_POST['defaultCourseCode']; // Course will be taken as Batch

$questionId = $_POST['questionId'];
$topicId = $_POST['topicId'];

$questionContent = $_POST['question'];
$answer1 = $_POST['answer1'];
$answer2 = $_POST['answer2'];
$answer3 = $_POST['answer3'];
$answer4 = $_POST['answer4'];
$correctAnswer = $_POST['correct_answer'];

$questionStatus = 'Active';


$saveResult = SaveQuestion($topicId, $courseCode, $questionId, $questionContent, $loggedUser, $questionStatus, $questionContent, $answer1, $answer2, $answer3, $answer4, $correctAnswer);
echo $saveResult;
