<?php
// Include required files
require_once('../../../../include/config.php');
include '../../../../include/function-update.php';
include '../../../../include/lms-functions.php';
require __DIR__ . '/../../../../vendor/autoload.php';

//require files for games
require '../../lms-management/assets/lms_methods/d-pad-methods.php';
require '../../lms-management/assets/lms_methods/ceylon-pharmacy-methods.php';
require '../../lms-management/assets/lms_methods/quiz_methods.php';
require_once '../../lms-management/assets/lms_methods/pharma-hunter-methods.php';
require_once '../../lms-management/assets/lms_methods/pharma-hunter-pro-methods.php';
require '../../lms-management/assets/lms_methods/win-pharma-functions.php';

//hunter pro
require '../../lms-management/assets/lms_methods/classes/hunter-pro-class.php';
require '../../lms-management/assets/lms_methods/classes/Database.php';

// For use env file data
use Dotenv\Dotenv;
use Mpdf\Tag\Br;
use Symfony\Component\HttpClient\HttpClient;

// Load environment variables
$dotenv = Dotenv::createImmutable(dirname(__DIR__, 4)); // Go up 5 directories
$dotenv->load();

// Initialize HTTP client
$client = HttpClient::create();

$config_file = '../../../../include\env.txt';


$database = new Database($config_file);
$db = $database->getConnection();

$selectedUsername = $_POST['selectedUsername'];
$LoggedUser = $_POST['LoggedUser'];

$studentDefaultCourseCode =  GetDefaultCourseValue($selectedUsername);
$DefaultCourse = $studentDefaultCourseCode;
// var_dump($studentDefaultCourseCode);

$responseForGetUsers = $client->request('GET', $_ENV["SERVER_URL"] . '/user_full_details/username/' . $selectedUsername . '/');
$personalDetails = $responseForGetUsers->toArray();
//print_r($personalDetails);

//get enrolled courses by username
$responseForGetCourses = $client->request('GET', $_ENV["SERVER_URL"] . '/studentEnrollments/user/' . $selectedUsername . '/');
$courseByStudentId = $responseForGetCourses->toArray();
// var_dump($courseByStudentId);
// Get the count
$courseCount = count($courseByStudentId);

//get Certificate orders
$responseForCertificateOrder = $client->request('GET', $_ENV["SERVER_URL"] . '/cc_certificate_order/' . $selectedUsername . '/');
$certificateOrders = $responseForCertificateOrder->toArray();
$certificateOrderCount = count($certificateOrders);

//get due balance
$paymentInfo = GetStudentBalance($selectedUsername);

// Fetch student payment data

$studentPayment = $client->request('GET', $_ENV["SERVER_URL"] . '/student-payment/' . $selectedUsername . '/');
$payments = $studentPayment->toArray();


//get delivery details
$responseForDeliveryOrder = $client->request('GET', $_ENV["SERVER_URL"] . '/delivery-orders/' . $selectedUsername . '/');
$deliveryOrders = $responseForDeliveryOrder->toArray();
$deliveryOrdersCount = count($deliveryOrders);
//print_r($deliveryOrders);

//SELECT * FROM `hp_save_answer` WHERE `index_number` LIKE '$IndexNumber' AND `answer_status` LIKE 'Correct'";
$responseForHPCorrectAttempts = $client->request('GET', $_ENV["SERVER_URL"] . '/hp-answers/username/' . $selectedUsername . '/');
$deliveryOrders = $responseForDeliveryOrder->toArray();


//D-pad game
$overallDpadGrade =  OverallGradeDpad($selectedUsername)['overallGrade'];

//CeloynPharma Game
$diedCount = 0;
$patientCount = 0;
$loopCount = 0; // Initialize the loop count.

$patients =  GetPatients($lms_link);

$patientRecoveries = GetPatientsRecoveriesByUser($selectedUsername);
$recoveryCount = count($patientRecoveries);


