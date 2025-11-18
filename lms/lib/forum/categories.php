<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../../include/configuration.php';
require_once '../../php_handler/function_handler.php';
require '../../vendor/autoload.php';
// Include Classes
include_once './classes/Database.php';
include_once './classes/Topics.php';
include_once './classes/Categories.php';

//for use env file data
use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__ . '../../../');
$dotenv->load();

use Symfony\Component\HttpClient\HttpClient;
$client = HttpClient::create();

$response = $client->request('GET', $_ENV["SERVER_URL"] .'/community-post/topics-count/');
$postDetailList = $response->toArray();

// Create a new Database object with the path to the configuration file
$config_file = '../../include/env.txt';
$database = new Database($config_file);
$db = $database->getConnection();

$Topics = new Topics($database);
$forum = $Topics->fetchAll('id', 'DESC');
$currentPage = 'categories';
$userLevel = $_POST['UserLevel'];

$Categories = new Categories($database);
$categoryList = $Categories->fetchAll();
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
            <div class="col-6 col-md-4 d-flex">
                <div class="card rounded-1 clickable knowledge-card flex-fill bg-light p-2"
                    onclick="OpenNewCategoryForm()">
                    <div class="card-body bg-white d-flex align-items-center justify-content-center">
                        <h4 class="mb-0 knowledge-title text-secondary">
                            + Add New
                        </h4>
                    </div>
                </div>
            </div>

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

        </div>
    </div>
</div>