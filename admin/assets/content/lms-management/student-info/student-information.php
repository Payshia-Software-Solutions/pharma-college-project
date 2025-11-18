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
$searchStudentNumber =  strtoupper($_POST['studentNumber']);

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
        <div class="table-title font-weight-bold mb-2 mt-0">Results</div>

        <?php foreach ($studentEnrollments as $enrollment) :

            $winpharmaResponse = $client->request('GET', $_ENV["SERVER_URL"] . '/win_pharma_submission/get-results?UserName=' . $searchStudentNumber . '&batchCode=' . $enrollment['course_code']);
            $winpharmaResults = $winpharmaResponse->toArray();

            $dPadResponse = $client->request('GET', $_ENV["SERVER_URL"] . '/d-pad/get-overall-grade?loggedUser=' . $searchStudentNumber);
            $dPadResponse = $dPadResponse->toArray();

        ?>
            <div class="row">
                <div class="col-md-12">
                    <h4 class="fw-bold border-bottom pb-2 mb-3">
                        <?= $enrollment['course_code'] ?> |<?= $enrollment['batch_name'] ?>
                    </h4>
                </div>
            </div>
            <div class="row g-3 mb-3">
                <div class="col-12">
                    <h5>Orders</h5>
                </div>
                <!-- Orders Info -->
                <?php if (isset($enrollment['deliveryOrders'])) :
                    foreach ($enrollment['deliveryOrders'] as $orderInfo) :
                ?>
                        <div class="col-12">
                            <div class="card flex-fill">
                                <div class="card-body text-start">
                                    <div class="row g-2">
                                        <div class="col-3 col-md-2">Ref #</div>
                                        <div class="col-3 col-md-2">Tracking #</div>
                                        <div class="col-9 col-md-3">Item</div>
                                        <div class="col-9 col-md-2">Value</div>
                                        <div class="col-9 col-md-3">Order Dates</div>
                                    </div>
                                    <div class="row g-2">
                                        <div class="col-3 col-md-2">
                                            <h5 class="mb-0"><?= $orderInfo['id'] ?></h5>
                                            <span class="badge bg-<?= $orderInfo['color'] ?>"><?= $orderInfo['active_status']  ?></span>
                                        </div>
                                        <div class="col-3 col-md-2">
                                            <h5 class="mb-0"><?= $orderInfo['tracking_number'] ?></h5>
                                        </div>
                                        <div class="col-9 col-md-3">
                                            <h5 class="mb-0"><?= $orderInfo['delivery_title'] ?></h5>
                                        </div>

                                        <div class="col-9 col-md-2">
                                            <h5 class="mb-0"><?= number_format($orderInfo['value'], 2) ?></h5>
                                        </div>
                                        <div class="col-9 col-md-3">
                                            <h6 class="mb-0">Order : <?= date("Y-m-d H:i", strtotime($orderInfo['order_date'])) ?></h6>
                                            <h6 class="mb-0">Packed : <?= date("Y-m-d H:i", strtotime($orderInfo['packed_date'])) ?></h6>
                                            <h6 class="mb-0">Sent : <?= date("Y-m-d H:i", strtotime($orderInfo['send_date'])) ?></h6>
                                        </div>

                                        <div class="col-12">
                                            <p class="text-muted mb-0">Full Name</p>
                                            <p class="fw-bold mb-1"><?= $orderInfo['full_name'] ?></p>

                                            <p class="text-muted mb-0">Address</p>
                                            <p class="fw-bold"><?= $orderInfo['street_address'] ?>, <?= $orderInfo['city'] ?>, <?= $orderInfo['district'] ?></p>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
                <!-- Enf of the Orders Info -->
            </div>

            <div class="row g-3 mb-3">
                <div class="col-12">
                    <h5>Assignments</h5>
                </div>
                <!-- Assignments -->
                <?php if (isset($enrollment['assignment_grades']['assignments'])) :
                    foreach ($enrollment['assignment_grades']['assignments'] as $assignment) :
                ?>
                        <div class="col-6 col-md-4 col-lg-3">
                            <div class="card flex-fill">
                                <div class="card-body text-center">
                                    <h5 class="mb-0"><?= $assignment['assignment_name'] ?></h5>
                                    <h2 class="mb-0 fw-bold"><?= number_format($assignment['grade'], 2) ?>%</h2>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="card flex-fill">
                            <div class="card-body text-center">
                                <h5 class="mb-0">Average</h5>
                                <h2 class="mb-0 fw-bold"><?= $enrollment['assignment_grades']['average_grade'] ?>%</h2>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <!-- Enf of the Assignments -->
            </div>
            <hr>
            <div class="row g-3 mb-3">
                <div class="col-12">
                    <h5>Games</h5>
                </div>

                <!-- Win Pharma Game Results-->
                <div class="col-6 col-md-4 col-xl-3 d-flex">
                    <div class="card flex-fill">
                        <div class="card-body text-center">
                            <img src="https://lms.pharmacollege.lk/lib/home/assets/images/drugs.gif" class="game-icon w-25">
                            <h5 class="mb-0">Win Pharma</h5>
                            <h2 class="mb-0 fw-bold"><?= $winpharmaResults['data']['gradePercentage'] ?>%</h2>
                        </div>
                    </div>
                </div>
                <!-- End of Win Pharma Game Results -->

                <!-- Win Pharma Game Results-->
                <div class="col-6 col-md-4 col-xl-3 d-flex">
                    <div class="card flex-fill">
                        <div class="card-body text-center">
                            <img src="https://lms.pharmacollege.lk/lib/home/assets/images/pill.gif" class="game-icon w-25">
                            <h5 class="mb-0">D-Pad</h5>
                            <h2 class="mb-0 fw-bold"><?= number_format($dPadResponse['overallGrade'], 2) ?>%</h2>
                        </div>
                    </div>
                </div>
                <!-- End of Win Pharma Game Results -->


                <!-- Ceylon Pharmacy Game Results-->
                <div class="col-6 col-md-4 col-xl-3 d-flex">
                    <div class="card flex-fill">
                        <div class="card-body text-center">
                            <img src="./assets/content/lms-management/assets/images/icons/pharmacy.gif" class="game-icon w-25">
                            <h5 class="mb-0">Ceylon Pharmacy</h5>
                            <h2 class="mb-0 fw-bold"><?= $enrollment['ceylon_pharmacy']['recoveredCount'] ?></h2>
                        </div>
                    </div>
                </div>
                <!-- End of Ceylon Pharmacy Game Results -->

                <!-- Pharma Hunter Game Results -->
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
                <!-- End of Pharma Hunter Game Results -->

                <!-- Pharma Hunter Pro Game Results -->
                <div class="col-6 col-md-4 col-xl-3 d-flex">
                    <div class="card flex-fill">
                        <div class="card-body text-center">
                            <img src="https://lms.pharmacollege.lk/lib/pharma-hunter-pro/assets/images/icon/medicine.gif" class="game-icon w-25">
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
                <!-- End of Pharma Hunter Pro Game Results -->
            </div>
            <div class="row g-3 mb-3">
                <div class="col-12">
                    <h5>Certificates</h5>
                </div>

                <!-- Certificates -->
                <?php if (isset($enrollment['certificateRecords'])) :
                    foreach ($enrollment['certificateRecords'] as $certificate) :
                ?>
                        <div class="col-6 col-md-4 col-lg-3">
                            <div class="card flex-fill">
                                <div class="card-body text-center">
                                    <h5 class="mb-0"><?= $certificate['type'] ?></h5>
                                    <h4 class="mb-0 fw-bold"><?= $certificate['certificate_id'] ?></h4>
                                    <span class="badge bg-success">Printed</span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

        <?php endforeach ?>

    </div>

    <div class="col-lg-4">
        <div class="table-title font-weight-bold mb-4 mt-0">Student Details</div>
        <div class="row g-3">
            <div class="col-4 col-md-3">
                <label class="text-secondary">Civil Status</label>
                <h5><?= $searchedStudent['civil_status'] ?></h5>
            </div>

            <div class="col-8 col-md-9">
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
                <label class="text-secondary">Gender</label>
                <h5><?= $searchedStudent['gender'] ?></h5>
            </div>

            <div class="col-6 col-md-12">
                <label class="text-secondary">Email Address</label>
                <h5><?= $searchedStudent['e_mail'] ?></h5>
            </div>

            <div class="col-6 col-md-6">
                <label class="text-secondary">Primary Number</label>
                <h5><?= $searchedStudent['telephone_1'] ?></h5>
            </div>



            <div class="col-6 col-md-4">
                <label class="text-secondary">Registered Date</label>
                <h5><?= date("Y-m-d H:i", strtotime($searchedStudent['updated_at'])); ?></h5>
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

                    <div class="col-md-12">
                        <label class="text-secondary">Address</label>
                        <h5><?= $searchedStudent['address_line_1'] ?>, <?= $searchedStudent['address_line_2'] ?>, <?= $cityList[trim($searchedStudent['city'])]['name_en'] ?>, <?= $cityList[$searchedStudent['district']]['name_en'] ?>, <?= $searchedStudent['postal_code'] ?></h5>
                    </div>

                    <div class="col-md-12">
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

                    <div class="col-md-12">
                        <label class="text-secondary">Full Name</label>
                        <h5><?= $searchedStudent['full_name'] ?></h5>
                    </div>

                    <div class="col-md-12">
                        <label class="text-secondary">Name with Initials</label>
                        <h5><?= $searchedStudent['name_with_initials'] ?></h5>
                    </div>
                    <div class="col-md-12">
                        <label class="text-secondary">Name on Certificate</label>
                        <h5><?= $searchedStudent['name_on_certificate'] ?></h5>
                    </div>

                </div>
            </div>


        </div>
    </div>
</div>