<?php
require_once '../../include/configuration.php';
include '../../php_handler/function_handler.php';
$UserLevel = $_POST['UserLevel'];
$loggedUser = $_POST['LoggedUser'];
$CourseCode = $_POST['CourseCode'];
$deliverySettings = GetDeliverySetting($link, $CourseCode);
$selectedCourse = GetCourses($link)[$CourseCode];
$titleName = $_POST['titleName'];
$isActive = $_POST['isActive'];
$selectedCourseCode = $_POST['selectedCourseCode'];
$value = $_POST['value'];
$selectedId = $_POST['selectedId'];

// Image Upload
$dir = './assets/images/';
$item_image_tmp = "no-image.png";
if (!file_exists($dir)) {
    mkdir($dir, 0777, true);
}

$item_image_tmp = $_POST['item_image_tmp'];
if ($item_image_tmp == "") {
    $item_image_tmp = "no-image.png";
}

if (isset($_FILES['icon'])) {
    $file_name = $_FILES['icon']['name'];
    $file_size = $_FILES['icon']['size'];
    $file_tmp = $_FILES['icon']['tmp_name'];
    $file_type = $_FILES['icon']['type'];

    $imagePath = "./assets/images/" . $file_name;
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

$icon = $file_name;

$result = SaveDelivery($link, $selectedCourseCode, $titleName, $isActive, $icon, $value, $selectedId);
echo $result;
