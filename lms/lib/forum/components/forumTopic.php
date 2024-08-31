<!-- forum_template.php -->
<?php
require __DIR__ . '/../../../vendor/autoload.php';

use Carbon\Carbon;

include_once '../classes/Database.php';
include_once '../classes/Categories.php';
include_once '../classes/Replies.php';

// Create a new Database object with the path to the configuration file
$config_file = '../../../include/env.txt';
$database = new Database($config_file);
$db = $database->getConnection();

$Categories = new Categories($database);
$Replies = new Replies($database);

$CategoriesList = $Categories->fetchAll();

$replyList = $Replies->fetchAllByPost($key);


$submitted_time = $selectArray['submitted_time'];
$carbonInstance = Carbon::parse($submitted_time); // Parse the datetime string to a Carbon instance
$timestamp = $carbonInstance->timestamp; // Get the Unix timestamp
$submittedTime = Carbon::createFromTimestamp($timestamp); // Convert the timestamp to a Carbon instance
$timeAgo = $submittedTime->diffForHumans(); // Get the difference from now in a human-readable format
$solveStatus = ($selectArray['current_status'] == 2) ? 'Solved' : 'Not solved';
$solveStatusBgColor = ($selectArray['current_status'] == 2) ? 'success' : 'danger';
?>

<div class="col-12">
    <div class="card rounded-4 shadow border-0">
        <div class="card-body p-4">

            <div class="row g-2">
                <div class="col-2 col-md-1">
                    <img src="./lib/forum/assets/images/mentorship.gif" class="w-100" alt="">
                </div>
                <div class="col-10 col-md-8">
                    <h6 class="mb-0"><?= $selectArray['user_account'] ?></h6>
                    <p class="mb-0 text-muted"><?= $timeAgo ?></p>
                </div>
                <div class="col-md-3">
                    <div class="badge rounded-5" style="background-color: <?= $CategoriesList[$selectArray['category']]['bg_color'] ?>"><?= $CategoriesList[$selectArray['category']]['category_name'] ?></div>
                    <span class="badge bg-<?= $solveStatusBgColor ?> rounded-5"><?= $solveStatus ?></span>
                </div>

                <div class="col-12">
                    <a href="./community-post?id=<?= $selectArray['id'] ?>&title=<?= $selectArray['title'] ?>" style="text-decoration: none;">
                        <h5 class="fw-bold text-black border-bottom pb-2"><?= $selectArray['title'] ?></h5>
                    </a>
                </div>

                <div class="col-12">
                    <a class="text-dark" href="./community-post?id=<?= $selectArray['id'] ?>&title=<?= $selectArray['title'] ?>" style="text-decoration: none;">
                        <?= limitText($selectArray['content'], 200) ?>
                    </a>
                    <div class="border-bottom my-2"></div>
                </div>
                <div class="col-12 d-flex gap-2 flex-wrap justify-content-between">
                    <button class="btn btn-light rounded-3 flex-fill"><i class="fa-solid fa-comment text-secondary"></i> <?= count($replyList) ?> Replies</button>
                    <button class="btn btn-light rounded-3 flex-fill"><i class="fa-solid fa-eye text-secondary"></i> <?= $selectArray['views'] ?> Views</button>

                    <button class="btn btn-light rounded-3 flex-fill"><i class="fa-solid fa-bookmark text-secondary"></i></button>
                    <a class="btn btn-light rounded-3 flex-fill" href="./community-post?id=<?= $selectArray['id'] ?>&title=<?= $selectArray['title'] ?>#response" style="text-decoration: none;">
                        <i class="fa-solid fa-comment text-secondary"></i> Add Response
                    </a>

                </div>
            </div>
        </div>
    </div>
</div>