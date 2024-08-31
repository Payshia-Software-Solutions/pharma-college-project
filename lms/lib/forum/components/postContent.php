<!-- forum_content.php -->
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require __DIR__ . '/../../../vendor/autoload.php';

use Carbon\Carbon;

require_once '../../include/configuration.php';
require_once '../../php_handler/function_handler.php';

// Include Classes
include_once './classes/Database.php';
include_once './classes/Topics.php';
include_once './classes/Categories.php';

// Create a new Database object with the path to the configuration file
$config_file = '../../include/env.txt';
$database = new Database($config_file);
$db = $database->getConnection();

$Categories = new Categories($database);
$CategoriesList = $Categories->fetchAll();

$submitted_time = $selectArray['submitted_time'];
$carbonInstance = Carbon::parse($submitted_time); // Parse the datetime string to a Carbon instance
$timestamp = $carbonInstance->timestamp; // Get the Unix timestamp
$submittedTime = Carbon::createFromTimestamp($timestamp); // Convert the timestamp to a Carbon instance
$timeAgo = $submittedTime->diffForHumans(); // Get the difference from now in a human-readable format
?>

<style>
    .post-content img {
        max-width: 100% !important;
    }

    #share-button {
        padding: 10px 20px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    #share-button:hover {
        background-color: #45a049;
    }

    #message {
        margin-top: 10px;
        color: green;
    }
</style>
<div class="col-12 text-end">
    <button class="btn btn-light btn-lg rounded-0" type="button"><i class="fa-solid fa-check"></i> Mark as Solved</button>
</div>
<div class="col-12">
    <div class="card rounded-4 shadow border-0">
        <div class="card-body p-4">

            <div class="row g-2">
                <div class="col-2 col-md-1">
                    <img src="./lib/forum/assets/images/mentorship.gif" class="w-100" alt="">
                </div>
                <div class="col-10 col-md-8">
                    <h4 class="mb-0"><?= $selectArray['user_account'] ?></h4>
                    <p class="mb-0 text-muted"><?= $timeAgo ?></p>
                </div>
                <div class="col-md-3">
                    <div class="badge bg-primary rounded-5"><?= $CategoriesList[$selectArray['category']]['category_name'] ?></div>
                </div>
                <div class="col-12">
                    <h4 class="fw-bold text-black mb-3"><?= $selectArray['title'] ?></h4>
                </div>

                <div class="col-12 post-content">
                    <?= $selectArray['content'] ?>
                </div>
                <div class="col-12">
                    <button class="btn btn-light rounded-3"><i class="fa-solid fa-bookmark text-secondary"></i></button>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-2 g-2">
        <?php
        $postContent = renderTemplate('components/replyContent.php', [
            'postId' => $selectArray['id']
        ]);
        echo $postContent;
        ?>
    </div>

    <div class="row my-2">
        <div class="col-12 text-end">
            <button id="share-button">Copy Post URL</button>
            <p id="message"></p>
        </div>
    </div>


    <div class="card border-0 mt-4">
        <div id="summernote"></div>
        <script>
            $(document).ready(function() {
                $('#summernote').summernote({
                    placeholder: 'What you think about this?',
                    height: 200,
                    toolbar: [
                        ['style', ['style']],
                        ['font', ['bold', 'underline', 'clear']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['table', ['table']],
                        ['insert', ['link', 'picture', 'video']],
                        ['view', ['codeview', 'help']]
                    ]
                });
            });
        </script>

        <div class="row mt-3">
            <div class="col-12 text-end">
                <button type="button" onclick="SavePostReply('<?= $selectArray['id'] ?>')" class="btn btn-dark btn-sm"><i class="fa-solid fa-floppy-disk"></i> Save Reply</button>
            </div>
        </div>

    </div>
</div>

<script>
    document.getElementById('share-button').addEventListener('click', function() {
        const url = window.location.href;
        if (navigator.share) {
            navigator.share({
                title: document.title,
                url: url
            }).then(() => {
                const messageElement = document.getElementById('message');
                messageElement.textContent = 'Thanks for sharing!';
            }).catch((error) => {
                console.error('Error sharing:', error);
                const messageElement = document.getElementById('message');
                messageElement.textContent = 'Error sharing the URL.';
            });
        } else {
            // Fallback for browsers that do not support the Web Share API
            navigator.clipboard.writeText(url).then(function() {
                const messageElement = document.getElementById('message');
                messageElement.textContent = 'URL copied to clipboard!';
            }, function(err) {
                console.error('Could not copy text: ', err);
                const messageElement = document.getElementById('message');
                messageElement.textContent = 'Error copying the URL.';
            });
        }
    });
</script>