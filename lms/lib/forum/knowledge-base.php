<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../../include/configuration.php';
require_once '../../php_handler/function_handler.php';
require '../../vendor/autoload.php';

// Include Classes
include_once './classes/Database.php';
include_once './classes/Categories.php';
include_once './classes/Topics.php';


//for use env file data
use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__ . '../../../');
$dotenv->load();

use Symfony\Component\HttpClient\HttpClient;
$client = HttpClient::create();

$response = $client->request('GET', $_ENV["SERVER_URL"] .'/community-post/topics-count/');
$response2 = $client->request('GET', $_ENV["SERVER_URL"] .'community-knowledgebase/');
$postDetailList = $response->toArray();
$adminPostList = $response2->toArray();


// Create a new Database object with the path to the configuration file
$config_file = '../../include/env.txt';
$database = new Database($config_file);
$db = $database->getConnection();

$Topics = new Topics($database);
$forum = $Topics->fetchAll('id', 'DESC');
$currentPage = 1;

$sidebarHtml = renderTemplate('components/sideBar.php', [
    'currentPage' => $currentPage,
]);

$Categories = new Categories($database);
$categoryList = $Categories->fetchAll();

$knowledgeTopics = ['Lorem ipsum dolor sit amet consectetur adipisicing elit.', 'Lorem ipsum dolor sit amet consectetur adipisicing elit.', 'Lorem ipsum dolor sit amet consectetur adipisicing elit.', 'Lorem ipsum dolor sit amet consectetur adipisicing elit.', 'Lorem ipsum dolor sit amet consectetur adipisicing elit.', 'Lorem ipsum dolor sit amet consectetur adipisicing elit.', 'Lorem ipsum dolor sit amet consectetur adipisicing elit.'];
$userLevel = $_POST['UserLevel'];
?>

<style>
.knowledge-title {
    position: relative;
    display: inline-block;
}

.rectangle {
    display: inline-block;
    background-color: var(--bg-color);
    width: 10px;
    height: 10px;
    margin-right: 5px;
}

.knowledge-card:hover {
    background-color: #f7f7f5;
    transform: translateY(-2px);
}
</style>
<div class="row g-3 my-2">
    <?php include './components/fullSideBar.php' ?>

    <div class="col-12 col-md-9">
        <div class="row g-3">

            <?php foreach ($postDetailList as $selectArray) : ?>
            <div class="col-6 col-md-4 d-flex">
                <div class="card rounded-1 clickable knowledge-card flex-fill">
                    <div class="card-body">
                        <h4 class="mb-0 knowledge-title"
                            style="--bg-color: <?= htmlspecialchars($selectArray['bg_color']) ?>;">
                            <span class="rectangle"></span>
                            <?= htmlspecialchars($selectArray['category_name']) ?>
                        </h4>
                        <p class="mb-0 text-muted"><?= $selectArray['post_count'] ?> Topics</p>
                    </div>
                </div>
            </div>
            <?php endforeach ?>

            <div class="col-12">
                <div class="card bg-light rounded-0">
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-md-6 offset-md-3">
                                <input type="text" name="search-topic" id="search-topic"
                                    class="form-control rounded-0 p-3" placeholder="Search Topics">
                                <?php if($userLevel == 'Admin') { ?>
                                <div class="col-12 mb-2 mt-3">
                                    <button onclick="NewAdminThread()" class="btn btn-primary btn-lg rounded-5 w-100">
                                        Add
                                        New thread <i class="fa-solid fa-plus"></i></button>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="row g-2">
                    <?php foreach ($adminPostList as $topic) : ?>
                    <div class="col-md-10">
                        <h5 class="mb-0"><a href="#" target="_blank"
                                class="text-decoration-none text-dark"><?= htmlspecialchars($topic['title']) ?></a></h5>
                        <p class="text-muted mb-0" style="--bg-color: <?= htmlspecialchars($topic['bg_color']) ?>;">
                            <span class="rectangle"></span> <?= htmlspecialchars($topic['category_name']) ?>
                        </p>

                    </div>
                    <div class="col-md-2">
                        <p class="text-muted mb-0 text-end"><?= $topic['days_ago'] ?></p>

                    </div>
                    <div class="col-12">
                        <?php if($userLevel == 'Admin') { ?>
                        <div class="d-flex justify-content-end">
                            <button onclick="ClickDeleteAdminTopic(<?= $topic['id'] ?>)"
                                class="btn btn-danger btn-sm px-2 ">Delete</button>
                            <button class="btn btn-secondary btn-sm px-4">Edit</button>
                        </div>
                        <?php } ?>
                        <div class="border-bottom my-3"></div>
                    </div>
                    <?php endforeach ?>
                </div>
            </div>
        </div>

    </div>

</div>