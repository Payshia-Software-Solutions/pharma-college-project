<?php
// Display Errors
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Load Composer
require __DIR__ . '/../../../../vendor/autoload.php';

// For use env file data
use Dotenv\Dotenv;
use Symfony\Component\HttpClient\HttpClient;

// Load environment variables
$dotenv = Dotenv::createImmutable(dirname(__DIR__, 4));
$dotenv->load();

// POST Parameters
$searchStudentNumber = $_POST['studentNumber'];

// Initialize HTTP client
$client = HttpClient::create();

// Fetch certificate order data from API
$response = $client->request('GET', $_ENV["SERVER_URL"] . '/get-student-full-info?loggedUser=' . $searchStudentNumber);
$studentFullInfo = $response->toArray();

$studentInfo = $studentFullInfo['studentInfo'];
$studentPayments = $studentFullInfo['studentBalance'];
$studentEnrollments = $studentFullInfo['studentEnrollments'];
?>

<div class="row my-4">
    <div class="col-md-12 text-end mb-3 mb-md-5">
        <button type="button" onclick="GetStudentInformation('<?= $searchStudentNumber ?>')" class="btn btn-dark">
            <i class="fa-solid fa-rotate-right"></i> Reload
        </button>

        <button type="button" onclick="GetSearchPopUp()" class="btn btn-dark">
            <i class="fa-solid fa-magnifying-glass"></i> Search
        </button>
    </div>

    <div class="col-md-3">
        <div class="card item-card">
            <div class="overlay-box">
                <i class="fa-solid fa-dollar icon-card"></i>
            </div>
            <div class="card-body">
                <p>Due Balance</p>
                <h4 class="">LKR <?= number_format($studentPayments['studentBalance'], 2) ?></h4>
                <div class="border-bottom my-2"></div>

                <div class="text-end">
                    <button onclick="MakeStudentPayment('<?= $searchStudentNumber ?>')" type="button" class="btn btn-dark btn-sm"><i class="fa-solid fa-money-bill"></i> Payment</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Game Results -->
<div class="row g-3">
    <div class="col-md-8">
        <div class="table-title font-weight-bold mb-2 mt-0">Game Results</div>

        <?php foreach ($studentEnrollments as $enrollment) : ?>
            <div class="row">
                <div class="col-md-12">
                    <h4 class="fw-bold">
                        <?= $enrollment['batch_name'] ?>
                    </h4>
                </div>
            </div>
            <div class="row g-3 mb-3">
                <div class="col-6 col-md-4 d-flex">
                    <div class="card flex-fill">
                        <div class="card-body text-center">
                            <img src="./assets/content/lms-management/assets/images/icons/pharmacy.gif" class="game-icon w-25">
                            <h5 class="mb-0">Ceylon Pharmacy</h5>
                            <h2 class="mb-0 fw-bold"><?= $enrollment['ceylon_pharmacy']['recoveredCount'] ?></h2>
                        </div>
                    </div>
                </div>

                <div class="col-6 col-md-4 d-flex">
                    <div class="card flex-fill">
                        <div class="card-body text-center">
                            <img src="./assets/content/lms-management/assets/images/icons/medicine.gif" class="game-icon w-25">
                            <h5 class="mb-0">Pharma Hunter</h5>
                            <h2 class="mb-0 fw-bold"><?= $enrollment['pharma_hunter']['ProgressValue'] ?></h2>
                        </div>
                    </div>
                </div>

                <div class="col-6 col-md-4 d-flex">
                    <div class="card flex-fill">
                        <div class="card-body text-center">
                            <img src="./assets/content/lms-management/assets/images/icons/medicine.gif" class="game-icon w-25">
                            <h5 class="mb-0">Pharma Hunter Pro</h5>
                            <h2 class="mb-0 fw-bold"><?= $enrollment['pharma_hunter_pro']['progressValue'] ?></h2>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach ?>

    </div>
</div>