<?php
require_once '../../include/configuration.php';
include '../../php_handler/function_handler.php';
include '../../php_handler/course_functions.php';

$LoggedUser = $_POST['loggedUser'];
$CourseCode = $_POST['courseCode'];

$lmsStudent =  GetLmsStudent()[$LoggedUser];
$userDetails = GetUserDetails($link, $LoggedUser);

// Parameters
$Email = $userDetails['e_mail'];
$status_id = $_POST["status_id"];
$fname = $_POST["fname"];
$lname = $_POST["lname"];
$NicNumber = $_POST["NicNumber"];
$phoneNumber = $_POST["phoneNumber"];
$whatsAppNumber = $_POST["whatsAppNumber"];
$addressL1 = $_POST["addressL1"];
$addressL2 = $_POST["addressL2"];
$city = $_POST["city"];
$District = $userDetails['district'];
$postalCode = $userDetails['postal_code'];
$Gender = $_POST["Gender"];
$DOBirth = $_POST["DOBirth"];
$UserName = $userDetails["username"];
$update_full_name = $_POST['full_name'];
$update_name_with_initials = $_POST['name_with_initials'];
$update_name_on_certificate = $_POST['name_on_certificate'];


$saveResult = saveProfileEditRequest($UserName, $status_id, $fname, $lname, $Gender, $addressL1, $addressL2, $city, $District, $postalCode, $phoneNumber, $whatsAppNumber, $NicNumber, $DOBirth, $DOBirth, $update_full_name, $update_name_with_initials, $update_name_on_certificate);

echo json_encode($saveResult);
