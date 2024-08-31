<?php
require_once '../../../include/configuration.php';
include '../../../php_handler/function_handler.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $LoggedUser = $_POST['LoggedUser'];
    $UserLevel = $_POST['UserLevel'];

    $answerID = $_POST['answerID'];
    $answer_type = $_POST['answer_type'];
    $answer = $_POST['answer'];

    $error = SaveAnswerAdmin($link, $answer_type, $answer, $answerID);
} else {
    $error = array('status' => 'error', 'message' => 'Invalid Method');
}

// Convert the error array to JSON for AJAX or other response handling
echo $error;