foreach ($patients as $selectedArray) {
    // Reset the loop count to 0 after every 10 iterations.
    if ($loopCount == 10) {
        $loopCount = 0;
    }

    $loopCount++; // Increment the loop count.
    $timer = GetTimer($lms_link, $selectedUsername, $selectedArray['prescription_id']);

    $bgColor = "primary";
    if ($timer['patient_status'] == "Died") {
        $bgColor = "danger";
        $diedCount++;
    }
    $patientCount++;
}

$lifeLinesCount = floor($patientCount * (50 / 100));

$availableCount = $lifeLinesCount - $recoveryCount;

//pharma reader game
$gradeArray = GetOverallGrade($selectedUsername, $studentDefaultCourseCode); // Get grade array for the course
$overallGrade = $gradeArray['overallGrade'] ?? 'N/A'; // Check if overall grade exists
//pharma game

$CourseCode = $studentDefaultCourseCode;
$Medicines = GetHunterCourseMedicines($lms_link, $CourseCode);

$SettingValue = GetHunterProAttempts($lms_link);

$CountAnswer = $SettingValue;
$AttemptCount = 5;
$Score = 60;
$MedicineCount = count($Medicines);

$TotalScore = $AttemptCount * $CountAnswer * 3; //3 Selections 10 for each
$overallGrade = ($TotalScore > 0) ? ($Score / $TotalScore) * 100 : 0;

$AttemptRate = $AttemptCount / $CountAnswer;
if ($AttemptRate > $MedicineCount) {
    $AttemptRate = $MedicineCount;
}

$CompleteRate = ($MedicineCount > 0) ? ($AttemptRate / $MedicineCount) * 100 : 0;

$savedCounts = HunterSavedAnswersByUser($selectedUsername);

$attemptPerMedicine = $SettingValue;
$correctCount = $pendingCount = $wrongCount = $gemCount = $coinCount = 0;
$pendingCount = $MedicineCount * $attemptPerMedicine;

if (isset($savedCounts[$selectedUsername])) {
    $correctCount = $savedCounts[$selectedUsername]['correct_count'];
    $pendingCount = $MedicineCount * $attemptPerMedicine - $correctCount;
    $wrongCount = $savedCounts[$selectedUsername]['incorrect_count'];
    $gemCount = $savedCounts[$selectedUsername]['gem_count'];
    $coinCount =  $savedCounts[$selectedUsername]['coin_count'];

    if ($coinCount >= 50) {
        $gemCount = $gemCount + intval($coinCount / 50);
        $coinCount = $coinCount % 50;
    }
}
//hunter pro

$CourseCode = $studentDefaultCourseCode;

$hunterCourseMedicine = new HunterCourseMedicine($db);
$CountHpAnswer = GetHunterProAttempts($lms_link);

$MedicinesHp = $hunterCourseMedicine->GetProMedicines($CourseCode);
$MedicineHpCount = count($MedicinesHp);

$correctHpAttempts = GetHPCorrectAttempts($lms_link, $selectedUsername);
$pendingHpCount = ($MedicineHpCount * $CountHpAnswer) - count($correctHpAttempts);

$totalGem = $totalCoin = 0;
$AllSubmissionsByMedicine  = GetAllSubmissionsByMedicine($lms_link, $selectedUsername);
$AllSubmissions = GetAllSubmissions($lms_link, $selectedUsername);
foreach ($AllSubmissionsByMedicine as $submission) :
    $answer_medicineId = $submission['medicine_id'];
    $savedItems = array_filter($AllSubmissions, function ($item) use ($answer_medicineId) {
        return isset($item['medicine_id']) && $item['medicine_id'] === $answer_medicineId;
    });

    $correctItems = array_filter($savedItems, function ($item) {
        return isset($item['answer_status']) && $item['answer_status'] === 'Correct';
    });

    $inCorrectItems = array_filter($savedItems, function ($item) {
        return isset($item['answer_status']) && $item['answer_status'] === 'In-Correct';
    });

    if (count($correctItems) >= count($inCorrectItems)) {
        $gemHpCount = count($correctItems) - count($inCorrectItems);
        $coinHpCount = count($inCorrectItems);
    } else {
        $gemHpCount = 0;
        $coinHpCount = count($correctItems);
    }


    $totalCoin += $coinHpCount;
    $totalGem += $gemHpCount;
