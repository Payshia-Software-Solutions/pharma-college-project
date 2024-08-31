<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../../../include/configuration.php';
require_once '../../../php_handler/function_handler.php';

// Include Classes
include_once '../classes/Database.php';
include_once '../classes/Categories.php';

// Create a new Database object with the path to the configuration file
$config_file = '../../../include/env.txt';
$database = new Database($config_file);
$db = $database->getConnection();

$Categories = new Categories($database);

$categoryId = $_POST['categoryId'];
$newDataset = [
    'category_name' => $_POST['category_name'],
    'bg_color' => $_POST['label_color'],
    'is_active' => 1,
    'created_by' => $_POST['loggedUser'],
    'created_at' =>  date("Y-m-d H:i:s"),
];

if ($categoryId == 0) {

    if ($Categories->add($newDataset)) {
        $error = array('status' => 'success', 'message' => 'Category Saved successfully.');
    } else {
        $error = array('status' => 'error', 'message' => 'Failed to Save Topic.' . $Replies->getLastError());
    }
} else {

    if ($Categories->update($newDataset, $categoryId)) {
        $error = array('status' => 'success', 'message' => 'Category Updated successfully.');
    } else {
        $error = array('status' => 'error', 'message' => 'Failed to Save Topic.' . $Replies->getLastError());
    }
}

echo json_encode($error);
