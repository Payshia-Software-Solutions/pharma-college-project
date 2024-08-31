<?php
require_once '../../include/configuration.php';
include '../../php_handler/function_handler.php';

// Parameters
$UserLevel = $_POST['UserLevel'];
$loggedUser = $_POST['LoggedUser'];
$delivery_id = $_POST['delivery_id'];
$selectedCourseCode = $_POST['selectedCourseCode'];
$value = $_POST['value'];
$payment_method = $_POST['payment_method'];;
$order_date = date("Y-m-d H:i:s");
// $tracking_number = "CP" . time();
$tracking_number = "";
$current_status = 1;
$fullName = $_POST['fullName'];
$streetAddress = $_POST['streetAddress'];
$city = $_POST['city'];
$district = $_POST['district'];
$phoneNumber1 = $_POST['phoneNumber1'];
$phoneNumber2 = $_POST['phoneNumber2'];

$result =  PlaceOrder($link, $delivery_id, $tracking_number, $loggedUser, $order_date, $current_status, $value, $payment_method, $selectedCourseCode, $fullName, $streetAddress, $city, $district, $phoneNumber1, $phoneNumber2);
echo $result;
