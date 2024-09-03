<?php
include './include/session.php';
include './php_handler/function_handler.php';

$company_id = 5465431;
$access_token = 654654561;

$base_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
$base_url = $base_url . '/mobile.pharmacollege.lk';

// Default Course
$enrolledCourseCode = GetDefaultCourseValue($session_user_name);
$config = require './include/setting.php';
$serverUrl = $config['server_url'];
?>

<input type="hidden" value="<?= $session_user_name; ?>" id="LoggedUser" name="LoggedUser">
<input type="hidden" value="<?= $session_user_level; ?>" id="UserLevel" name="UserLevel">
<input type="hidden" value="<?= $company_id; ?>" id="company_id" name="company_id">
<input type="hidden" value="<?= $base_url; ?>" id="base_url" name="base_url">
<input type="hidden" value="<?= $access_token; ?>" id="access_token" name="access_token">
<input type="hidden" value="<?= $enrolledCourseCode; ?>" id="defaultCourseCode" name="defaultCourseCode">
<input type="hidden" value="<?= $serverUrl; ?>" id="serverUrl" name="serverUrl">