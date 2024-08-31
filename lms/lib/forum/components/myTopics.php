<!-- forum_template.php -->
<?php
require __DIR__ . '/../../../vendor/autoload.php';

include_once '../classes/Database.php';
include_once '../classes/Categories.php';

// Create a new Database object with the path to the configuration file
$config_file = '../../../include/env.txt';
$database = new Database($config_file);
$db = $database->getConnection();

$Categories = new Categories($database);
$CategoriesList = $Categories->fetchAll();

$replyList = $Replies->fetchAllByPost($postId);

use Carbon\Carbon;

$submitted_time = $selectArray['submitted_time'];
$carbonInstance = Carbon::parse($submitted_time); // Parse the datetime string to a Carbon instance
$timestamp = $carbonInstance->timestamp; // Get the Unix timestamp
$submittedTime = Carbon::createFromTimestamp($timestamp); // Convert the timestamp to a Carbon instance
$timeAgo = $submittedTime->diffForHumans(); // Get the difference from now in a human-readable format
?>

<div class="col-12">
    <div class="card rounded-4 shadow border-0">
        <div class="card-body p-4">
            <a href="./community-post?id=<?= $selectArray['id'] ?>&title=<?= $selectArray['title'] ?>" style="text-decoration: none;">
                <h5 class="fw-bold text-black mb-3"><?= $selectArray['title'] ?></h5>
            </a>
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
                </div>
                <div class="col-12">
                    <?= limitText($selectArray['content'], 200) ?>
                </div>
                <div class="col-12">
                    <button class="btn btn-light rounded-3"><i class="fa-solid fa-bookmark text-secondary"></i></button>
                    <a href="./community-post?id=<?= $selectArray['id'] ?>&title=<?= $selectArray['title'] ?>#response" style="text-decoration: none;">
                        <button class="btn btn-light rounded-3"><i class="fa-solid fa-comment text-secondary"></i> Add Response</button>
                    </a>
                    <button class="btn btn-light rounded-3"><i class="fa-solid fa-comment text-secondary"></i> Replies</button>
                    <button class="btn btn-light rounded-3"><i class="fa-solid fa-eye text-secondary"></i> Views</button>
                    <button class="btn btn-light rounded-3" type="button"><i class="fa-solid fa-check"></i> Mark as Solved</button>
                </div>
            </div>
        </div>
    </div>
</div>