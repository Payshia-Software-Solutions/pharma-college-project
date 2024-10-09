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

$LoggedUser = $_POST['LoggedUser'];

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
<style>
.star-rating {
    display: flex;
    justify-content: flex-start;
    /* Align stars to the left */
    direction: rtl;
    /* Change the direction to right-to-left to handle the hover correctly */
}

.star-rating .fa-star {
    font-size: 20px;
    cursor: pointer;
    color: lightgray;
    /* Default star color */
    direction: ltr;
    /* Reset direction for the stars themselves */
}

.star-rating .fa-star.checked {
    color: gold;
    /* Color checked stars */
}

/* Color the hovered star and all previous stars (to the left) */
.star-rating .fa-star:hover,
.star-rating .fa-star:hover~.fa-star {
    color: lightgray;
    /* Reset the stars to the right of the hovered star */
}

.star-rating .fa-star:hover,
.star-rating .fa-star:hover~.fa-star {
    color: gold;
    /* Highlight hovered star and previous stars */
}
</style>
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
                            <div class="star-rating" data-reply-id="<?= $selectedArray['id'] ?>"
                                data-user-rating="<?= $userRating ?>">
                                <!-- Create 5 stars, applying the user's rating if available -->
                                <?php for ($i = 1; $i <= 5; $i++) : ?>
                                <span class="fa fa-star <?= ($i <= $userRating) ? 'checked' : '' ?>"
                                    data-rating="<?= 6 - $i ?>"></span>
                                <?php endfor; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endforeach ?>

<script>
$(document).ready(function() {
    const starRatings = document.querySelectorAll(".star-rating");

    starRatings.forEach(function(starRating) {
        const replyId = starRating.getAttribute("data-reply-id");
        const LoggedUser = '<?= $LoggedUser ?>';

        // Add event listener for each star in the rating
        const stars = starRating.querySelectorAll(".fa-star");
        stars.forEach(function(star) {
            star.addEventListener("click", function(e) {
                showOverlay();
                const rating = e.target.getAttribute("data-rating");
                // Use fetch to send a request to a PHP script that handles the rating update via HttpClient
                fetch('./lib/forum/controllers/update-rating.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            reply_id: replyId,
                            user_id: LoggedUser,
                            ratings: rating,
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.message === 'Record updated successfully') {
                            highlightStars(starRating, rating);
                        }
                        hideOverlay();
                    })
                    .catch(error => console.error('Error:', error));

            });
        });

        // Set the initial rating
        function highlightStars(starRating, rating) {
            const stars = starRating.querySelectorAll(".fa-star");
            stars.forEach(function(star, index) {
                if (index < rating) {
                    star.classList.add("checked");
                } else {
                    star.classList.remove("checked");
                }
            });
        }

        highlightStars(starRating, starRating.getAttribute('data-user-rating'));
    });
});
</script>