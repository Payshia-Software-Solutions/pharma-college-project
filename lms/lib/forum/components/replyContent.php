<!-- reply_content.php -->
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require __DIR__ . '/../../../vendor/autoload.php';

use Carbon\Carbon;

// For use env file data
use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__ . '../../../../');
$dotenv->load();

use Symfony\Component\HttpClient\HttpClient;

$client = HttpClient::create();

$LoggedUser = $_POST['LoggedUser'];

// Get reply from server
$response = $client->request('GET', $_ENV["SERVER_URL"] . '/community-post-reply/' . $postId . '/' . $LoggedUser);
$replyList = $response->toArray();

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
?>

<style>
.star-rating {
    display: flex;
    justify-content: flex-end;
    /* Align stars to the left */
}

.star-rating .fa-star {
    font-size: 20px;
    cursor: pointer;
    color: lightgray;
    /* Default star color */
    transition: color 0.2s ease;
    /* Smooth color transition */
}

.star-rating .fa-star.checked {
    color: gold;
    /* Color for checked stars */
}

/* Color the hovered star and all previous stars (to the left) */
.star-rating .fa-star:hover,
.star-rating .fa-star:hover~.fa-star {
    color: gold;
    /* Highlight hovered star and previous stars */
}

/* Ensure that only the left side of the hovered star is highlighted */
.star-rating .fa-star:hover~.fa-star {
    color: lightgray;
    /* Reset stars to the right of the hovered star */
}
</style>

<?php foreach ($replyList as $selectedArray) : ?>
<div class="col-12">
    <div class="card rounded-4 shadow border-0">
        <div class="card-body p-4">
            <div class="row g-2">
                <div class="col-12 col-md-8">
                    <h5 class="mb-0"><?= htmlspecialchars($selectedArray['created_by']) ?></h5>
                    <p class="mb-0 text-muted"><?= htmlspecialchars($selectedArray['time_ago']) ?></p>
                </div>
                <div class="col-12"><?= $selectedArray['reply_content'] ?></div>
                <div class="col-12">
                    <button class="btn btn-light rounded-3"><i class="fa-solid fa-comment text-secondary"></i>
                        Comment</button>
                    <!-- Rating section -->
                    <div class="rating">
                        <div class="star-rating" data-reply-id="<?= htmlspecialchars($selectedArray['id']) ?>"
                            data-user-rating="<?= htmlspecialchars($selectedArray['user_rating']) ?>">
                            <!-- Create 5 stars, applying the user's rating if available -->
                            <?php for ($i = 1; $i <= 5; $i++) : ?>
                            <span class="fa fa-star <?= ($i <= $selectedArray['user_rating']) ? 'checked' : '' ?>"
                                data-rating="<?= $i ?>"></span>
                            <?php endfor; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>

<script>
$(document).ready(function() {
    const starRatings = document.querySelectorAll(".star-rating");

    starRatings.forEach(function(starRating) {
        const replyId = starRating.getAttribute("data-reply-id");
        const LoggedUser = '<?= $LoggedUser ?>';

        // Add event listener for each star in the rating
        const stars = starRating.querySelectorAll(".fa-star");
        stars.forEach(function(star) {
            star.addEventListener("mouseover", function() {
                highlightStars(starRating, star.getAttribute(
                    "data-rating")); // Highlight stars on hover
            });

            star.addEventListener("mouseout", function() {
                highlightStars(starRating, starRating.getAttribute(
                    'data-user-rating')); // Reset to user rating on mouse out
            });

            star.addEventListener("click", function(e) {
                showOverlay();
                const rating = e.target.getAttribute("data-rating");

                // Send a request to a PHP script that handles the rating update via HttpClient
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
                            highlightStars(starRating,
                                rating); // Update the star visuals after success
                        }
                        window.location.reload(); // Reload to reflect changes
                        hideOverlay();
                    })
                    .catch(error => console.error('Error:', error));
            });
        });

        // Function to highlight stars based on the rating
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

        // Set the initial rating (user's previous rating)
        highlightStars(starRating, starRating.getAttribute('data-user-rating'));
    });
});
</script>