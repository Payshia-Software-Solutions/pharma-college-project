<div class="row">
    <div class="col-12">
        <h4 class="section-topic">Let's Play</h4>
    </div>

    <div class="col-6 col-md-4 mb-2 d-flex">
        <div class="card game-card shadow flex-fill">
            <div class="card-body text-center" onclick="redirectToURL('win-pharma')">
                <div class="row">
                    <div class="col-12">
                        <img src="./lib/home/assets/images/drugs.gif" class="game-icon">
                        <h4 class="card-title">Win Pharma</h4>
                    </div>

                    <div class="col-12 mt-2">
                        <?php $ProgressValue = $winPharmaPercentage; ?>
                        <p class="m-0"><?= number_format($ProgressValue) ?>%</p>
                        <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="<?= $ProgressValue ?>" aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar" style="width: <?= $ProgressValue ?>%"><?= number_format($ProgressValue, 2) ?>%</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-6 col-md-4 mb-2 d-flex">
        <div class="card game-card shadow flex-fill" onclick="redirectToURL('d-pad')">
            <div class="card-body text-center">
                <div class="row">
                    <div class="col-12">
                        <img src="./lib/home/assets/images/pill.gif" class="game-icon">
                        <h4 class="card-title">D Pad</h4>
                    </div>

                    <div class="col-12 mt-2">
                        <?php

                        $overallGradeDpad =  OverallGradeDpad($loggedUser)['overallGrade'];
                        $ProgressValue = number_format($overallGradeDpad); ?>
                        <p class="m-0"><?= $ProgressValue ?>%</p>
                        <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="<?= $ProgressValue ?>" aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar" style="width: <?= $ProgressValue ?>%"><?= $ProgressValue ?>%</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-6 col-md-4 mb-2 d-flex">
        <div class="card game-card shadow flex-fill" onclick="redirectToURL('ceylon-pharmacy')">
            <div class="card-body text-center">
                <?php
                $RecoveredPatientsCount =  GetRecoveredPatientsByCourse($link, $courseCode, $loggedUser);
                $CoursePatientsCount = count(GetCoursePatients($link, $courseCode));

                if ($CoursePatientsCount != 0) {
                    $ProgressValue = number_format(($RecoveredPatientsCount / $CoursePatientsCount) * 100);
                } else {
                    $ProgressValue = 0;
                }
                ?>
                <div class="row">
                    <div class="col-12">
                        <img src="./lib/ceylon-pharmacy/assets/images/pharmacy.gif" class="game-icon">
                        <h4 class="card-title">Ceylon Pharmacy</h4>
                    </div>

                    <div class="col-12 mt-2">
                        <p class="m-0"><?= $RecoveredPatientsCount ?> out of <?= $CoursePatientsCount ?></p>
                        <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="<?= $ProgressValue ?>" aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar" style="width: <?= $ProgressValue ?>%"><?= $ProgressValue ?>%</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-6 col-md-4 mb-2 d-flex">
        <div class="card game-card shadow flex-fill" onclick="redirectToURL('pharma-hunter')">
            <div class="card-body text-center">
                <div class="row">
                    <div class="col-12">
                        <img src="./lib/home/assets/images/medicine.gif" class="game-icon">
                        <h4 class="card-title">Pharma Hunter</h4>
                    </div>

                    <?php
                    // Pharma Hunter
                    $attemptPerMedicine = 10;
                    $hunterMedicines = HunterMedicines();
                    $medicineCount = count($hunterMedicines);
                    $savedCounts = HunterSavedAnswersByUser($loggedUser);

                    // echo $medicineCount;

                    $correctCount = $pendingCount = $wrongCount = $gemCount = $coinCount = 0;
                    $pendingCount = $medicineCount * $attemptPerMedicine;
                    if (isset($savedCounts[$loggedUser])) {
                        $correctCount = $savedCounts[$loggedUser]['correct_count'];
                        $pendingCount = $medicineCount * $attemptPerMedicine - $correctCount;
                        $wrongCount = $savedCounts[$loggedUser]['incorrect_count'];
                        $gemCount = $savedCounts[$loggedUser]['gem_count'];
                        $coinCount =  $savedCounts[$loggedUser]['coin_count'];

                        if ($coinCount >= 50) {
                            $gemCount = $gemCount + intval($coinCount / 50);
                            $coinCount = $coinCount % 50;
                        }
                    }

                    $ProgressValue = ($correctCount / ($medicineCount * $attemptPerMedicine)) * 100;
                    if ($ProgressValue > 100) {
                        $ProgressValue = 100;
                    }

                    ?>

                    <div class="col-12 mt-2">
                        <div class="d-flex justify-content-between gap-2 mb-2">
                            <div class="p-2 bg-light rounded-3 flex-fill"><i class="fa-solid fa-gem"></i> <?= $gemCount ?></div>
                            <div class="p-2 bg-light rounded-3 flex-fill"><i class="fa-solid fa-coins"></i> <?= $coinCount ?></div>
                        </div>
                        <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="<?= $ProgressValue ?>" aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar" style="width: <?= $ProgressValue ?>%"><?= number_format($ProgressValue, 2) ?>%</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-6 col-md-4 mb-2 d-flex">
        <div class="card game-card shadow flex-fill" onclick="redirectToURL('pharma-hunter-pro')">
            <div class="card-body text-center">
                <div class="row">
                    <div class="col-12">

                        <img src="./lib/pharma-hunter-pro/assets/images/icon/medicine.gif" class="game-icon">
                        <h4 class="card-title">Hunter Pro</h4>
                    </div>

                    <div class="col-12 mt-2">
                        <?php
                        include_once '../pharma-hunter-pro/classes/HunterCourseMedicine.php';
                        include '../pharma-hunter-pro/php_methods/pharma-hunter-methods.php';
                        $hunterCourseMedicine = new HunterCourseMedicine($db);
                        $Medicines = $hunterCourseMedicine->GetProMedicines($batchCode);

                        $MedicineCount = count($Medicines);
                        // Get Gem & Coin Counts
                        $CountAnswer = GetHunterProAttempts($link);
                        $correctAttempts = GetHPCorrectAttempts($link, $loggedUser);
                        $pendingCount = ($MedicineCount * $CountAnswer) - count($correctAttempts);

                        $totalGem = $totalCoin = 0;
                        $AllSubmissionsByMedicine  = GetAllSubmissionsByMedicine($link, $loggedUser);
                        $AllSubmissions = GetAllSubmissions($link, $loggedUser);
                        foreach ($AllSubmissionsByMedicine as $submission) :
                            $medicineId = $submission['medicine_id'];
                            $savedItems = array_filter($AllSubmissions, function ($item) use ($medicineId) {
                                return isset($item['medicine_id']) && $item['medicine_id'] === $medicineId;
                            });

                            $correctItems = array_filter($savedItems, function ($item) {
                                return isset($item['answer_status']) && $item['answer_status'] === 'Correct';
                            });

                            $inCorrectItems = array_filter($savedItems, function ($item) {
                                return isset($item['answer_status']) && $item['answer_status'] === 'In-Correct';
                            });

                            $gemArray = array_filter($correctItems, function ($item) {
                                return isset($item['score']) && $item['score'] === '40';
                            });

                            $gemCount = count($gemArray);
                            $coinCount = count($correctItems) - $gemCount;

                            // if (count($correctItems) >= count($inCorrectItems)) {
                            //     $gemCount = count($correctItems) - count($inCorrectItems);
                            //     $coinCount = count($inCorrectItems);
                            // } else {
                            //     $gemCount = 0;
                            //     $coinCount = count($correctItems);
                            // }


                            $totalCoin += $coinCount;
                            $totalGem += $gemCount;
                        endforeach;

                        $gemCount = $totalGem + intval($totalCoin / 50);
                        $coinCount = $totalCoin  % 50;

                        $ProgressValue = number_format((count($correctAttempts) / ($MedicineCount * $CountAnswer)) * 100, 2); ?>
                        <div class="d-flex justify-content-between gap-2 mb-2">
                            <div class="p-2 bg-light rounded-3 flex-fill"><i class="fa-solid fa-gem"></i> <?= $gemCount ?></div>
                            <div class="p-2 bg-light rounded-3 flex-fill"><i class="fa-solid fa-coins"></i> <?= $coinCount ?></div>
                        </div>
                        <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="<?= $ProgressValue ?>" aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar" style="width: <?= $ProgressValue ?>%"><?= $ProgressValue ?>%</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="col-6 col-md-4 mb-2 d-flex">
        <div class="card game-card shadow flex-fill" onclick="redirectToURL('pharma-reader')">
            <div class="card-body text-center">
                <div class="row">
                    <div class="col-12">

                        <img src="./lib/home/assets/images/alternative-medicine.gif" class="game-icon">
                        <h4 class="card-title">Pharma Reader</h4>
                    </div>

                    <div class="col-12 mt-2">
                        <?php $ProgressValue = 0; ?>
                        <p class="m-0"><?= $ProgressValue ?>%</p>
                        <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="<?= $ProgressValue ?>" aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar" style="width: <?= $ProgressValue ?>%"><?= $ProgressValue ?>%</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>