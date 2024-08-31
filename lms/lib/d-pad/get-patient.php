<?php
require_once '../../include/configuration.php';
include '../../php_handler/function_handler.php';
include './php_methods/d-pad-methods.php';

$UserLevel = $_POST['UserLevel'];
$loggedUser = $_POST['LoggedUser'];
$prescriptionID = $_POST['prescriptionID'];


$task_2_active = "Not Permitted. Please Complete Above Task!";
$task_2_bg = "warning";


$prescriptionArray = GetPrescriptions()[$prescriptionID];
$medicineEnvelopes =  GetPrescriptionCoversDpad($prescriptionID);

$patient = GetPrescriptions()[$prescriptionID];
$savedAnswers = GetSubmittedAnswersByUser($loggedUser);
$prescriptionId = $prescriptionID;
$prescriptionGrade = GradeByPrescription($prescriptionId, $loggedUser, $savedAnswers);

$prescriptionGradeValue = $prescriptionGrade['prescriptionGrade'];
$totalScore = $prescriptionGrade['totalScore'];
$totalEnvelopes = $prescriptionGrade['totalEnvelopes'];
$scorePerPrescription = $prescriptionGrade['scorePerPrescription'];
$totalCorrectScore = $totalEnvelopes * $scorePerPrescription;
$correctCount =  $prescriptionGrade['correctCount'];
?>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Indie+Flower&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

    .handwrite {
        font-family: 'Indie Flower', cursive;
        font-size: 20 px;
    }

    .prescription-card {
        background-color: #FFFEFE;
        border: 15px solid #009E60;
        border-radius: 0px !important;
    }

    .prescription-card .mini-text {
        font-size: 10px;
    }
</style>

<div class="row">
    <div class="col-12 mt-3">
        <div class="card border-0 rounded-bottom-4 rounded-top-3" id="bubbleCard">
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <button onclick="OpenPrescription('<?= $prescriptionID ?>', '1')" type="button" class="btn btn-light back-button">
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
                                    <input type="hidden" id="gradeValue" value="<?= $prescriptionGradeValue ?>">
                                    <div class="grade-value" id="counter"><?= number_format($prescriptionGradeValue, 1) ?></div>
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
                <h2 class="card-title text-center mt-2 fw-bold bg-light p-3 rounded-4 mb-0">Let's Treat <?= $patient['prescription_name'] ?></h2>
            </div>
        </div>

    </div>

    <div class="col-12 text-end mt-3">
        <button class="btn btn-dark btn-sm rounded-3" onclick="GetPatient('<?= $prescriptionID ?>')"><i class="fa-solid fa-rotate-right player-icon"></i> Reload</button>
        <button class="btn btn-warning btn-sm rounded-3" onclick="OpenIndex()"><i class="fa-solid fa-home player-icon"></i> Home</button>
    </div>

    <div class="col-12 col-md-6 mb-2 d-none" id="prescription"></div>

    <div class="col-12 mb-5">
        <h4 class="section-topic mb-0">Task 1</h4>
        <p class="my-0 border-bottom pb-2 mini-text">Fill the Medicine Envelopes</p>
    </div>

    <div class="col-12">
        <div class="row g-3">
            <?php
            $correctLoopCount = 0; // Initialize the loop count.
            if (!empty($medicineEnvelopes)) {
                $medicineCount = 1;
                foreach ($medicineEnvelopes as $selectedItem) {
                    $badgeColor = "warning";
                    $answerStatus = "Not Completed";

                    $coverId = 'Cover' . $medicineCount++;

                    $correctAnswer = DpadGetSavedAnswersByCover($prescriptionID, $coverId);
                    $SubmissionArray = DpadSubmittedAnswersByCover($loggedUser, $coverId, $prescriptionID, "Correct");



                    if (!empty($SubmissionArray)) {
                        $answerStatus = "Completed";
                        $badgeColor = "primary";
                        $correctLoopCount++; // Increment the loop count.
                    }

                    $drugName = null;
                    if (!empty($correctAnswer[0])) {
                        $drugName = $correctAnswer[0]['drug_name'];
                    }


                    $gradeEnvelope = GradeByEnvelope($prescriptionId, $loggedUser, $savedAnswers, $coverId);
                    $coverGrade = $gradeEnvelope['coverGrade'];
                    $coverScore = $gradeEnvelope['totalScore'];

            ?>
                    <div class="col-12 col-md-4 mb-4 mb-md-2 d-flex">
                        <div class="card game-card shadow flex-fill" onclick="OpenEnvelope('<?= $prescriptionID ?>', '<?= $coverId ?>')">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 text-center">
                                        <img src="./lib/ceylon-pharmacy/assets/images/envelope.png" class="game-icon rounded-4 shadow-sm p-3 bg-light">
                                        <h4 class="card-title"><?= $selectedItem ?></h4>
                                        <span class="bg-<?= $badgeColor ?> badge badge-<?= $badgeColor ?> mt-2"><?= $answerStatus ?></span>
                                        <div class="border-bottom mt-3"></div>
                                    </div>
                                </div>

                                <div class="row g-2 mt-3">
                                    <div class="col-3">
                                        <span class="w-100 badge btn-purple py-3"><?= $coverScore ?>/10</span>
                                    </div>
                                    <div class="col-9">
                                        <?php
                                        if ($coverGrade < 0) {
                                            $coverGrade = 0;
                                        }
                                        $ProgressValue = number_format($coverGrade); ?>
                                        <p class="m-0"><?= $ProgressValue ?>%</p>
                                        <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="<?= $ProgressValue ?>" aria-valuemin="0" aria-valuemax="100">
                                            <div class="progress-bar" style="width: <?= $ProgressValue ?>%"><?= $ProgressValue ?>%</div>
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