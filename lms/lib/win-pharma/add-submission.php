<?php
require_once '../../include/configuration.php';
include '../../php_handler/function_handler.php';
include '../../php_handler/course_functions.php';
include '../../php_handler/win-pharma-functions.php';

$UserLevel = $_POST["UserLevel"]; // User level obtained from the form
$LoggedUser = $_POST["LoggedUser"]; // Logged-in user obtained from the form

$ResourceID = $_POST["ResourceID"];
$LevelCode = $_POST['LevelCode'];
// $attempt = $_POST['LevelCode'];
$attempt = GetAttemptCount($link, $LoggedUser, $ResourceID) + 1;
$course_code = $_POST['defaultCourseCode'];

$dir = '../../uploads/tasks/submission/' . $LoggedUser . '/' . $ResourceID . '/';

if (!file_exists($dir)) {
    mkdir($dir, 0777, true);
}

if (isset($_FILES['submission'])) {
    $file_name = $_FILES['submission']['name'];
    $file_size = $_FILES['submission']['size'];
    $file_tmp = $_FILES['submission']['tmp_name'];
    $file_type = $_FILES['submission']['type'];

    $imagePath = $dir . $file_name;
    $file_parts = explode('.', $file_name);
    $file_ext = strtolower(end($file_parts));
    $expensions = array("jpeg", "jpg", "png", "webp", "pdf");
    if (in_array($file_ext, $expensions) === false) {
        $errors[] = "Extension not allowed. Please choose a JPEG, PNG, WebP, or PDF file.";
    }
    if ($file_size > 10485760) {
        $errors[] = 'File size must be less than 5 MB.';
    }
    if (empty($errors)) {
        // Compress the image and save it
        $upload_stat = compressAndSaveImage($file_tmp, $imagePath, $file_type);

        if ($upload_stat) {
            $result = AddSubmission($link, $LoggedUser, $LevelCode, $ResourceID, $file_name, $attempt, $course_code);
        } else {
            $result = array('status' => 'Error', 'message' => implode(" ", $errors));
        }
    } else {
        $result = array('status' => 'Error', 'message' => implode(" ", $errors));
    }
} else {
    $result = array('status' => 'Error', 'message' => 'No Submission');
}

echo json_encode($result);


function compressAndSaveImage($sourcePath, $destinationPath, $file_type)
{
    // Load the image based on the file type
    switch ($file_type) {
        case 'image/jpeg':
        case 'image/jpg':
            $sourceImage = imagecreatefromjpeg($sourcePath);
            break;
        case 'image/png':
            $sourceImage = imagecreatefrompng($sourcePath);
            break;
        case 'image/webp':
            $sourceImage = imagecreatefromwebp($sourcePath);
            break;
        default:
            return false; // Unsupported file type
    }

    // Calculate the new dimensions for compression
    $maxWidth = 800;
    $maxHeight = 600;
    $sourceWidth = imagesx($sourceImage);
    $sourceHeight = imagesy($sourceImage);
    $aspectRatio = $sourceWidth / $sourceHeight;
    $newWidth = $maxWidth;
    $newHeight = $maxHeight;

    if ($sourceWidth > $maxWidth || $sourceHeight > $maxHeight) {
        if ($maxWidth / $maxHeight > $aspectRatio) {
            $newWidth = $maxHeight * $aspectRatio;
        } else {
            $newHeight = $maxWidth / $aspectRatio;
        }
    }

    // Create a new image with the compressed dimensions
    $compressedImage = imagecreatetruecolor($newWidth, $newHeight);

    // Apply the compression and resampling
    imagecopyresampled(
        $compressedImage,
        $sourceImage,
        0,
        0,
        0,
        0,
        $newWidth,
        $newHeight,
        $sourceWidth,
        $sourceHeight
    );

    // Save the compressed image to the destination path
    switch ($file_type) {
        case 'image/jpeg':
        case 'image/jpg':
            imagejpeg($compressedImage, $destinationPath, 80); // Adjust the compression quality (80 is a good balance between size and quality)
            break;
        case 'image/png':
            imagepng($compressedImage, $destinationPath, 8); // Adjust the compression level (8 is a good balance between size and quality)
            break;
        case 'image/webp':
            imagewebp($compressedImage, $destinationPath, 80); // Adjust the compression quality (80 is a good balance between size and quality)
            break;
    }

    // Free up memory
    imagedestroy($sourceImage);
    imagedestroy($compressedImage);

    return true;
}
