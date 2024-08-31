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
    'current_status' => $_POST['updateStatus']
];

if ($Topics->update($newDataset, $_POST['postId'])) {
    $error = array('status' => 'success', 'message' => 'Status Updated successfully.');
} else {
    $error = array('status' => 'error', 'message' => 'Failed to Save Topic.' . $Topics->getLastError());
}

echo json_encode($error);