endforeach;

$gemHpCount = $totalGem + intval($totalCoin / 50);
$coinHpCount = $totalCoin  % 50;


//Winpharma
$Submissions = GetWinpharmaSubmissions($lms_link, $LoggedUser);
if (!empty($Submissions)) {
    $LastLevel = $Submissions[0]['level_id'];
}

$Levels = GetLevels($lms_link, $DefaultCourse);
if (count($Levels) > 1) {
    $indexedLevels = array_values($Levels);
}

$LevelCount = GetLevelCount($lms_link, $LoggedUser, $DefaultCourse);
if ($LevelCount == 0) {
    // echo "No Levels";
    // exit;
}
// $CurrentTopLevel = reset($Levels)["level_id"];

$CurrentTopLevel = GetTopLevel($lms_link, $LoggedUser, $DefaultCourse);

if ($CurrentTopLevel == -1) {
    $CurrentTopLevel = GetCourseTopLevel($lms_link, $DefaultCourse);
}
$Tasks = GetTasks($lms_link, $CurrentTopLevel);

$Levels = GetLevels($lms_link, $DefaultCourse);

// Check if Levels are available and valid
if (!empty($Levels) && is_array($Levels)) {
    $RootLevel = reset($Levels)["level_id"];
} else {
    // Handle case where no levels exist
    $RootLevel = null;
}

// Ensure $Levels is not empty and $CurrentTopLevel is valid
if (!empty($Levels) && isset($Levels[$CurrentTopLevel])) {
    $Level = $Levels[$CurrentTopLevel];
    $Tasks = GetTasks($lms_link, $Level['level_id']);
} else {
    $Level = null;
    $Tasks = [];
}

// Get Submissions
$Submissions = GetWinpharmaSubmissions($lms_link, $LoggedUser);
if (!empty($Submissions)) {
    $LastLevel = $Submissions[0]['level_id'];
} else {
    $LastLevel = null;
}

// Index Levels if available
if (!empty($Levels) && count($Levels) > 1) {
    $indexedLevels = array_values($Levels);
}

?>


