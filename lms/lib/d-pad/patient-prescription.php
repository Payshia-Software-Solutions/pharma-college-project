<?php
require_once '../../include/configuration.php';
include '../../php_handler/function_handler.php';
include './php_methods/d-pad-methods.php';

$UserLevel = $_POST['UserLevel'];
$loggedUser = $_POST['LoggedUser'];
$imageID = $_POST['imageID'];
$prescriptionID = $_POST['prescriptionID'];

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
                        <button onclick="OpenIndex()" type="button" class="btn btn-light back-button">
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
        <button class="btn btn-dark btn-sm rounded-3" onclick="OpenPrescription('<?= $prescriptionID ?>', '<?= $imageID ?>')"><i class="fa-solid fa-rotate-right player-icon"></i> Reload</button>
        <button class="btn btn-warning btn-sm rounded-3" onclick="OpenIndex()"><i class="fa-solid fa-home player-icon"></i> Home</button>
    </div>

    <div class="col-12 col-md-6 mb-2 mt-3">
        <div class="card border-0 rounded-4 shadow-sm flex-fill mt-3">
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-4 text-center">
                        <img src="./lib/ceylon-pharmacy/assets/images/patient-<?= $imageID ?>.png" class="w-100">
                    </div>
                    <div class="col-8 text-start">
                        <h4 class="card-title border-bottom pb-2 fw-bolder"><?= $patient['prescription_name'] ?></h4>
                    </div>
                    <div class="col-12 mb-3">
                        <div class="row g-2">
                            <div class=" <?= ($UserLevel == "Student") ? 'col-12' : 'col-8' ?>">
                                <button class="btn btn-dark w-100 p-2 mt-3" onclick="GetPatient('<?= $prescriptionID ?>') ">Start</button>
                            </div>

                            <div class="<?= ($UserLevel == "Student") ? 'd-none' : 'col-4' ?>">
                                <button class="btn btn-success w-100 p-2 mt-3" onclick="NewPrescription('<?= $prescriptionID ?>') ">Edit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>

    <div class="col-12 col-md-6 mb-2  text-center" id="prescription"></div>
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