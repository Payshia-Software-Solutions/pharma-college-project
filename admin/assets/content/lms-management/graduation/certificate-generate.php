<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include '../../../../include/function-update.php';
include '../../../../include/lms-functions.php';
require __DIR__ . '/../../../../vendor/autoload.php';
define('PARENT_SEAT_RATE', 500); // example value

// For use env file data
use Dotenv\Dotenv;
use Symfony\Component\HttpClient\HttpClient;

// Load environment variables
$dotenv = Dotenv::createImmutable(dirname(__DIR__, 4));
$dotenv->load();

// Initialize HTTP client
$client = HttpClient::create();

// Fetch logged-in user data (if needed)
$LoggedUser = $_POST['LoggedUser'];
$UserLevel = $_POST['UserLevel'];

// Fetch graduation packages, bookings, and main courses
$graduationPackages = $client->request('GET', $_ENV["SERVER_URL"] . '/packages/')->toArray();
$packageBookings = $client->request('GET', $_ENV['SERVER_URL'] . '/convocation-registrations')->toArray();
$mainCourses = $client->request('GET', $_ENV['SERVER_URL'] . '/parent-main-course')->toArray();

$indexed_courses = [];
foreach ($mainCourses as $course) {
    $indexed_courses[$course['id']] = $course;
}
?>

<div class="row mt-5">
    <div class="col-md-6 col-lg-3 d-flex">
        <div class="card item-card flex-fill">
            <div class="overlay-box">
                <i class="fa-solid fa-chart-line icon-card"></i>
            </div>
            <div class="card-body">
                <p>Packages</p>
                <h1><?= count($graduationPackages) ?></h1>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3 d-flex">
        <div class="card item-card flex-fill">
            <div class="overlay-box">
                <i class="fa-solid fa-chart-line icon-card"></i>
            </div>
            <div class="card-body">
                <p>Bookings</p>
                <h1><?= count($packageBookings) ?></h1>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3 d-flex">
        <div class="card item-card flex-fill">
            <div class="overlay-box">
                <i class="fa-solid fa-chart-line icon-card"></i>
            </div>
            <div class="card-body">
                <p>By Courier</p>
                <h1></h1>
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-12 text-end">
        <button class="btn btn-dark btn-sm" type="button" onclick="OpenCertificateGeneratePage()">Reload Certificate</button>
    </div>
</div>



<div class="row g-2 mt-3">
    <!-- Left Column - Course Selection -->
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title mb-4">Please choose the Course</h1>
                    <div class="mb-3">
                        <label for="courseSelect" class="form-label">Select Course</label>
                        <select class="form-select" id="courseSelect">
                            <option value="">-- Choose a Course --</option>
                            <?php foreach ($indexed_courses as $course): ?>
                                <option value="<?= $course['id'] ?>"><?= $course['id'] ?> - <?= $course['course_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Session Selection -->
                    <div class="session-section mt-2" id="sessionSection">
                        <label for="sessionDropdown">Select Session</h5>
                            <select class="form-select" id="sessionDropdown">
                                <option value="">-- Choose a Session --</option>
                                <option value="1">Session 1</option>
                                <option value="2">Session 2</option>
                            </select>

                            <!-- Trigger Button -->
                            <button class="btn btn-primary w-100 mt-4" onclick="triggerOpenTable()">Open Certificate Table</button>
                    </div>
            </div>
        </div>
    </div>


    <div class="col-md-9" id="certification-table"></div>


</div>
<script>



</script>