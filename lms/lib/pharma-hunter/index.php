<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../../include/configuration.php';
include '../../php_handler/function_handler.php';
include './php_methods/pharma-hunter-methods.php';

// Include Classes
include_once './classes/Database.php';
include_once './classes/SaveAnswer.php';
include_once './classes/Medicine.php';
include_once './classes/MedicineStore.php';

// Create a new Database object with the path to the configuration file
$config_file = '../../include/env.txt';
$database = new Database($config_file);
$db = $database->getConnection();

$medicine = new Medicine($database);

$userLevel = $_POST['UserLevel'];
$LoggedUser = $_POST['LoggedUser'];
$CourseCode = $_POST['CourseCode'];

$timeOfDay = getCurrentTimeOfDay();

$SettingValue = GetHunterProAttempts($link);
$SetAnswerLoopCount = $SettingValue;
$CountAnswer = $SettingValue;

$AttemptCount = 1;
if (isset($_POST['AttemptCount'])) {
    $AttemptCount = $_POST['AttemptCount'];
}

$Submissions = GetSubmissions($link, $CountAnswer, $LoggedUser);
$Medicines = GetHunterCourseMedicines($link, $CourseCode);

// $Medicines = $medicine->fetchNotDeletedAll();
if (empty($Medicines)) {
    echo "<div class ='alert alert-warning mt-4'>Your course has not added any medicines yet. Please check with your course administrator for more information.</div>";
    exit;
}

$UniqueMedicines = array_diff($Medicines, $Submissions);
$UniqueMedicines = array_values($UniqueMedicines);
$length = count($UniqueMedicines);
if (isset($_POST['MedicineID'])) {
    $MedicineID = $_POST['MedicineID'];

    if (in_array($MedicineID, $UniqueMedicines)) {
        if ($length > 0) {
            $selectedArray = GetMedicineByID($link, $MedicineID)[0];
        }
    }
} else {
    if ($length > 0) {
        $randomNumber = rand(0, $length - 1);
        $MedicineID = $UniqueMedicines[$randomNumber];
        $selectedArray = GetMedicineByID($link, $MedicineID)[0];
    }
}



$savedStatus = 0;
$AttemptCount = 5;
$Score = 60;
$MedicineCount = count($Medicines);

$AttemptRate = $AttemptCount / $CountAnswer;
if ($AttemptRate > $MedicineCount) {
    $AttemptRate = $MedicineCount;
}
$CompleteRate = ($MedicineCount > 0) ? ($AttemptRate / $MedicineCount) * 100 : 0;

$TotalScore = $AttemptCount * $CountAnswer * 3; //3 Selections 10 for each
$overallGrade = ($TotalScore > 0) ? ($Score / $TotalScore) * 100 : 0;

if (isset($selectedArray)) {
    $medicineId = $selectedArray['id'];
    $medicineName = $selectedArray['medicine_name'];
    $filePath = $selectedArray['file_path'];
}

// Special for Pharma Hunter
$parts = explode("/", $filePath);
$filePath = end($parts);

$savedCounts = HunterSavedAnswersByUser($LoggedUser);

// echo $medicineCount;

$attemptPerMedicine = $SettingValue;
$correctCount = $pendingCount = $wrongCount = $gemCount = $coinCount = 0;
$pendingCount = $MedicineCount * $attemptPerMedicine;

if (isset($savedCounts[$LoggedUser])) {
    $correctCount = $savedCounts[$LoggedUser]['correct_count'];
    $pendingCount = $MedicineCount * $attemptPerMedicine - $correctCount;
    $wrongCount = $savedCounts[$LoggedUser]['incorrect_count'];
    $gemCount = $savedCounts[$LoggedUser]['gem_count'];
    $coinCount =  $savedCounts[$LoggedUser]['coin_count'];

    if ($coinCount >= 50) {
        $gemCount = $gemCount + intval($coinCount / 50);
        $coinCount = $coinCount % 50;
    }
}

$ProgressValue = ($correctCount / ($MedicineCount * $attemptPerMedicine)) * 100;
if ($ProgressValue > 100) {
    $ProgressValue = 100;
}


?>

