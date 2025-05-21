<?php
require __DIR__ . '/../../../../../vendor/autoload.php';
include '../../../../../include/function-update.php';

// Get User Theme
$userThemeInput = isset($_POST['userTheme']) ? $_POST['userTheme'] : null;
$userTheme = getUserTheme($userThemeInput);


define('PARENT_SEAT_RATE', 500); // example value
// For use env file data
use Dotenv\Dotenv;
use Symfony\Component\HttpClient\HttpClient;

// Load environment variables
$dotenv = Dotenv::createImmutable(dirname(__DIR__, 5));
$dotenv->load();

// Initialize HTTP client
$client = HttpClient::create();
$referenceNumber = $_POST['referenceNumber'];

// Fetch certificate order data from API
$response = $client->request('GET', $_ENV['SERVER_URL'] . '/convocation-registrations/' . $referenceNumber);
$packageBooking = $response->toArray();

$response = $client->request('GET', $_ENV['SERVER_URL'] . '/parent-main-course/');
$mainCourses = $response->toArray();

$indexed_courses = [];
foreach ($mainCourses as $course) {
    $indexed_courses[$course['id']] = $course;
}

$response = $client->request('GET', $_ENV["SERVER_URL"] . '/packages/' . $packageBooking['package_id']);
$selectedPackage = $response->toArray();

$course_ids = explode(',', $packageBooking['course_id']);
$dueAmount = $selectedPackage['price'] + ($packageBooking['additional_seats'] * PARENT_SEAT_RATE);
?>
<div class="loading-popup-content-right <?= htmlspecialchars($userTheme) ?>">
    <div class="row">
        <div class="col-6">
            <h3 class="mb-0">Booking Info</h3>
        </div>

        <div class="col-6 text-end">
            <button class="btn btn-warning btn-sm" onclick="OpenBooking('<?= $referenceNumber ?>')" type="button"><i
                    class="fa solid fa-refresh"></i> Reload</button>
            <button class="btn btn-light btn-sm" onclick="ClosePopUPRight(0)" type="button"><i
                    class="fa solid fa-xmark"></i> Cancel</button>
        </div>

        <div class="col-12">
            <div class="border-bottom border-5 my-2"></div>
        </div>
    </div>



    <div class="row">
        <div class="col-8">
            <div class="row g-2">
                <div class="col-3">
                    <div class="card">
                        <div class="card-body">
                            <p class="mb-0">Ref #</p>
                            <h5><?= $packageBooking['reference_number'] ?></h5>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card">
                        <div class="card-body">
                            <p class="mb-0">Student Number</p>
                            <h5><?= $packageBooking['student_number'] ?></h5>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <p class="mb-0">Courses</p>
                            <?php
                            foreach ($course_ids as $id) {
                                $id = trim($id); // remove spaces
                                if (isset($indexed_courses[$id])) {
                            ?>
                                    <h5><?= $indexed_courses[$id]['course_name']; ?></h5>
                            <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card">
                        <div class="card-body">
                            <p class="mb-0">Payment Status</p>
                            <h5><?= $packageBooking['payment_status'] ?></h5>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card">
                        <div class="card-body">
                            <p class="mb-0">Payble Amount</p>
                            <h5><?= number_format($dueAmount, 2) ?></h5>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <p class="mb-0">Package</p>
                            <h5><?= $selectedPackage['package_name'] ?></h5>
                        </div>
                    </div>
                </div>
            </div>


        </div>
        <div class="col-4">
            <div class="row mb-2">
                <div class="col-12">
                    <img class="w-100"
                        src="https://content-provider.pharmacollege.lk<?= $packageBooking['image_path'] ?>"
                        alt="Payment Sip">
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <label for="paid_amount" class="mb-2">Payment Amount</label>
                            <input type="text" class="form-control text-center" placeholder="Payment Amount"
                                name="paid_amount" id="paid_amount">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr>
    <?php
    outputArray($packageBooking);
    outputArray($selectedPackage);
    ?>
</div>