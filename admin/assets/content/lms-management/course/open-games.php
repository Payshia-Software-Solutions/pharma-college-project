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
$defaultLocation = $_POST['defaultLocation'];

// Initialize HTTP client
$client = HttpClient::create();

// Get all courses from the API and decode the response
$response = $client->request('GET', "{$_ENV["MS_COURSE_SRL"]}/api/{$_ENV["API_VERSION"]}/games", [
    'headers' => [
        'Authorization' => "Bearer {$_ENV["API_KEY"]}",
    ],
]);
$courseData = $response->toArray();
?>


<div class="loading-popup-content-right <?= htmlspecialchars($userTheme) ?> ">
    <div class="row">
        <div class="col-6">
            <h3 class="mb-0">Games</h3>
        </div>
        <div class="col-6 text-end">
            <button class="btn btn-dark btn-sm" onclick="OpenGames()" type="button"><i class="fa solid fa-rotate-left"></i> Reload</button>
            <button class="btn btn-light btn-sm" onclick="ClosePopUPRight(1)" type="button"><i class="fa solid fa-xmark"></i> Close</button>
        </div>
        <div class="col-12">
            <div class="border-bottom border-5 my-2"></div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-12 text-end">
            <button class="btn btn-dark" onclick="OpenAddGame()"><i class="fa solid fa-plus"></i> Add Game</button>
        </div>
        <div class="col-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="gamesTable">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Icon</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($courseData)) {
                            foreach ($courseData as $SelectArray) {
                                $active_status = "Deleted";
                                $color = "warning";
                                if ($SelectArray['is_active'] == 1) {
                                    $active_status = "Active";
                                    $color = "primary";
                                }
                        ?>
                                <tr>
                                    <td><?= htmlspecialchars($SelectArray['game_title']) ?></td>
                                    <td><?= htmlspecialchars($SelectArray['game_description']) ?></td>
                                    <td><img src="<?= htmlspecialchars($SelectArray['icon_path']) ?>" alt="Game Icon" class="img-fluid" style="max-width: 50px;"></td>
                                    <td><span class="badge bg-<?= $color ?>"><?= $active_status ?></span></td>
                                    <td>
                                        <button class="btn btn-sm btn-primary" onclick="editGame(<?= $SelectArray['id'] ?>)">Edit</button>
                                        <button class="btn btn-sm btn-danger" onclick="deleteGame(<?= $SelectArray['id'] ?>)">Delete</button>
                                    </td>
                                </tr>
                            <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="7" class="text-center">No Entries</td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<script>
    $('#gamesTable').DataTable();

    function editGame(id) {
        alert('Edit Game: ' + id);
    }
</script>