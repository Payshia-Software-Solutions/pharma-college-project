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

?>

<div class="loading-popup-content">
    <div class="row">
        <div class="col-10">
            <h3 class="site-title mb-0">New Evaluations</h3>
        </div>

        <div class="col-2 text-end">
            <button class="btn btn-sm btn-light rounded-5" onclick="ClosePopUP()"><i class="fa-solid fa-xmark"></i></button>
        </div>
    </div>

    <div class="row">
        <form id="evaluationForm">
            <div class="mb-3">
                <label for="criteriaType" class="form-label">Criteria Type</label>
                <input type="text" class="form-control" id="criteriaType" name="criteria_type" required>
            </div>
            <div class="mb-3">
                <label for="criteriaValue" class="form-label">Criteria Value</label>
                <input type="text" class="form-control" id="criteriaValue" name="criteria_value" required>
            </div>
            <div class="mb-3">
                <label for="weight" class="form-label">Weight</label>
                <input type="number" step="0.01" class="form-control" id="weight" name="weight" required>
            </div>
            <input type="hidden" name="courseId" value="<?php echo $courseData['id']; ?>">
            <button type="button" onclick="SaveEvaluationToCourse('<?= $courseData['id'] ?>')" class="btn btn-primary">Submit</button>
        </form>

    </div>
</div>