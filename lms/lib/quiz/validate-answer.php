<?php
require_once '../../include/configuration.php';
include '../../php_handler/function_handler.php';
include '../../php_handler/course_functions.php';
include './php_method/quiz_methods.php';

$loggedUser = $_POST['LoggedUser'];
$courseCode = $_POST['defaultCourseCode']; // Course will be taken as Batch

$quizId = $_POST['quizId'];
$questionId = $_POST['questionId'];
$selectedAnswer = $_POST['selectedAnswer'];

$answerSaveResult = SaveQuizAnswer($quizId, $questionId, $loggedUser, $selectedAnswer);
echo $answerSaveResult;
