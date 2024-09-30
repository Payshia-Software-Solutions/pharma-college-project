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
$forum = $Topics->fetchAll('id', 'DESC');
$currentPage = 0;
$userLevel = $_POST['UserLevel'];
?>
<div class="row g-3 my-2">
    <?php include './components/fullSideBar.php' ?>

    <div class="col-12 col-md-9">
        <div class="row g-3">
            <div class="col-12 mb-2">
                <button onclick="NewThread()" class="btn btn-primary btn-lg rounded-5 w-100"> Add New thread <i
                        class="fa-solid fa-plus"></i></button>
            </div>
            <div class="col-12">
                <div class="row g-3" id="content"></div>
                <div class="text-center bg-light p-3" id="loading">Loading...</div>
            </div>

            <script src="./lib/forum/assets/js/infiniteScroll.js"></script>


        </div>
    </div>
</div>