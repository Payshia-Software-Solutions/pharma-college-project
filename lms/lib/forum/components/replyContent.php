<!-- reply_content.php -->
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require __DIR__ . '/../../../vendor/autoload.php';

use Carbon\Carbon;

// Include Classes
include_once './classes/Database.php';
include_once './classes/Topics.php';
include_once './classes/Categories.php';
include_once './classes/Replies.php';

// Create a new Database object with the path to the configuration file
$config_file = '../../include/env.txt';
$database = new Database($config_file);
$db = $database->getConnection();

$Categories = new Categories($database);
$Replies = new Replies($database);

$CategoriesList = $Categories->fetchAll();
$replyList = $Replies->fetchAllByPost($postId);
?>

<?php foreach ($replyList as $key => $selectedArray) :

    $submitted_time = $selectedArray['created_at'];
    $carbonInstance = Carbon::parse($submitted_time); // Parse the datetime string to a Carbon instance
    $timestamp = $carbonInstance->timestamp; // Get the Unix timestamp
    $submittedTime = Carbon::createFromTimestamp($timestamp); // Convert the timestamp to a Carbon instance
    $timeAgo = $submittedTime->diffForHumans(); // Get the difference from now in a human-readable format
?>
<div class="col-12">
    <div class="card rounded-4 shadow border-0">
        <div class="card-body p-4">

            <div class="row g-2">
                <div class="col-12 col-md-8">
                    <h5 class="mb-0"><?= $selectedArray['created_by'] ?></h5>
                    <p class="mb-0 text-muted"><?= $timeAgo ?></p>
                </div>
                <div class="col-12"><?= $selectedArray['reply_content'] ?>
                </div>
                <div class="col-12">
                    <button class="btn btn-light rounded-3"><i class="fa-solid fa-comment text-secondary"></i>
                        Comment</button>
                    <!-- rating section -->
                    <div class="col-12">
                        <div class="rating">
                            <div data-coreui-toggle="rating" data-coreui-tooltips="Very bad, Bad, Meh, Good, Very good"
                                data-coreui-value="3"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endforeach ?>