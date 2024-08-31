<?php
require_once '../../../include/configuration.php';
include '../../../php_handler/function_handler.php';
include '../../../php_handler/email-API.php';

$studentNumber = $_POST['studentNumber'];
$phoneNumber = $_POST['phoneNumber'];
$studentDetails = GetLmsStudent()[$studentNumber];
$studentPhone = formatPhoneNumber($studentDetails['phone']);
$studentEmail = $studentDetails['email'];


if ($studentPhone == $phoneNumber) {
    $token = '';
    $length = 16;

    for ($i = 0; $i < $length; $i++) {
        $digit = random_int(0, 9); // Generate a random digit (0-9)
        $token .= $digit; // Append the digit to the token string
    }
    $is_active = 1;

    $otp =  generateOTP();

    // Create Reset URL
    $url = "https://web.pharmacollege.lk/reset-password-return?token=$token&phoneNumber=$studentPhone&studentNumber=$studentNumber";

    $messageText = 'Dear ' . $studentNumber . ',
    
OTP - ' . $otp . '

Reset Link
' . $url . '

Thank you!
Ceylon Pharma College
www.pharmacollege.lk';

    $sendSmsResult = SentSMS($studentPhone, 'Pharma C.', $messageText);
    $errorResult = SaveResetToken($phoneNumber, $token, $is_active, $studentNumber, $otp);

    // Sent Email
    $fullName = $studentNumber;
    $toAddress = $studentEmail;
    $fromAddress = 'info@pharmacollege,lk';
    $mailSubject = "Reset Password | Ceylon Pharma College";
    $mailBodyHtml = $messageText;
} else {
    $errorResult = json_encode(array('status' => 'error', 'message' => 'Phone Number is not matching!'));
}

echo $errorResult;
