<?php
require_once '../../../include/configuration.php';
include '../../../php_handler/function_handler.php';

$studentNumber = $_POST['studentNumber'];
$otpNumber = $_POST['otpNumber'];
$phoneNumber = $_POST['phoneNumber'];
$studentDetails = GetLmsStudent()[$studentNumber];
$tokenDetails = getTokenDetails($studentNumber, $phoneNumber)[0];
$generatedOTP = $tokenDetails['otp'];
$generatedToken = $tokenDetails['token'];

if ($otpNumber == $generatedOTP) {
    $errorResult = json_encode(array('status' => 'success', 'token' => $generatedToken, 'message' => 'OTP Validated'));
} else {
    $errorResult = json_encode(array('status' => 'error', 'token' => '', 'message' => 'Invalid OTP. Try Again'));
}

echo $errorResult;
