<?php

require_once '../../include/configuration.php';
include '../../php_handler/function_handler.php';
include './php_methods/pharma-reader-methods.php';

$userLevel = $_POST['UserLevel'];
$LoggedUser = $_POST['LoggedUser'];
$CourseCode = $_POST['defaultCourseCode'];

$prescriptionInfo = array();
$timeOfDay = getCurrentTimeOfDay();
$prescriptionDetailedList = GetPrescriptions();
$PrescriptionList = GetPrescriptionsIdList();
$prescriptionSubmissions = GetPrescriptionCorrectSubmissionsIdList($LoggedUser);

$unAnsweredPrescriptionsList = array_values(array_diff($PrescriptionList, $prescriptionSubmissions));

$arrayLength = count($unAnsweredPrescriptionsList);
if ($arrayLength > 0) {
    $randomArrayId = rand(0, $arrayLength - 1);
    $selectedPrescriptionId = $unAnsweredPrescriptionsList[$randomArrayId];
    $prescriptionInfo = $prescriptionDetailedList[$selectedPrescriptionId];
}

$gradeArray = GetOverallGrade($LoggedUser);
// var_dump($gradeArray);
$overallGrade = $gradeArray['overallGrade'];

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
                        <div class="p-2 text-light mt-3 fw-bold rounded-4 mb-3">Overall Grade</div>
                        <div class="grade-value-container">
                            <div class="grade-value-overlay-1 mx-2">
                                <div class="grade-value-overlay-2">
                                    <input type="hidden" id="gradeValue" value="<?= $overallGrade ?>">
                                    <div class="grade-value" id="counter"><?= number_format($overallGrade, 1) ?></div>
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
                <h1 class="card-title text-center mt-2 fw-bold bg-light p-3 rounded-5 mb-0">Pharma Reader</h1>

                <?php if ($userLevel != "Student") { ?>
                    <div class="border-top mt-3"></div>
                    <h3 class="card-title mt-3 fw-bold rounded-4 mb-2">Admin Panel</h3>
                    <div class="row g-3">

                        <div class="col-12 col-md-4 col-xl-4 d-flex">
                            <button onclick="NewPrescription()" class="btn btn-dark w-100 p-3 flex-fill" type="button">
                                <i class="fa-solid fa-plus fa-2x"></i>
                                <h5 class="mb-0 mt-2">Prescription</h5>
                            </button>
                        </div>

                    </div>
                <?php } ?>
            </div>
        </div>



        <div class="row g-3 mt-4">
            <div class="col-12">
                <?php
                if (!empty($prescriptionInfo)) {

                    $filePath = basename($prescriptionInfo['image_path']);
                    $pres_name = $prescriptionInfo['pres_name'];
                    $helpText = ($prescriptionInfo['PresHelp'] != "") ? $prescriptionInfo['PresHelp'] : '<p>No Help!</p>';

                    $prescriptionQuestion = ($prescriptionInfo['prescription_question'] != "") ? $prescriptionInfo['prescription_question'] : 'No Questions';
                    $answerNo1 = $prescriptionInfo['answer_1'];
                    $answerNo2 = $prescriptionInfo['answer_2'];
                    $answerNo3 = $prescriptionInfo['answer_3'];
                    $answerNo4 = $prescriptionInfo['answer_4'];
                    $correct_answer = $prescriptionInfo['correct_answer'];

                    $savedStatus = 0;
                    $readingGrade = rand(20, 100);
                    $totalScore = 50;
                    $totalCorrectScore = 100;
                ?>
                    <div class="card rounded-4 border-0 shadow">
                        <div class="card-body">

                            <div class="row">
                                <div class="col-12 col-md-6 col-xl-6">
                                    <img class="w-100 rounded-2" src="./lib/pharma-reader/assets/reader-images/<?= $filePath ?>" alt="<?= $pres_name ?> - <?= $filePath ?>">
                                </div>
                                <div class="col-12 col-md-6 col-xl-6">
                                    <div class="row">
                                        <div class="col-12">
                                            <h4 class="card-title my-4 border-bottom pb-2"><?= $pres_name ?></h4>
                                        </div>


                                        <div class="col-12">
                                            <h4 class="mt-3 fw-bold"><?= $prescriptionQuestion ?></h4>
                                            <div class="row g-2">

                                                <div class="col-12">
                                                    <div class="answer-card border p-3 bg-white clickable">
                                                        <h6 for="answerId1 ?>" class="mb-0 fw-bold" style="margin-right: 5px;"><?= $answerNo1 ?></h6>
                                                        <input type="radio" id="answerId1" name="answerId" value="<?= $answerNo1 ?>">
                                                        <div class="custom-checkbox"></div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="answer-card border p-3 bg-white clickable">
                                                        <h6 for="answerId2 ?>" class="mb-0 fw-bold" style="margin-right: 5px;"><?= $answerNo2 ?></h6>
                                                        <input type="radio" id="answerId2" name="answerId" value="<?= $answerNo2 ?>">
                                                        <div class="custom-checkbox"></div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="answer-card border p-3 bg-white clickable">
                                                        <h6 for="answerId3 ?>" class="mb-0 fw-bold" style="margin-right: 5px;"><?= $answerNo3 ?></h6>
                                                        <input type="radio" id="answerId3" name="answerId" value="<?= $answerNo3 ?>">
                                                        <div class="custom-checkbox"></div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="answer-card border p-3 bg-white clickable">
                                                        <h6 for="answerId4 ?>" class="mb-0 fw-bold" style="margin-right: 5px;"><?= $answerNo4 ?></h6>
                                                        <input type="radio" id="answerId4" name="answerId" value="<?= $answerNo4 ?>">
                                                        <div class="custom-checkbox"></div>
                                                    </div>
                                                </div>



                                                <div class="col-6">
                                                    <button onclick="GetHelp('<?= $selectedPrescriptionId ?>')" type="button" class="btn btn-success w-100 btn-lg p-3">Get Help</button>
                                                </div>
                                                <div class="col-6">
                                                    <button onclick="SaveReaderAnswer('<?= $selectedPrescriptionId ?>')" type="button" class="btn btn-dark w-100 btn-lg p-3">Save Answer</button>
                                                </div>

                                                <div class="col-12 mt-3">
                                                    <div class="border-bottom mb-3"></div>
                                                    <button onclick="OpenIndex()" class="btn btn-warning w-100 btn-lg p-3" type="button"><i class="fa-solid fa-forward-fast"></i> Skip</button>
                                                </div>


                                            </div>





                                        </div>
                                    </div>
                                    <?php
                                    if ($savedStatus == 1) {
                                    ?>
                                        <div class="row g-2 mt-4">
                                            <div class="col-3">
                                                <span class="w-100 badge btn-purple py-3"><?= $totalScore ?>/<?= $totalCorrectScore ?></span>
                                            </div>
                                            <div class="col-9">
                                                <?php
                                                if ($readingGrade < 0) {
                                                    $readingGrade = 0;
                                                }
                                                $ProgressValue = number_format($readingGrade); ?>
                                                <p class="m-0"><?= $ProgressValue ?>%</p>
                                                <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="<?= $ProgressValue ?>" aria-valuemin="0" aria-valuemax="100">
                                                    <div class="progress-bar" style="width: <?= $ProgressValue ?>%"><?= $ProgressValue ?>%</div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>

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
    var overallDpadGrade = parseFloat(gradeValueInput.value);
    var counterElement = document.getElementById('counter');

    function updateCounter(element, value) {
        // alert(element.textContent)
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



    var answerCards = document.querySelectorAll('.answer-card');

    // Add a click event listener to each '.answer-card' element
    answerCards.forEach(function(card) {
        card.addEventListener('click', function() {
            var radioInput = card.querySelector('input[type="radio"]');
            radioInput.checked = !radioInput.checked;
        });
    });
</script>