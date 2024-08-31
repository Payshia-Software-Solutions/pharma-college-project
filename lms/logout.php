<?php

// Initialize the session
session_start();

$sessionid = $_SESSION["username"];

// Database Connection & Other Configuration
require_once './include/configuration.php';

date_default_timezone_set("Asia/Colombo");

// Unset all of the session variables
$_SESSION = array();

// Destroy the session.
session_destroy();

// Redirect to login page
header("location: login");
exit;
