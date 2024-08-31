<?php
require_once '../../include/configuration.php';
include '../../php_handler/function_handler.php';
include './php_methods/d-pad-methods.php';

$userLevel = $_POST['UserLevel'];
$loggedUser = $_POST['LoggedUser'];
$CourseCode = $_POST['CourseCode'];
$prescriptionList = GetPrescriptions();
$overallDpadGrade =  OverallGradeDpad($loggedUser)['overallGrade'];
// var_dump(OverallGradeDpad($loggedUser));

$savedAnswers = GetSubmittedAnswersByUser($loggedUser);

// var_dump($savedAnswers);
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
                        <div class="grade-value-container">
                            <div class="grade-value-overlay-1">
                                <div class="grade-value-overlay-2">
                                    <input type="hidden" id="gradeValue" value="<?= $overallDpadGrade ?>">
                                    <div class="grade-value" id="counter"><?= number_format($overallDpadGrade, 1) ?></div>
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
                    <img src="./lib/home/assets/images/pill.gif" class="quiz-img rounded-4">
                </div>
                <h1 class="card-title text-center mt-2 fw-bold bg-light p-3 rounded-5 mb-0">D-Pad</h1>

                <?php if ($userLevel != "Student") { ?>
                    <div class="border-top mt-3"></div>
                    <h3 class="card-title mt-3 fw-bold rounded-4 mb-2">Admin Panel</h3>
                    <div class="row g-3">
                        <div class="col-12 col-md-3 col-xl-3 d-flex">
                            <button onclick="GeneratePrescription()" class="btn btn-purple w-100 p-3 flex-fill" type="button">
                                <i class="fa-solid fa-wand-magic-sparkles fa-2x"></i>
                                <h5 class="mb-0 mt-2">Generate</h5>
                            </button>
                        </div>

                        <div class="col-12 col-md-3 col-xl-3 d-flex">
                            <button onclick="NewPrescription()" class="btn btn-dark w-100 p-3 flex-fill" type="button">
                                <i class="fa-solid fa-plus fa-2x"></i>
                                <h5 class="mb-0 mt-2">Prescriptions</h5>
                            </button>
                        </div>

                        <div class="col-12 col-md-3 col-xl-3 d-flex">
                            <button onclick=" OpenControlPanel()" class="btn btn-primary w-100 p-3 flex-fill" type="button">
                                <i class="fa-solid fa-sliders fa-2x"></i>
                                <h5 class="mb-0 mt-2">Setting</h5>
                            </button>
                        </div>

                        <div class="col-12 col-md-3 col-xl-3 d-flex">
                            <button onclick="OpenSetting()" class="btn btn-success w-100 p-3 flex-fill" type="button">
                                <i class="fa-solid fa-file fa-2x"></i>
                                <h5 class="mb-0 mt-2">Results</h5>
                            </button>
                        </div>
                        <div class="col-12 col-md-3 col-xl-3 d-flex">
                            <button onclick="OpenSubmissionSetting()" class="btn btn-danger w-100 p-3 flex-fill" type="button">
                                <i class="fa-solid fa-user-xmark fa-2x"></i>
                                <h5 class="mb-0 mt-2">Submissions</h5>
                            </button>
                        </div>
                        <div class="col-12 col-md-3 col-xl-3 d-flex">
                            <button onclick="OpenPosProductPage()" class="btn btn-secondary w-100 p-3 flex-fill" type="button">
                                <i class="fa-solid fa-pills fa-2x"></i>
                                <h5 class="mb-0 mt-2">Products</h5>
                            </button>
                        </div>
                        <div class="col-12 col-md-3 col-xl-3 d-flex">
                            <button onclick="" class="btn btn-info text-white w-100 p-3 flex-fill" type="button">
                                <i class="fa-solid fa-stethoscope fa-2x"></i>
                                <h5 class="mb-0 mt-2">Counselling</h5>
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

        <div class="row g-3 mt-4">
            <div class="col-12">
                <h5 class="border-bottom mb-2 pb-1 fw-bold">Available Prescriptions</h5>
            </div>
            <?php
            if (!empty($prescriptionList)) {
                $loopCount = $imageId = 0; // Initialize the loop count.

                foreach ($prescriptionList as $selectedArray) {

                    $prescriptionStatus = $selectedArray['prescription_status'];
                    if ($prescriptionStatus == "In-Active" && $userLevel == "Student") {
                        continue;
                    }

                    if ($imageId == 10) {
                        $imageId = 0;
                    }

                    $loopCount++; // Increment the loop count.
                    $imageId++;
                    $bgColor = "primary";

                    // if ($UserLevel == "Student") {
                    //     continue;
                    // }
                    $prescriptionBgColor = "danger";
                    if ($prescriptionStatus == "Active") {
                        $prescriptionBgColor = "primary";
                    }

                    $prescriptionId = $selectedArray['prescription_id'];
                    $prescriptionGrade = GradeByPrescription($prescriptionId, $loggedUser, $savedAnswers);

                    $prescriptionGradeValue = $prescriptionGrade['prescriptionGrade'];
                    $totalScore = $prescriptionGrade['totalScore'];
                    $totalEnvelopes = $prescriptionGrade['totalEnvelopes'];
                    $scorePerPrescription = $prescriptionGrade['scorePerPrescription'];
                    $totalCorrectScore = $totalEnvelopes * $scorePerPrescription;
                    $correctCount =  $prescriptionGrade['correctCount'];

                    $closeStatus = "Pending";
                    $closeBg = 'primary';

                    if ($correctCount == $totalEnvelopes) {
                        $closeStatus = "Completed";
                        $closeBg = 'dark';
                    }

            ?>
                    <div class="col-12 col-md-4 col-xl-3 d-flex">
                        <div class="card clickable border-0 admin-card shadow flex-fill text-center" onclick="OpenPrescription('<?= $prescriptionId  ?>', '<?= $imageId ?>')">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="bg-light rounded-3 p-2">
                                            <span class="badge bg-<?= $closeBg ?> mb-1"><?= $closeStatus ?></span>
                                            <?php
                                            if ($prescriptionStatus == "In-Active") { ?>
                                                <span class="badge bg-<?= $prescriptionBgColor ?> mb-1"><?= $prescriptionStatus ?></span>
                                            <?php } ?>
                                        </div>
                                        <h4 class="card-title my-4 border-bottom pb-2 fw-bold">Prescription <?= $loopCount ?></h4>

                                        <div class="row g-2">
                                            <div class="col-3">
                                                <span class="w-100 badge btn-purple py-3"><?= $totalScore ?>/<?= $totalCorrectScore ?></span>
                                            </div>
                                            <div class="col-9">
                                                <?php
                                                if ($prescriptionGradeValue < 0) {
                                                    $prescriptionGradeValue = 0;
                                                }
                                                $ProgressValue = number_format($prescriptionGradeValue); ?>
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
                    </div>
            <?php
                }
            }
            ?>
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
    var overallDpadGrade = parseFloat(gradeValueInput.value);
    var counterElement = document.getElementById('counter')

    function updateCounter(value) {
        counterElement.textContent = value.toFixed(1);
    }

    function loadCounter() {
        let currentCounterValue = 0.0;
        const interval = 25; // Adjust the interval as needed
        const step = overallDpadGrade / (1000 / interval);

        const counterInterval = setInterval(function() {
            currentCounterValue += step;
            updateCounter(currentCounterValue);

            if (currentCounterValue >= overallDpadGrade) {
                clearInterval(counterInterval);
                updateCounter(overallDpadGrade);
            }
        }, interval);
    }

    // Call the function to start loading the counter
    loadCounter();
</script>