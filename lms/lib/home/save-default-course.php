<?php
require_once '../../include/configuration.php';
include '../../php_handler/function_handler.php';
include '../../php_handler/course_functions.php';

// Post Parameters
$setCourse = $_POST['setCourse'];
$loggedUser = $_POST['LoggedUser'];
$changeTitle = "Course";

$queryResult = SaveDefaultValues($loggedUser, $setCourse, $changeTitle);
echo $queryResult;
