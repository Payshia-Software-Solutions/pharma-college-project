<?php
require_once "../include/configuration.php"; // Include config file   
include '../include/functions.php';
include '../include/email-API.php';
include '../include/sms-API.php';

$cityList = GetCities($link);
$districtList = getDistricts($link);

$email_address = $_POST["email_address"];
$status_id = $_POST["status_id"];
$fname = $_POST["fname"];
$lname = $_POST["lname"];
$password = $_POST["password"];
$NicNumber = $_POST["NicNumber"];
$phoneNumber = formatPhoneNumber($_POST["phoneNumber"]);
$whatsAppNumber = formatPhoneNumber($_POST["whatsAppNumber"]);
$addressL1 = $_POST["addressL1"];
$addressL2 = $_POST["addressL2"];
$city = $_POST["city"];
$District = "";
$postalCode = "";
$paid_amount = 0.00;


$gender = $_POST["gender"];
$fullName = $_POST["fullName"];
$nameWithInitials = $_POST["nameWithInitials"];
$nameOnCertificate = $_POST["nameOnCertificate"];
$selectedCourse = $_POST['selectedCourse'];

$saveResult = JoinNow($link, $email_address, $status_id, $fname, $lname, $password, $NicNumber, $phoneNumber, $whatsAppNumber, $addressL1, $addressL2, $city, $District, $postalCode, $paid_amount, $fullName, $nameWithInitials, $nameOnCertificate, $gender, $selectedCourse);

$submitArray = json_decode($saveResult);
$status = $submitArray->status;
$referenceId = $submitArray->last_inserted_id;

if ($status == 'success') {
    // Send Email
    $toAddress = $Email;
    $fromAddress = "info@pharmacollege.lk";
    $mailSubject = "REF#" . $referenceId . " | Registration Success | Ceylon Pharma College";
    $mailBodyHtml = "You are successfully registered! Please wait for the Approval Process!";
    $mailResult = sentEmail($fullName, $toAddress, $fromAddress, $mailSubject, $mailBodyHtml);

    // Send SMS
    $mobile = $phoneNumber;
    $message = 'You have successfully submitted the application.
REF - ' . $referenceId . '
Thank you
Ceylon Pharma College
Web - www.pharmacollege.lk';
    $smsResult = SentSMS($mobile, 'Pharma C.', $message);
}
// echo $saveResult;
