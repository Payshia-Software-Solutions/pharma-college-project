<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../../include/configuration.php';
require_once '../../php_handler/function_handler.php';

// Include Classes
include_once './classes/Database.php';
include_once './classes/Topics.php';
include_once './classes/Replies.php';


// Create a new Database object with the path to the configuration file
$config_file = '../../include/env.txt';
$database = new Database($config_file);
$db = $database->getConnection();

$Topics = new Topics($database);
$forum = $Topics->fetchAll('id', 'DESC');
$currentPage = 2;

$sidebarHtml = renderTemplate('components/sideBar.php', [
    'currentPage' => $currentPage,
]);

$loggedUser = $_POST['LoggedUser'];
$Replies = new Replies($database);
$topicsByUser = $Topics->fetchAllByUser($loggedUser);
$solvedTopicsByUser = $Topics->fetchAllSolvedByUser($loggedUser);
$replyListByUser = $Replies->fetchAllByUser($loggedUser);
$userLevel = $_POST['UserLevel'];
?>
<div class="row g-3 my-2">
    <?php include './components/fullSideBar.php' ?>

    <div class="col-12 col-md-9">

        <div class="row g-3">
            <div class="col-12">
                <div class="row g-2">
                    <div class="col-6 col-md-4">
                        <div class="card rounded-4 shadow-sm border-0">
                            <div class="card-body">
                                <h1 class="mb-0 fw-bold"><?= count($topicsByUser) ?></h1>
                                <p class="mb-0 text-muted">Asked</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-4">
                        <div class="card rounded-4 shadow-sm border-0">
                            <div class="card-body">
                                <h1 class="mb-0 fw-bold"><?= count($solvedTopicsByUser) ?></h1>
                                <p class="mb-0 text-muted">Solved</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="card rounded-4 shadow-sm border-0">
                            <div class="card-body">
                                <h1 class="mb-0 fw-bold"><?= count($replyListByUser) ?></h1>
                                <p class="mb-0 text-muted">Answered</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-12 mb-2">
                <button onclick="NewThread()" class="btn btn-primary btn-lg rounded-5 w-100"> Add New thread <i class="fa-solid fa-plus"></i></button>
            </div>

            <div class="col-12">
                <div class="row g-3" id="content"></div>
                <div class="text-center bg-light p-3" id="loading">Loading...</div>
            </div>

            <script src="./lib/forum/assets/js/infiniteScroll-mypost.js"></script>


        </div>
    </div>
</div>