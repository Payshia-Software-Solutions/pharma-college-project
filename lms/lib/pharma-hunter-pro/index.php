<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

use Illuminate\Support\Arr;

require_once '../../include/configuration.php';
include '../../php_handler/function_handler.php';
include './php_methods/pharma-hunter-methods.php';

include_once './classes/Database.php';
include_once './classes/HunterMedicine.php';
include_once './classes/HunterCourseMedicine.php';

$userLevel = $_POST['UserLevel'];
$loggedUser = $_POST['LoggedUser'];
$CourseCode = $_POST['CourseCode'];

// Create a new Database object with the path to the configuration file
$config_file = '../../include/env.txt';
$database = new Database($config_file);
$db = $database->getConnection();

// Create objects
$hunterMedicine = new HunterMedicine($db);
$hunterCourseMedicine = new HunterCourseMedicine($db);

$medicineList = $hunterMedicine->fetchAllMedicines();
$Medicines = $hunterCourseMedicine->GetProMedicines($CourseCode);

$timeOfDay = getCurrentTimeOfDay();
$MedicineCount = count($Medicines);

$Score = GetAttemptResult($link, $loggedUser);
$AttemptCount = GetHpAttemptCount($link, $loggedUser);
$CountAnswer = GetHunterProAttempts($link);

// Create Score
$TotalScore = $AttemptCount * $CountAnswer * 4; //4 Selections 10 for each
$overallGrade = ($TotalScore > 0) ? ($Score / $TotalScore) * 100 : 0;

$AttemptRate = $AttemptCount / $CountAnswer;
if ($AttemptRate > $MedicineCount) {
    $AttemptRate = $MedicineCount;
}


$CompleteRate = ($MedicineCount > 0) ? ($AttemptRate / $MedicineCount) * 100 : 0;
$savedStatus = 0;

// $medicineList = GetProMedicine();
$CountAnswer = GetHunterProAttempts($link);
$Submissions = GetProSubmissions($link, $CountAnswer, $loggedUser);

if (empty($Medicines)) {
    echo "No Medicines Allocated to this Course";
    exit;
}

$UniqueMedicines = array_diff($Medicines, $Submissions);
$UniqueMedicines = array_values($UniqueMedicines);

$length = count($UniqueMedicines);
$selectedArray = array();
if (isset($_POST['MedicineID'])) {
    $medicineId = $_POST['MedicineID'];

    if (in_array($medicineId, $UniqueMedicines)) {
        $selectedArray = $medicineList[$medicineId];
    }
} else {
    if ($length > 0) {
        $randomNumber = rand(0, $length - 1);
        $medicineId = $UniqueMedicines[$randomNumber];
        $selectedArray = $medicineList[$medicineId];
    }
}

if (!empty($selectedArray)) {
    $medicineId = $selectedArray['id'];
    $medicineName = $selectedArray['medicine_name'];
    $filePath = $selectedArray['image_url'];
}



// Get Gem & Coin Counts
$correctAttempts = GetHPCorrectAttempts($link, $loggedUser);
$pendingCount = ($MedicineCount * $CountAnswer) - count($correctAttempts);


$totalGem = $totalCoin = 0;
$AllSubmissionsByMedicine  = GetAllSubmissionsByMedicine($link, $loggedUser);
$AllSubmissions = GetAllSubmissions($link, $loggedUser);
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
        $gemCount = count($correctItems) - count($inCorrectItems);
        $coinCount = count($inCorrectItems);
    } else {
        $gemCount = 0;
        $coinCount = count($correctItems);
    }


    $totalCoin += $coinCount;
    $totalGem += $gemCount;
endforeach;

$gemCount = $totalGem + intval($totalCoin / 50);
$coinCount = $totalCoin  % 50;
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
</style>

