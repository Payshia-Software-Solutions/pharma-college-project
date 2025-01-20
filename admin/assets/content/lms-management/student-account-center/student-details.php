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

$selectedUsername = $_POST['username'];
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

<div id="index-content">
    <div class="row g-3 mt-3">
        <div class="col-12">
            <div class="text-center border-bottom mb-2">

                <img class="mt-3" style="width: 100px;" src="./assets/images/profile.png">
                <h2 class="mt-2 mb-0"><?= $personalDetails['full_name'] ?><span style="font-size:18px" class=""><i class="fa-solid fa-circle-check"></i></span></h2>
                <h4><?= $personalDetails['student_id'] ?></h4>

            </div>

            <!-- buttons -->
            <!-- buttons -->
            <div class="container">
                <div class="row g-2 justify-content-center text-center">
                    <!-- Due Payment -->
                    <div class="col-4 col-lg-3 d-flex align-items-stretch">
                        <div class="card flex-fill btn" type="button" onclick="OpenPaymentHistory('<?= $selectedUsername ?>')">
                            <div class="card-body text-center">
                                <i class="fa-solid fa-user-tag fa-1x"></i>
                                <h5 class="mb-0 mt-1">Due Payment</h5>
                                <p class="text-secondary mb-0">Rs. <?= $paymentInfo['studentBalance'] ?></p>
                            </div>
                        </div>
                    </div>

                    <!-- Enrollments AddNewEmployee -->
                    <div class="col-6 col-lg-3 d-flex align-items-stretch">
                        <div class="card flex-fill btn" type="button" onclick="OpenEnrollements('<?= $selectedUsername ?>')">
                            <div class="card-body text-center">
                                <i class="fa-solid fa-building-user fa-1x"></i>
                                <h5 class="mb-0 mt-1">Enrollments AddNewEmployee</h5>
                                <p class="text-secondary mb-0"><?= $courseCount ?></p>
                            </div>
                        </div>
                    </div>

                    <!-- Orders Count -->
                    <div class="col-6 col-lg-3 d-flex align-items-stretch">
                        <div class="card flex-fill btn" type="button" onclick="OpenOrders('<?= $selectedUsername ?>')">
                            <div class="card-body text-center">
                                <i class="fa-solid fa-address-card fa-1x"></i>
                                <h5 class="mb-0 mt-1">Orders Count</h5>
                                <div class="m-0">
                                    <h6 class="text-secondary m-0 p-0">Certificates :<?= $certificateOrderCount ?></h6>
                                </div>
                                <div class="mb-0">
                                    <h6 class="text-secondary m-0 p-0">Deliveries :<?= $deliveryOrdersCount ?></h6>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Game Detailst -->
                    <div class="col-6 col-lg-3 d-flex align-items-stretch">
                        <div class="card flex-fill btn" type="button" onclick="OpenGameDetails('<?= $selectedUsername ?>')">
                            <div class="card-body text-center">
                                <i class="fa-solid fas fa-gamepad fa-1x"></i>
                                <h5 class="mb-0 mt-1">Game Details</h5>
                                <p class="text-secondary mb-0"></p>
                            </div>
                        </div>
                    </div>

                    <!-- Password Reset -->
                    <div class="col-6 col-lg-3 d-flex align-items-stretch">
                        <div class="card flex-fill btn" type="button" onclick="OpenpasswordReset('<?= $selectedUsername ?>')">
                            <div class="card-body text-center">
                                <i class="fa-solid fa-user-tag fa-1x"></i>
                                <h5 class="mb-0 mt-1">Password Reset</h5>
                                <p class="text-secondary mb-0"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Personal Information -->
            <div class="row mt-3">
                <div class="col-12">
                    <div class="card ">
                        <div class="card-body">
                            <h4 class="border-bottom pb-2 mb-3">Personal Information</h4>
                            <div class="row g-2">


                                <div class="col-md-4">
                                    <h6 class="text-secondary">Full Name</h6>
                                </div>
                                <div class="col-md-8">
                                    <h6 class=""><?= $personalDetails['full_name'] ?></h6>
                                </div>


                                <div class="col-md-4">
                                    <h6 class="text-secondary">Name with Initials</h6>
                                </div>
                                <div class="col-md-8">
                                    <h6 class=""><?= $personalDetails['name_with_initials'] ?></h6>
                                </div>

                                <div class="col-md-4">
                                    <h6 class="text-secondary">NIC #</h6>
                                </div>
                                <div class="col-md-8">
                                    <h6 class=""><?= $personalDetails['nic'] ?></h6>
                                </div>


                                <div class="col-md-4">
                                    <h6 class="text-secondary">Phone</h6>
                                </div>
                                <div class="col-md-8">
                                    <h6 class=""><?= $personalDetails['telephone_1'] ?></h6>
                                </div>

                                <div class="col-md-4">
                                    <h6 class="text-secondary">Email Address</h6>
                                </div>
                                <div class="col-md-8">
                                    <h6 class=""><?= $personalDetails['e_mail'] ?></h6>
                                </div>

                                <div class="col-md-4">
                                    <h6 class="text-secondary">Date of Birth</h6>
                                </div>
                                <div class="col-md-8">
                                    <h6 class=""><?= $personalDetails['birth_day'] ?></h6>
                                </div>

                                <div class="col-md-4">
                                    <h6 class="text-secondary">Gender</h6>
                                </div>
                                <div class="col-md-8">
                                    <h6 class=""><?= $personalDetails['gender'] ?></h6>
                                </div>

                                <div class="col-md-4">
                                    <h6 class="text-secondary">Address Line 1</h6>
                                </div>
                                <div class="col-md-8">
                                    <h6 class=""><?= $personalDetails['address_line_1'] ?></h6>
                                </div>

                                <div class="col-md-4">
                                    <h6 class="text-secondary">Address Line 2</h6>
                                </div>
                                <div class="col-md-8">
                                    <h6 class=""><?= $personalDetails['address_line_2'] ?></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of Personal Information -->
        </div>

    </div>
</div>
</div>

<script>
    document.getElementById("hideButton").addEventListener("click", function() {
        document.getElementById("defult_course").style.display = "none";
    });

    // Show the div when the "Reset" button is clicked
    document.getElementById("resetButton").addEventListener("click", function() {
        document.getElementById("defult_course").style.display = "block";
        // Hide or clear the content loaded by OpenGameDetailsByCourseCode
        document.getElementById("student-courseCode").innerHTML = "";
    });

    $(document).ready(function() {
        $('#courseCode').select2({
            width: 'resolve'
        });
    });
</script>