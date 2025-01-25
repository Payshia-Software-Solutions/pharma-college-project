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
$studentInfoResponse = $client->request('GET', $_ENV["SERVER_URL"] . '/get-student-full-info?loggedUser=' . $searchStudentNumber);
$studentFullInfo = $studentInfoResponse->toArray();

$searchedStudent = $studentFullInfo['studentInfo'];
$studentPayments = $studentFullInfo['studentBalance'];
$studentEnrollments = $studentFullInfo['studentEnrollments'];

$citiesListResponse = $client->request('GET', $_ENV["SERVER_URL"] . '/cities');
$cityList = $citiesListResponse->toArray();

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
    <div class="col-lg-8">
        <div class="table-title font-weight-bold mb-2 mt-0">Game Results</div>

        <?php foreach ($studentEnrollments as $enrollment) : ?>
            <div class="row">
                <div class="col-md-12">
                    <h4 class="fw-bold border-bottom pb-2 mb-3">
                        <?= $enrollment['batch_name'] ?>
                    </h4>
                </div>
            </div>
            <div class="row g-3 mb-3">
                <div class="col-6 col-md-4 col-xl-3 d-flex">
                    <div class="card flex-fill">
                        <div class="card-body text-center">
                            <img src="./assets/content/lms-management/assets/images/icons/pharmacy.gif" class="game-icon w-25">
                            <h5 class="mb-0">Ceylon Pharmacy</h5>
                            <h2 class="mb-0 fw-bold"><?= $enrollment['ceylon_pharmacy']['recoveredCount'] ?></h2>
                        </div>
                    </div>
                </div>

                <div class="col-6 col-md-4 col-xl-3 d-flex">
                    <div class="card flex-fill">
                        <div class="card-body text-center">
                            <img src="./assets/content/lms-management/assets/images/icons/medicine.gif" class="game-icon w-25">
                            <h5 class="mb-0">Pharma Hunter</h5>
                            <h2 class="mb-0 fw-bold"><?= $enrollment['pharma_hunter']['ProgressValue'] ?>%</h2>

                            <hr>
                            <div class="row">
                                <div class="col-6">
                                    <p class="mb-0 text-muted">Correct</p>
                                    <h4><?= $enrollment['pharma_hunter']['correctCount'] ?></h4>
                                </div>

                                <div class="col-6">
                                    <p class="mb-0 text-muted">Wrong</p>
                                    <h4><?= $enrollment['pharma_hunter']['wrongCount'] ?></h4>
                                </div>


                                <div class="col-6">
                                    <p class="mb-0 text-muted">Gems</p>
                                    <h4><?= $enrollment['pharma_hunter']['gemCount'] ?></h4>
                                </div>


                                <div class="col-6">
                                    <p class="mb-0 text-muted">Coins</p>
                                    <h4><?= $enrollment['pharma_hunter']['coinCount'] ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-6 col-md-4 col-xl-3 d-flex">
                    <div class="card flex-fill">
                        <div class="card-body text-center">
                            <img src="./assets/content/lms-management/assets/images/icons/medicine.gif" class="game-icon w-25">
                            <h5 class="mb-0">Pharma Hunter Pro</h5>
                            <h2 class="mb-0 fw-bold"><?= $enrollment['pharma_hunter_pro']['results']['progressPercentage'] ?>%</h2>

                            <hr>
                            <div class="row">
                                <div class="col-6">
                                    <p class="mb-0 text-muted">Correct</p>
                                    <h4><?= $enrollment['pharma_hunter_pro']['results']['correctCount'] ?></h4>
                                </div>

                                <div class="col-6">
                                    <p class="mb-0 text-muted">Pending</p>
                                    <h4><?= $enrollment['pharma_hunter_pro']['results']['pendingCount'] ?></h4>
                                </div>


                                <div class="col-6">
                                    <p class="mb-0 text-muted">Gems</p>
                                    <h4><?= $enrollment['pharma_hunter_pro']['results']['gemCount'] ?></h4>
                                </div>


                                <div class="col-6">
                                    <p class="mb-0 text-muted">Coins</p>
                                    <h4><?= $enrollment['pharma_hunter_pro']['results']['coinCount'] ?></h4>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach ?>

    </div>

    <div class="col-lg-4">
        <div class="card mt-2">
            <div class="card-body">
                <div class="table-title font-weight-bold mb-4 mt-0">Student Details</div>
                <div class="row g-3">
                    <div class="col-4 col-md-4">
                        <label class="text-secondary">Civil Status</label>
                        <h5><?= $searchedStudent['civil_status'] ?></h5>
                    </div>

                    <div class="col-8 col-md-8">
                        <label class="text-secondary">Student Name</label>
                        <h5><?= $searchedStudent['first_name'] ?> <?= $searchedStudent['last_name'] ?></h5>
                    </div>

                    <div class="col-6 col-md-4">
                        <label class="text-secondary">User Name</label>
                        <h5><?= $searchedStudent['username'] ?></h5>
                    </div>

                    <div class="col-6 col-md-4">
                        <label class="text-secondary">User ID</label>
                        <h5><?= $searchedStudent['student_id'] ?></h5>
                    </div>

                    <div class="col-6 col-md-4">
                        <label class="text-secondary">Email Address</label>
                        <h5><?= $searchedStudent['e_mail'] ?></h5>
                    </div>

                    <div class="col-6 col-md-4">
                        <label class="text-secondary">Primary Number</label>
                        <h5><?= $searchedStudent['telephone_1'] ?></h5>
                    </div>

                    <div class="col-6 col-md-4">
                        <label class="text-secondary">Gender</label>
                        <h5><?= $searchedStudent['gender'] ?></h5>
                    </div>

                    <div class="col-6 col-md-4">
                        <label class="text-secondary">Registered Date</label>
                        <h5><?= date("Y-m-d H:i:s", strtotime($searchedStudent['updated_at'])); ?></h5>
                    </div>




                    <div class="col-6 col-md-4">
                        <label class="text-secondary">Birth Day</label>
                        <h5><?= $searchedStudent['birth_day'] ?></h5>
                    </div>

                    <div class="col-6 col-md-4">
                        <label class="text-secondary">NIC</label>
                        <h5><?= $searchedStudent['nic'] ?></h5>
                    </div>


                    <div class="col-12">
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="table-title font-weight-bold">Contact Details</div>
                            </div>

                            <div class="col-md-8">
                                <label class="text-secondary">Address</label>
                                <h5><?= $searchedStudent['address_line_1'] ?>, <?= $searchedStudent['address_line_2'] ?>, <?= $cityList[$searchedStudent['city']]['name_en'] ?>, <?= $cityList[$searchedStudent['district']]['name_en'] ?>, <?= $searchedStudent['postal_code'] ?></h5>
                            </div>

                            <div class="col-6 col-md-4">
                                <label class="text-secondary">Secondary Number</label>
                                <h5><?= $searchedStudent['telephone_2'] ?></h5>
                            </div>

                        </div>
                    </div>

                    <div class="col-12">
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="table-title font-weight-bold">Certificate Details</div>
                            </div>

                            <div class="col-md-6">
                                <label class="text-secondary">Full Name</label>
                                <h5><?= $searchedStudent['full_name'] ?></h5>
                            </div>

                            <div class="col-md-6">
                                <label class="text-secondary">Name with Initials</label>
                                <h5><?= $searchedStudent['name_with_initials'] ?></h5>
                            </div>
                            <div class="col-md-6">
                                <label class="text-secondary">Name on Certificate</label>
                                <h5><?= $searchedStudent['name_on_certificate'] ?></h5>
                            </div>

                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>