<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

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

$hunterMedicine = new HunterMedicine($db);
$hunterCourseMedicine = new HunterCourseMedicine($db);

$CountAnswer = GetHunterProAttempts($link);
$medicineList = $hunterMedicine->fetchAllMedicines();
$Medicines = $hunterCourseMedicine->GetProMedicines($CourseCode);
$Submissions = GetProSubmissions($link, $CountAnswer, $loggedUser);
$AllSubmissionsByMedicine  = GetAllSubmissionsByMedicine($link, $loggedUser);
$AllSubmissions = GetAllSubmissions($link, $loggedUser);


$correctItems = array_filter($AllSubmissions, function ($item) {
    return isset($item['answer_status']) && $item['answer_status'] === 'Correct';
});

$inCorrectItems = array_filter($AllSubmissions, function ($item) {
    return isset($item['answer_status']) && $item['answer_status'] === 'In-Correct';
});

if (count($correctItems) >= count($inCorrectItems)) {
    $gemCount = count($correctItems) - count($inCorrectItems);
    $coinCount = count($inCorrectItems);
} else {
    $gemCount = 0;
    $coinCount = count($correctItems);
}

?>
<div class="row mt-3">
    <div class="col-12 text-end">
        <button type="button" onclick="GetStoredHistory()" class="btn btn-warning"><i class="fa-solid fa-rotate-left"></i> Reload</button>
        <button type="button" onclick="OpenIndex()" class="btn btn-success"><i class="fa-solid fa-home"></i> Home</button>
    </div>
</div>

<style>
    .card-img {
        object-fit: cover;
        height: 200px;
    }
</style>

<div class="row g-3 mt-3">
    <?php
    $totalGem = $totalCoin = 0;
    foreach ($AllSubmissionsByMedicine as $submission) :
        $medicineId = $submission['medicine_id'];
        $Medicine = GetProMedicineByID($link, $medicineId)[0];

        $medicineName = $Medicine['medicine_name'];
        $filePath = $Medicine['image_url'];

        $savedItems = array_filter($AllSubmissions, function ($item) use ($medicineId) {
            return isset($item['medicine_id']) && $item['medicine_id'] === $medicineId;
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



    ?>
        <div class="col-12 col-md-4 col-xl-3">
            <div class="card rounded-4 shadow border-0 d-flex flex-column">
                <img class="w-100 rounded-top-4 card-img" src="./lib/pharma-hunter/assets/images/hunter-pro/<?= $filePath ?>" alt="<?= $medicineName ?>">
                <div class="card-body flex-grow-1">
                    <h4 class=""><?= $medicineName ?></h4>
                    <div class="card bg-light border-0 mb-2">
                        <div class="card-body text-center">
                            <p class="mb-0">Submissions</p>
                            <h2 class="mb-0"><?= $submission['attemptCount'] ?></h2>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between gap-2 mb-2">
                        <div class="p-2 bg-light rounded-3 flex-fill text-center"><i class="fa-solid fa-gem"></i> <?= $gemCount ?></div>
                        <div class="p-2 bg-light rounded-3 flex-fill  text-center"><i class="fa-solid fa-coins"></i> <?= $coinCount ?></div>
                    </div>

                    <div class="row g-2">
                        <div class="col-6">
                            <div class="card bg-light border-0">
                                <div class="card-body text-center">
                                    <p class="mb-0">Correct</p>
                                    <h2 class="mb-0"><?= count($correctItems) ?></h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card bg-light border-0">
                                <div class="card-body text-center">
                                    <p class="mb-0">Incorrect</p>
                                    <h2 class="mb-0"><?= count($inCorrectItems) ?></h2>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    <?php endforeach ?>
</div>