<div class="row mt-2 mb-5">
    <div class="col-12">

        <div class="card border-0 mt-5">
            <div class="card-body">
                <div class="quiz-img-box">
                    <img src="./lib/home/assets/images/medicine.gif" class="quiz-img rounded-4">
                </div>
                <h1 class="card-title text-center mt-2 fw-bold bg-light p-3 rounded-5 mb-0">Pharma Hunter Pro</h1>

                <?php if ($userLevel != "Student") { ?>
                    <div class="border-top mt-3"></div>
                    <h3 class="card-title mt-3 fw-bold rounded-4 mb-2">Admin Panel</h3>
                    <div class="row g-3">
                        <div class="col-12 col-md-3 col-xl-3 d-flex">
                            <button onclick="alert('Coming Soon.....')" class="btn btn-purple w-100 p-3 flex-fill" type="button">
                                <i class="fa-solid fa-wand-magic-sparkles fa-2x"></i>
                                <h5 class="mb-0 mt-2">Generate</h5>
                            </button>
                        </div>

                        <div class="col-12 col-md-3 col-xl-3 d-flex">
                            <button onclick="NewPrescription()" class="btn btn-dark w-100 p-3 flex-fill" type="button">
                                <i class="fa-solid fa-plus fa-2x"></i>
                                <h5 class="mb-0 mt-2">Medicine</h5>
                            </button>
                        </div>

                        <div class="col-12 col-md-3 col-xl-3 d-flex">
                            <button onclick=" OpenControlPanel()" class="btn btn-primary w-100 p-3 flex-fill" type="button">
                                <i class="fa-solid fa-sliders fa-2x"></i>
                                <h5 class="mb-0 mt-2">Setting</h5>
                            </button>
                        </div>

                        <div class="col-12 col-md-3 col-xl-3 d-flex">
                            <button onclick="" class="btn btn-purple text-white w-100 p-3 flex-fill" type="button">
                                <i class="fa-solid fa-gear fa-2x"></i>
                                <h5 class="mb-0 mt-2">Setup</h5>
                            </button>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>



        <div class="row mt-3">
            <div class="col-12">
                <div class="card shadow border-0">
                    <div class="card-body">
                        <div class="row g-2">
                            <div class="col-12">
                                <div class="card border-0 flex-fill">
                                    <div class="card-body text-center">
                                        <h1 class="mb-0"><i class="fa-solid fa-trophy"></i> Stats</h1>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3 d-flex">
                                <div class="card bg-light border-0 flex-fill clickable" onclick="GetStoredHistory()">
                                    <div class="card-body text-center">
                                        <label for="stored_count">Stored Count</label>
                                        <h2 class="mb-0 fw-bold"><?= count($correctAttempts) ?></h2>
                                    </div>
                                </div>
                            </div>

                            <div class="col-6 col-md-3 d-flex">
                                <div class="card bg-light border-0 flex-fill">
                                    <div class="card-body text-center">
                                        <label for="stored_count">Pending Count</label>
                                        <h2 class="mb-0 fw-bold"><?= $pendingCount ?></h2>
                                    </div>
                                </div>
                            </div>

                            <div class="col-6 col-md-3 d-flex">
                                <div class="card bg-light border-0 flex-fill">
                                    <div class="card-body text-center">
                                        <label for="stored_count">Gem Count</label>
                                        <h2 class="mb-0 fw-bold"><?= $gemCount ?></h2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3 d-flex">
                                <div class="card bg-light border-0 flex-fill">
                                    <div class="card-body text-center">
                                        <label for="stored_count">Coin Count</label>
                                        <h2 class="mb-0 fw-bold"><?= $coinCount ?></h2>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <button type="button" onclick="GetStoredHistory()" class="btn btn-light btn-hover-light w-100"><i class="fa-solid fa-eye"></i> View Store</button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="" id="inner-content">
            <div class="row g-3 mt-4">
                <div class="col-12">
                    <?php
                    if (!empty($selectedArray)) {
                    ?>
                        <div class="card rounded-4 border-0 shadow">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 col-md-6 col-xl-6">
                                        <img class="w-100 rounded-2" src="./lib/pharma-hunter/assets/images/hunter-pro/<?= $filePath ?>" alt="<?= $medicineName ?>">
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
                                                    <p class="mb-0 text-secondary">Select Drug Group</p>
                                                    <input onclick="fillDataValue('drugGroup')" required readonly type="text" name="drugGroup" id="drugGroup" class="w-100 btn btn-light p-3" value="">
                                                    <input type="hidden" id="drugGroupId" name="drugGroupId">
                                                </div>

                                                <div class="col-md-6">
                                                    <p class="mb-0 text-secondary">Select Category</p>
                                                    <input onclick="fillDataValue('drugCategory')" required readonly type="text" name="drugCategory" id="drugCategory" class="w-100 btn btn-light p-3" value="">
                                                    <input type="hidden" id="drugCategoryId" name="drugCategoryId">
                                                </div>

                                                <div class="col-12">

                                                    <div class="row g-2 g-md-4">
                                                        <div class="row mt-3">
                                                            <div class="col-12">
                                                                <div id="rackError"></div>
                                                                <div id="drugError"></div>
                                                                <div id="categoryError"></div>
                                                                <div id="dosageError"></div>
                                                            </div>
                                                        </div>

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
</div>