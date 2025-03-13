<?php
require __DIR__ . '/../../../../vendor/autoload.php';

// For use env file data
use Dotenv\Dotenv;
use Symfony\Component\HttpClient\HttpClient;

// Load environment variables
$dotenv = Dotenv::createImmutable(dirname(__DIR__, 4)); // Go up 5 directories
$dotenv->load();

// Parameters
$LoggedUser = $_POST['LoggedUser'];
$courseCode = $_POST['courseCode'];
$defaultLocation = $_POST['defaultLocation'];

// Initialize HTTP client
$client = HttpClient::create();

// Get all courses from the API and decode the response
$response = $client->request('GET', "{$_ENV["MS_COURSE_SRL"]}/api/{$_ENV["API_VERSION"]}/games", [
    'headers' => [
        'Authorization' => "Bearer {$_ENV["API_KEY"]}",
    ],
]);
$gameData = $response->toArray();


// Get all courses from the API and decode the response
$response = $client->request('GET', "{$_ENV["MS_COURSE_SRL"]}/api/{$_ENV["API_VERSION"]}/courses/{$courseCode}");
$courseData = $response->toArray();

$installedGames = $courseData['Games'];

// Ensure both are arrays
if (!is_array($gameData) || !is_array($installedGames)) {
    die("Invalid data structure.");
}

// Extract game IDs from both arrays
$allGameIds = array_column($gameData, 'id');
$installedGameIds = array_column($installedGames, 'id');

// Find the not installed game IDs
$notInstalledGameIds = array_diff($allGameIds, $installedGameIds);

// Filter the not installed games from $gameData
$notInstalledGames = array_filter($gameData, function ($game) use ($notInstalledGameIds) {
    return in_array($game['id'], $notInstalledGameIds);
});

// Re-index the array to prevent gaps in keys
$notInstalledGames = array_values($notInstalledGames);
?>

<style>
    .hover-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        overflow: hidden;
    }

    .cursor-pointer {
        cursor: pointer;
    }

    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }
</style>
<div class="loading-popup-content">
    <div class="row">
        <div class="col-10">
            <h3 class="site-title mb-0">New Game</h3>
        </div>

        <div class="col-2 text-end">
            <button class="btn btn-sm btn-light rounded-5" onclick="ClosePopUP()"><i class="fa-solid fa-xmark"></i></button>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-12">
            <div class="border-bottom border-3 my-2"></div>
        </div>

        <div class="col-6">
            <div class="table-title font-weight-bold mt-0">Available Games</div>

            <div class="row g-3 mt-2">
                <?php
                if (!empty($notInstalledGames)) :
                    foreach ($notInstalledGames as $SelectArray) :
                ?>
                        <div class="col-12 col-md-6">
                            <div class="card hover-card cursor-pointer" onclick="customShowMoqPopup(<?= $SelectArray['id'] ?>, '<?= $courseCode ?>')">
                                <div class="card-body">
                                    <h4><?= $SelectArray['game_title'] ?></h4>
                                </div>
                            </div>
                        </div>
                <?php
                    endforeach;
                endif;
                ?>
            </div>
        </div>
        <div class="col-6">
            <div class="table-title font-weight-bold mt-0">Installed Games</div>

            <div class="row g-3 mt-2">
                <?php
                if (!empty($installedGames)) :
                    foreach ($installedGames as $SelectArray) :
                ?>
                        <div class="col-12 col-md-6">
                            <div class="card hover-card cursor-pointer" onclick="removeGameToCourse('<?= $courseCode ?>', <?= $SelectArray['id'] ?>)">
                                <div class="card-body">
                                    <h4><?= $SelectArray['game_title'] ?></h4>
                                </div>
                            </div>
                        </div>
                <?php
                    endforeach;
                endif;
                ?>
            </div>
        </div>
    </div>
</div>

<!-- Simple MOQ Input Modal -->
<div id="custom-moqModal" class="custom-modal">
    <div class="custom-modal-content">
        <span class="custom-close" onclick="customCloseMoqPopup()">&times;</span>
        <h3>Enter MOQ for the Game</h3>
        <input type="number" id="custom-moqInput" class="custom-input" placeholder="Enter MOQ" min="1">
        <input type="hidden" id="custom-selectedGameId">
        <input type="hidden" id="custom-selectedCourseCode">
        <button class="custom-btn" onclick="customSubmitMoq()">Add Game</button>
    </div>
</div>

<style>
    /* Custom Modal Styles */
    .custom-modal {
        display: none;
        /* Hidden by default */
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
    }

    .custom-modal-content {
        background-color: white;
        margin: 15% auto;
        padding: 20px;
        border-radius: 8px;
        width: 320px;
        text-align: center;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .custom-close {
        float: right;
        font-size: 22px;
        font-weight: bold;
        cursor: pointer;
    }

    .custom-input {
        width: 90%;
        padding: 8px;
        margin: 10px 0;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .custom-btn {
        background-color: #28a745;
        color: white;
        border: none;
        padding: 10px;
        cursor: pointer;
        width: 100%;
        border-radius: 5px;
        font-size: 16px;
    }

    .custom-btn:hover {
        background-color: #218838;
    }
</style>