<div class="loading-popup-content-right <?= htmlspecialchars($userTheme) ?>">
    <div class="text-end">
        <button class="btn btn-dark " onclick="ClosePopUPRight(1)" type="button"><i class="fa solid fa-xmark"></i> close</button>
    </div>
    <div class="index-content">
        <!-- Enrollments Table -->
        <div class="row mt-3">
            <div class="card-body">
                <div class="col-12 mb-5">
                    <h5 class="table-title">Game Details</h5>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="row g-3">
                            <!--Select course code-->
                            <div class="row">
                                <div class="col-12 col-md-12">
                                    <form method="POST" action="" id="courseCode-form">
                                        <div class="row">
                                            <div class="col-6 col-md-6 col-lg-6">
                                                <select class="form-select" name="courseCode" id="courseCode" required autocomplete="off">
                                                    <option value="">Select Course</option>
                                                    <?php
                                                    if (!empty($courseByStudentId)) {
                                                        // Loop through courses and add course_code as options
                                                        foreach ($courseByStudentId as $course) {
                                                    ?>
                                                            <option value="<?= $course['course_code'] ?>"><?= $course['course_code'] ?></option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>

                                            </div>
                                            <div class="col-3 col-md-4">
                                                <button type="button" onclick="OpenGameDetailsByCourseCode('<?= $LoggedUser ?>','<?= $selectedUsername ?>')" class="btn btn-dark" id="hideButton">Game Result</button>
                                            </div>
                                            <div class="col-2 col-md-2">
                                                <button type="button" id="resetButton" class="btn btn-secondary" onclick="OpenGameDetails('<?= $selectedUsername ?>')"><i class="fa fa-close"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div id="student-courseCode">
                            </div>
                            <div class="defult_course" id="defult_course">
                                <?php
                                $responseForCertificate = $client->request('GET', $_ENV["SERVER_URL"] . '/course/' . $studentDefaultCourseCode . '/');
                                $certificate = $responseForCertificate->toArray();
                                ?>
                                <div class="text-center">
                                    <h4 class="fw-bold"><?= $certificate['course_name'] ?> (<?= $studentDefaultCourseCode ?>)</h4>
                                </div>

                                <div class="row">
                                    <!-- D-Pad -->
                                    <div class="col-12 col-md-5 d-flex m-1">
                                        <div class="card h-100 w-100">
                                            <div class="card-body">
                                                <h4 class="mb-0 text-center">D-Pad</h4>
                                                <h6 class="mb-0 text-center">Overall Grade:</h6>
                                                <p class="mb-0 text-center"><?= number_format($overallDpadGrade, 1) ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Pharma Reader -->
                                    <div class="col-12 col-md-5 d-flex m-1">
                                        <div class="card h-100 w-100">
                                            <div class="card-body">
                                                <h4 class="mb-4 text-center">Pharma Reader Courses</h4>
                                                <div class="row">
                                                    <?php
                                                    ?>
                                                    <div class="col-6 mb-3 text-center">
                                                        <p class="mb-0 text-center"><strong>Overall Grade:</strong> <?= is_numeric($overallGrade) ? number_format($overallGrade, 1) : $overallGrade ?></p>
                                                    </div>
                                                    <?php

                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Pharma Hunter -->
                                    <div class="col-12 col-md-5 d-flex m-1">
                                        <div class="card h-100 w-100">
                                            <div class="card-body bg-gradient">
                                                <h4 class="mb-4 text-center fw-bold">Pharma Hunter</h4>
                                                <div class="row text-center">
                                                    <div class="col-6 mb-3">
                                                        <p class="mb-1 fw-normal">Overall Grade</p>
                                                        <h6 class="mb-0 fw-semibold"><?= number_format($overallGrade, 1) ?></h6>
                                                    </div>
                                                    <div class="col-6 mb-3">
                                                        <p class="mb-1 fw-normal">Complete Rate</p>
                                                        <h6 class="mb-0 fw-semibold"><?= number_format($CompleteRate, 1) ?></h6>
                                                    </div>
                                                    <div class="col-6 mb-3">
                                                        <p class="mb-1 fw-normal">Pending Count</p>
                                                        <h6 class="mb-0 fw-semibold"><?= number_format($pendingCount) ?></h6>
                                                    </div>
                                                    <div class="col-6 mb-3">
                                                        <p class="mb-1 fw-normal">Stored Count</p>
                                                        <h6 class="mb-0 fw-semibold"><?= number_format($correctCount, 1) ?></h6>
                                                    </div>
                                                    <div class="col-6 mb-3">
                                                        <p class="mb-1 fw-normal">Gem / Coin</p>
                                                        <h6 class="mb-0 fw-semibold"><?= $gemCount ?>/<?= $coinCount ?></h6>
                                                    </div>
                                                    <div class="col-6">
                                                        <p class="mb-1 fw-normal">Wrong Count</p>
                                                        <h6 class="mb-0 fw-semibold text-danger"><?= number_format($wrongCount, 1) ?></h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Pharma Hunter Pro -->
                                    <div class="col-12 col-md-5 d-flex m-1">
                                        <div class="card h-100 w-100">
                                            <div class="card-body bg-gradient">
                                                <h4 class="mb-4 text-center fw-bold">Pharma Hunter Pro</Prog>
                                                </h4>
                                                <div class="row text-center">
                                                    <div class="col-6 mb-3">
                                                        <p class="mb-1 fw-normal">Stored Count</p>
                                                        <h6 class="mb-0 fw-semibold"><?= count($correctHpAttempts) ?></h6>
                                                    </div>
                                                    <div class="col-6 mb-3">
                                                        <p class="mb-1 fw-normal">Pending Count</p>
                                                        <h6 class="mb-0 fw-semibold"><?= number_format($pendingHpCount) ?></h6>
                                                    </div>
                                                    <div class="col-6 mb-3">
                                                        <p class="mb-1 fw-normal">Gem Count</p>
                                                        <h6 class="mb-0 fw-semibold"><?= number_format($gemHpCount) ?></h6>
                                                    </div>
                                                    <div class="col-6 mb-3">
                                                        <p class="mb-1 fw-normal">Coin Count</p>
                                                        <h6 class="mb-0 fw-semibold"><?= $coinHpCount ?></h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- CeylonPharma Game -->
                                    <div class="col-12 col-md-5 d-flex m-1">
                                        <div class="card h-100 w-100">
                                            <div class="card-body bg-gradient">
                                                <h4 class="mb-4 text-center fw-bold">CeylonPharma Game</h4>
                                                <div class="row text-center">
                                                    <div class="col-6 mb-3">
                                                        <p class="mb-1">Lifelines</p>
                                                        <h5 class="mb-0 fw-semibold"><?= $lifeLinesCount ?></h5>
                                                    </div>
                                                    <div class="col-6 mb-3">
                                                        <p class="mb-1">Usage</p>
                                                        <h5 class="mb-0 fw-semibold"><?= $recoveryCount ?></h5>
                                                    </div>
                                                    <div class="col-6">
                                                        <p class="mb-1">Available</p>
                                                        <h5 class="mb-0 fw-semibold"><?= $availableCount ?></h5>
                                                    </div>
                                                    <div class="col-6">
                                                        <p class="mb-1">Died</p>
                                                        <h5 class="mb-0 fw-semibold text-danger"><?= $diedCount ?></h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Winpharma -->
                                    <div class="col-12 col-md-5 d-flex m-1">
                                        <div class="card h-100 w-100">
                                            <div class="card-body">
                                                <h4 class="mb-4 text-center">Winpharma Game</h4>
                                                <div class="row">
                                                    <div class="col-12 mt-2">
                                                        <h5 style="font-weight: 600;" class="card-title text-center"><?= $Level['level_name'] ?></h5>
                                                        <div class="row mt-4">
                                                            <?php
                                                            if (!empty($Tasks)) {
                                                                $actions = "active";
                                                                $next_level = 1;
                                                                foreach ($Tasks as $Task) {
                                                                    $current_status = "Not Completed";
                                                                    $bg_color = "info";
                                                                    $TaskStatus = GetSubmitionResult($lms_link, $LoggedUser, $Task['resource_id']);

                                                                    if (!empty($TaskStatus)) {
                                                                        $current_status = $TaskStatus[0]['grade_status'];
                                                                    }

                                                                    if ($current_status == "Pending") {
                                                                        $bg_color = "danger";
                                                                    }

                                                                    if ($Task['is_active'] != 1) {
                                                                        continue;
                                                                    }
                                                            ?>
                                                                    <div class="col-12">
                                                                        <div class="card-body text-center">
                                                                            <div class="row">
                                                                                <div class="text-center col-6">
                                                                                    <p class="card-title "><?= $Task['resource_title'] ?> :</hp>
                                                                                </div>
                                                                                <div class="text-center col-6">
                                                                                    <div class="text-dark"><?= $current_status ?></div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                        </div>

                                                    <?php

                                                                    if ($current_status == "Not Completed") {
                                                                        // $actions = "inactive";
                                                                    }

                                                                    if ($current_status == "Not Completed" || $current_status == "Re-Correction"  || $current_status == "Pending" || $current_status == "Sp-Pending" || $current_status == "Try Again") {
                                                                        // $actions = "inactive";
                                                                        $next_level += 1;
                                                                    }
                                                                }
                                                            } else { ?>
                                                    <div class="col-12">
                                                        <div class="alert alert-warning" role="alert">Not Tasks</div>
                                                    </div>
                                                <?php
                                                            }
                                                ?>
                                                    </div>
                                                </div>
                                                <?php

                                                if (!empty($Tasks)) {
                                                ?>
                                                <?php

                                                } else {
                                                ?>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>