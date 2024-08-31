<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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

$offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
$orderBy = isset($_GET['orderBy']) ? $_GET['orderBy'] : null;
$orderDirection = isset($_GET['orderDirection']) ? $_GET['orderDirection'] : 'ASC';

$forum = $Topics->fetchLimitedAll($offset, $limit, $orderBy, $orderDirection);

$forumCards = [];
foreach ($forum as $key => $selectArray) {
    $forumCards[] = renderTemplate('../components/forumTopic.php', [
        'selectArray' => $selectArray,
        'key' => $selectArray['id']
    ]);
}

header('Content-Type: application/json');
echo json_encode($forumCards);
