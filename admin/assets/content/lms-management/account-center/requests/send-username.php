<?php
require_once('../../../../../include/config.php');
include '../../../../../include/function-update.php';
include '../../../../../include/lms-functions.php';
// include '../../../../../include/sms-API.php';
include '../../../../../include/email-API.php';

$studentNumber = $_POST['studentNumber'];
$phone_number = $_POST['phoneNumber'];
$studentBatch = $_POST['studentBatch'];


$CourseBatches = getLmsBatches();
$cityList = GetCities($link);
$DistrictList = getDistricts($link);

$studentInfo = GetLmsStudentsByUserName($studentNumber);
$first_name = $studentInfo['first_name'];
$name_with_initials = $studentInfo['name_with_initials'];
$email_address = $studentInfo['e_mail'];

// Load SMS content from the file
$smsTemplateFilePath = '../../../../../assets/sms-templates/account-activation-message.txt'; // Replace with the actual path to your SMS template file
$smsTemplate = file_get_contents($smsTemplateFilePath);

// Replace variables in the SMS content
$smsMessage = str_replace('{{FIRST_NAME}}', $first_name, $smsTemplate);
$smsMessage = str_replace('{{COURSE_NAME}}', $CourseBatches[$studentBatch]['course_name'], $smsMessage);
$smsMessage = str_replace('{{GENERATED_USER_NAME}}', $studentNumber, $smsMessage);

// Format phone number
$phone_number = '0' . $phone_number;

// Send SMS
$smsResult = SentSMS($phone_number, 'Pharma C.', $smsMessage);



// Send Email
$fullName = $name_with_initials;
$toAddress = $email_address;
$fromAddress = 'info@pharmacollege,lk';
$mailSubject = "New User Activation | Ceylon Pharma College";
$mailBodyHtml = '';

// Load HTML content from the file
$htmlFilePath = '../../../../../assets/mail-templates/register-mail.html'; // Replace with the actual path to your HTML file
$mailBodyHtml = file_get_contents($htmlFilePath);

// Replace variables in the HTML content
$mailBodyHtml = str_replace('{{FULL_NAME}}', $fullName, $mailBodyHtml);
$mailBodyHtml = str_replace('{{USER_NAME}}', $studentNumber, $mailBodyHtml);
$mailBodyHtml = str_replace('{{YEAR}}', date('Y'), $mailBodyHtml);

$mailResult = sentEmail($fullName, $toAddress, $fromAddress, $mailSubject, $mailBodyHtml);
echo $smsResult;