<style>
    .admin-card:hover {
        background-color: #000;
        color: #fff !important;
    }

    .admin-card:hover h4 {
        color: #fff !important;
    }

    .game-card:hover {
        background-color: #000;
        color: #fff !important;
    }

    .game-card:hover h4 {
        color: #fff !important;
    }

    .pres-image {
        border: 6px solid #088F8F !important;
        border-radius: 5px;
        padding: 10px;
        background-color: #e8f4f8;
    }

    .reader-image {
        width: 50% !important;
    }

    .company-name {
        font-size: 15px;
        font-weight: 500;
    }

    @media only screen and (min-width: 768px) {
        .pres-image {
            border: 16px solid red;
            border-radius: 5px;
            padding: 40px;
            background-color: #e8f4f8;
        }

        .reader-image {
            width: 10% !important;
        }

        .company-name {
            font-size: 20px;
            font-weight: 500;
        }
    }
</style>

<div class="row mt-2 mb-5">
    <div class="col-12">
        <div class="card border-0 rounded-bottom-4 rounded-top-3" id="bubbleCard">
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <button onclick="redirectToURL('./')" type="button" class="btn btn-light back-button">
                            <i class="fa-solid fa-arrow-left-long"></i>
                        </button>
                    </div>

                    <div class="col-6">
                        <div class="profile-image profile-image-mini" style="background-image : url('./assets/images/user.png')"></div>
                    </div>


                    <div class="col-12 text-center">
                        <div class="p-2 text-light mt-3 fw-bold rounded-4 mb-3">Success Rate vs Complete Rate</div>
                        <div class="grade-value-container">
                            <div class="grade-value-overlay-1 mx-2">
                                <div class="grade-value-overlay-2">
                                    <input type="hidden" id="gradeValue" value="<?= $overallGrade ?>">
                                    <div class="grade-value" id="counter"><?= number_format($overallGrade, 1) ?></div>
                                </div>
                            </div>

                            <div class="grade-value-overlay-1 mx-2">
                                <div class="grade-value-overlay-2">
                                    <input type="hidden" id="gradeValue2" value="<?= $CompleteRate ?>">
                                    <div class="grade-value" id="counter2"><?= number_format($CompleteRate, 1) ?></div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card quiz-card border-0">
            <div class="card-body">
                <div class="quiz-img-box">
                    <img src="./lib/home/assets/images/medicine.gif" class="quiz-img rounded-4">
                </div>
                <h1 class="card-title text-center mt-2 fw-bold bg-light p-3 rounded-5 mb-0">Pharma Hunter</h1>

                <div class="border-top mt-3"></div>
                <h3 class="card-title mt-3 fw-bold rounded-4 mb-4 text-center">Gradings</h3>
                <div class="row g-3">
                    <div class="col-12 col-md-3 col-xl-3 d-flex">
                        <div class="card shadow-sm border-0 rounded-4 w-100">
                            <div class="card-body text-center">
                                <p class="mb-0">Pending Count</p>
                                <h1 class="mb-0 fw-bold"><?= $pendingCount ?></h1>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-3 col-xl-3 d-flex">
                        <div class="card shadow-sm border-0 rounded-4 w-100">
                            <div class="card-body text-center">
                                <p class="mb-0">Stored Count</p>
                                <h1 class="mb-0 fw-bold"><?= $correctCount ?></h1>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-3 col-xl-3 d-flex">
                        <div class="card shadow-sm border-0 rounded-4 w-100">
                            <div class="card-body text-center">
                                <p class="mb-0">Gem/Coin</p>
                                <h1 class="mb-0 fw-bold"><?= $gemCount ?>/<?= $coinCount ?></h1>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-3 col-xl-3 d-flex">
                        <div class="card shadow-sm border-0 rounded-4 w-100">
                            <div class="card-body text-center">
                                <p class="mb-0">Wrong Count</p>
                                <h1 class="mb-0 fw-bold"><?= $wrongCount ?></h1>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="row g-3 mt-4">
            <div class="col-12">

                <input type="hidden" value="" id="AttemptCount">
                <?php
                if (!empty($selectedArray)) {
                ?>
                    <div class="card rounded-4 border-0 shadow">
                        <div class="card-body">


                            <div class="row">
                                <div class="col-12 col-md-6 col-xl-6">
                                    <div class="pres-image mt-3">
                                        <div class="text-end mb-3">
                                            <img src="https://lms.pharmacollege.lk/assets/images/logo.png" class="reader-image">
                                        </div>

                                        <img class="w-100 rounded-2" src="https://web.pharmacollege.lk/modules/pharma-hunter/content/setup/requests/Medicine/images/<?= $filePath ?>" alt="<?= $medicineName ?>">

                                        <div class="text-center">
                                            <h2 class="company-name mt-3">Ceylon Pharma College</h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-xl-6">
                                    <?php
                                    if ($savedStatus == 1) {
                                    ?>
                                        <div class="row g-2 mt-4">
                                            <div class="col-12">
                                                <h4 class="card-title my-4 border-bottom pb-2 fw-bold"><?= $medicineName ?></h4>
                                            </div>
                                            <div class="col-3">
                                                <span class="w-100 badge btn-purple py-3"><?= $totalScore ?>/<?= $totalCorrectScore ?></span>
                                            </div>
                                            <div class="col-9">
                                                <?php
                                                if ($storingGrade < 0) {
                                                    $storingGrade = 0;
                                                }
                                                $ProgressValue = number_format($storingGrade); ?>
                                                <p class="m-0"><?= $ProgressValue ?>%</p>
                                                <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="<?= $ProgressValue ?>" aria-valuemin="0" aria-valuemax="100">
                                                    <div class="progress-bar" style="width: <?= $ProgressValue ?>%"><?= $ProgressValue ?>%</div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>

                                    <form id="store-form" action="#" method="post">

                                        <div class="row g-4">
                                            <div class="col-12">
                                                <h5 class="border-bottom pb-2 fw-bold">Select storing Details</h5>
                                            </div>

                                            <div class="col-md-6">
                                                <p class="mb-0 text-secondary">Select Rack</p>
                                                <input onclick="fillDataValue('racks')" required readonly type="text" name="racks" id="racks" class="w-100 btn btn-light  p-3" value="">
                                                <input type="hidden" id="racksId" name="racksId">
                                            </div>

                                            <div class="col-md-6">
                                                <p class="mb-0 text-secondary">Select Dosage Form</p>
                                                <input onclick="fillDataValue('dosageForm')" required readonly type="text" name="dosageForm" id="dosageForm" class="w-100 btn btn-light p-3" value="">
                                                <input type="hidden" id="dosageFormId" name="dosageFormId">
                                            </div>

                                            <div class="col-md-6">
                                                <p class="mb-0 text-secondary">Select Drug Category</p>
                                                <input onclick="fillDataValue('drugCategory')" required readonly type="text" name="drugCategory" id="drugCategory" class="w-100 btn btn-light p-3" value="">
                                                <input type="hidden" id="drugCategoryId" name="drugCategoryId">
                                            </div>

                                            <div class="col-12">
                                                <div class="row g-2 g-md-4">
                                                    <div class="col-md-6">
                                                        <button onclick="OpenIndex()" type="button" class="btn btn-success w-100 bgn-lg p-3"><i class="fa-solid fa-forward"></i> Skip</button>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <button onclick="ValidateAnswer('<?= $medicineId ?>', '<?= $CourseCode ?>')" type="button" class="btn btn-dark  w-100 bgn-lg p-3"><i class="fa-solid fa-boxes-packing"></i> Store Drug</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                } else {
                ?>
                    <div class="alert alert-warning">Game Over</div>
                <?php
                }
                ?>
            </div>
        </div>

    </div>
</div>

<!-- Script to add random bubbles -->
<script>
    var card = document.getElementById("bubbleCard");
    var positionPoints = [
        ['20%', '60%', '60px'],
        ['50%', '0%', '40px'],
        ['-10%', '20%', '100px'],
        ['80%', '65%', '50px'],
        ['75%', '30%', '90px'],
        ['10%', '65%', '15px']
    ];

    for (let i = 0; i < positionPoints.length; i++) {
        xPos = positionPoints[i][0];
        yPos = positionPoints[i][1];
        widthVal = positionPoints[i][2];
        createBubble(card, xPos, yPos, widthVal);
    }


    var gradeValueInput = document.getElementById('gradeValue');
    var gradeValue2Input = document.getElementById('gradeValue2');

    var overallDpadGrade = parseFloat(gradeValueInput.value);
    var completeRate = parseFloat(gradeValue2Input.value);

    var counterElement = document.getElementById('counter');
    var counterElement2 = document.getElementById('counter2');

    function updateCounter(element, value) {
        element.textContent = value.toFixed(1);
    }

    function loadCounter(element, targetValue) {
        let currentCounterValue = 0.0;
        const interval = 25; // Adjust the interval as needed
        const step = targetValue / (1000 / interval);

        const counterInterval = setInterval(function() {
            currentCounterValue += step;
            updateCounter(element, currentCounterValue);

            if (currentCounterValue >= targetValue) {
                clearInterval(counterInterval);
                updateCounter(element, targetValue);
            }
        }, interval);
    }

    // Call the function to start loading the counter for counterElement
    loadCounter(counterElement, overallDpadGrade);

    // Call the function to start loading the counter for counterElement2
    loadCounter(counterElement2, completeRate);
</script>