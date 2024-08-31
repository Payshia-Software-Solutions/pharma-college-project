<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../../../include/configuration.php';
require_once '../../../php_handler/function_handler.php';

// Include Classes
include_once '../classes/Database.php';
include_once '../classes/Topics.php';

// Create a new Database object with the path to the configuration file
$config_file = '../../../include/env.txt';
$database = new Database($config_file);
$db = $database->getConnection();

$Topics = new Topics($database);

$newDataset = [
    'title' => $_POST['topic_title'],
    'user_account' => $_POST['loggedUser'],
    'submitted_time' => date("Y-m-d H:i:s"),
    'type' => 1,
    'category' =>  $_POST['topic_category'],
    'content' =>  $_POST['topicContent'],
    'current_status' => 1,
    'is_active' => 1
];


if (strip_tags($_POST['topicContent']) != "") {
    if ($Topics->add($newDataset)) {
        $error = array('status' => 'success', 'message' => 'Topic created successfully.');
    } else {
        $error = array('status' => 'error', 'message' => 'Failed to Save Topic.' . $Topics->getLastError());
    }
} else {
    $error = array('status' => 'error', 'message' => 'Please add content');
}
echo json_encode($error);
