<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../../../include/configuration.php';
require_once '../../../php_handler/function_handler.php';

// Include Classes
include_once '../classes/Database.php';
include_once '../classes/Replies.php';

// Create a new Database object with the path to the configuration file
$config_file = '../../../include/env.txt';
$database = new Database($config_file);
$db = $database->getConnection();

$Replies = new Replies($database);

$newDataset = [
    'post_id' => $_POST['postId'],
    'reply_content' => $_POST['replyContent'],
    'created_by' => $_POST['loggedUser'],
    'created_at' => date("Y-m-d H:i:s"),
    'dislikes' =>  0,
    'likes' =>  0,
    'is_active' => 1
];

if (strip_tags($_POST['replyContent']) != "") {

    if ($Replies->add($newDataset)) {
        $error = array('status' => 'success', 'message' => 'Replied successfully.');
    } else {
        $error = array('status' => 'error', 'message' => 'Failed to Save Reply.' . $Replies->getLastError());
    }
} else {
    $error = array('status' => 'error', 'message' => 'Please add content');
}
echo json_encode($error);
