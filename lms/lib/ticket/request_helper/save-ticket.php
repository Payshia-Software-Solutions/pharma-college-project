<?php
require_once '../../../include/configuration.php';
include '../../../php_handler/function_handler.php';
include '../methods/functions.php';

$userLevel = $_POST['UserLevel'];
$indexNumber = $_POST['LoggedUser'];
$courseCode = $_POST['defaultCourseCode']; // Course will be taken as Batch

$ticketSubject = $_POST['subject'];
$ticketDepartment = $_POST['department'];
$relatedService = $_POST['relatedService'];
$ticketInfo = $_POST['ticketText'];

$fileNames = array_filter($_FILES['files']['name']);
$ticketId = 0;
$targetDir = './../assets/ticket_img/';
$allowTypes = array('jpg', 'png', 'jpeg', 'gif');

$statusMsg = $errorMsg = $insertValuesSQL = $errorUpload = $errorUploadType = '';

if (!empty($fileNames)) {
    foreach ($_FILES['files']['name'] as $key => $val) {
        // File upload path 
        $fileName = basename($_FILES['files']['name'][$key]);
        $targetFilePath = $targetDir . $fileName;

        // Check whether file type is valid 
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
        if (in_array($fileType, $allowTypes)) {
            // Upload file to server 
            if (move_uploaded_file($_FILES["files"]["tmp_name"][$key], $targetFilePath)) {
                $errorResult = "Upload Done";
            } else {
                $errorUpload .= $_FILES['files']['name'][$key] . ' | ';
            }
        } else {
            $errorUploadType .= $_FILES['files']['name'][$key] . ' | ';
        }
    }
} else {
    $statusMsg = 'Please select a file to upload.';
}

// Convert array to comma-separated string
$attachmentList = implode(", ", $fileNames);
$isActive = 1;
$toIndexNumber = 'Admin';
$readStatus = 'unread';
$parentId = 0;

$saveResult = SaveTicket($ticketId, $indexNumber, $ticketSubject, $ticketDepartment, $relatedService, $ticketInfo, $attachmentList, $isActive, $toIndexNumber, $readStatus, $parentId);
echo json_encode($saveResult);
