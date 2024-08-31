<?php
require_once '../../include/configuration.php';
include '../../php_handler/function_handler.php';
include '../../php_handler/course_functions.php';
include './php_methods/pharma-reader-methods.php';


$userLevel = $_POST['UserLevel'];
$loggedUser = $_POST['LoggedUser'];
$courseCode = $_POST['defaultCourseCode']; // Course will be taken as Batch

$prescriptionId = $_POST['prescriptionId'];
$pres_name = $_POST['presName'];
$helpText = $_POST['helpText'];
$difficultyMode = $_POST['difficultyMode'];
$questionContent = $_POST['questionContent'];
$answer_1 = $_POST['answer1'];
$answer_2 = $_POST['answer2'];
$answer_3 = $_POST['answer3'];
$answer_4 = $_POST['answer4'];
$correctAnswer = $_POST['correct_answer'];

$activeStatus = $_POST['activeStatus'];


// Image Upload
$dir = './assets/reader-images/';
if (!file_exists($dir)) {
    mkdir($dir, 0777, true);
}

$item_image_tmp = $_POST['item_image_tmp'];
if ($item_image_tmp == "") {
    $item_image_tmp = "no-image.png";
}

if (isset($_FILES['prescriptionFile'])) {
    $file_name = $_FILES['prescriptionFile']['name'];
    $file_size = $_FILES['prescriptionFile']['size'];
    $file_tmp = $_FILES['prescriptionFile']['tmp_name'];
    $file_type = $_FILES['prescriptionFile']['type'];

    $imagePath = "./assets/reader-images/" . $file_name;
    $file_parts = explode('.', $file_name);
    $file_ext = strtolower(end($file_parts));
    $expensions = array("jpeg", "jpg", "png", "webp", "gif", "mp4");
    if (in_array($file_ext, $expensions) === false) {
        $errors[] = "extension not allowed, please choose a JPEG, GIF, WEBP, MP4 or PNG file.";
    }
    if ($file_size > 2097152) {
        $errors[] = 'File size must be exactly 2 MB';
    }
}

if ($file_name == "") {
    $file_name = $item_image_tmp;
}

if (empty($errors) == true) {
    move_uploaded_file($file_tmp, $imagePath);
} else {
    // echo json_encode(array('status' => 'error', 'message' => $errors[0]));
}


$saveResult = SaveNewPrescription($pres_name, $difficultyMode, $loggedUser, $file_name, $activeStatus, $helpText, $questionContent, $answer_1, $answer_2, $answer_3, $answer_4, $correctAnswer, $prescriptionId);
echo json_encode($saveResult);
