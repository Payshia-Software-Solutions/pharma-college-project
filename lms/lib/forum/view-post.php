<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../../include/configuration.php';
require_once '../../php_handler/function_handler.php';

// Include Classes
include_once './classes/Database.php';
include_once './classes/Topics.php';

// Create a new Database object with the path to the configuration file
$config_file = '../../include/env.txt';
$database = new Database($config_file);
$db = $database->getConnection();

$Topics = new Topics($database);

$key = $_POST['key'];
$forum = $Topics->fetchById($key);
$currentPage = 0;
$sidebarHtml = renderTemplate('components/sideBar.php', [
    'currentPage' => $currentPage,
]);

$userLevel = $_POST['UserLevel'];
?>
<div class="row g-3 my-2">
    <?php include './components/fullSideBar.php' ?>

    <div class="col-12 col-md-9">

        <div class="row g-3">
            <?php
            $postContent = renderTemplate('components/postContent.php', [
                'selectArray' => $forum
            ]);
            echo $postContent;
            ?>
        </div>
    </div>
</div>