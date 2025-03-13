<?php
require __DIR__ . '/../../../../vendor/autoload.php';

// For use env file data
use Dotenv\Dotenv;
use Symfony\Component\HttpClient\HttpClient;

// Load environment variables
$dotenv = Dotenv::createImmutable(dirname(__DIR__, 4)); // Go up 5 directories
$dotenv->load();

// Parameters
$courseCode = $_POST['courseCode'];
$LoggedUser = $_POST['LoggedUser'];
$defaultLocation = $_POST['defaultLocation'];

// Initialize HTTP client
$client = HttpClient::create();

// Get all courses from the API and decode the response
$response = $client->request('GET', "{$_ENV["MS_COURSE_SRL"]}/api/{$_ENV["API_VERSION"]}/courses/{$courseCode}");
$courseData = $response->toArray();

?>


<div class="loading-popup-content-right <?= htmlspecialchars($userTheme) ?> ">
    <div class="row">
        <div class="col-6">
            <h3 class="mb-0"><?= $courseData['courseName'] ?></h3>
        </div>
        <div class="col-6 text-end">
            <button class="btn btn-dark btn-sm" onclick="setupCourse('<?= $courseCode ?>')" type="button"><i class="fa solid fa-rotate-left"></i> Reload</button>
            <button class="btn btn-light btn-sm" onclick="ClosePopUPRight(1)" type="button"><i class="fa solid fa-xmark"></i> Close</button>
        </div>
        <div class="col-12">
            <div class="border-bottom border-5 my-2"></div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 text-end mb-2">
            <button class="btn btn-dark" onclick="AssignGamesToCourse('<?= $courseCode ?>')"><i class="fa solid fa-plus"></i> Add Games</button>
            <button class="btn btn-dark" onclick="AddEvaluationsToCourse('<?= $courseCode ?>')"><i class="fa solid fa-plus"></i> Add Evaluation</button>
        </div>

        <div class="col-6">
            <div class="table-title font-weight-bold mt-0">Games</div>

            <div class="row g-3 mt-1">
                <?php
                $gameList = $courseData['Games'];
                if (!empty($gameList)) :
                    foreach ($gameList as $game) :
                ?>
                        <div class="col-12 col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h4><?= $game['game_title'] ?></h4>
                                    <p class="mb-0">MOQ : <?= $game['CourseGame']['minQuantity'] ?></p>
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
            <div class="table-title font-weight-bold mt-0">Assignments</div>
            <div class="row g-3 mt-1">
                <?php
                $evaluationsList = $courseData['Evaluations'];
                if (!empty($evaluationsList)) :
                    foreach ($evaluationsList as $evaluation) :
                ?>
                        <div class="col-12 col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h4><?= $evaluation['criteria_type'] ?></h4>
                                    <p class="mb-0">MOQ : <?= $evaluation['criteria_value'] ?></p>
                                    <div class="row">
                                        <div class="col-12 text-end">
                                            <button class="btn btn-sm btn-light" onclick="DeleteEvaluation('<?= $evaluation['id'] ?>', '<?= $courseCode ?>')"><i class="fa solid fa-trash"></i></button>
                                        </div>
                                    </div>
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