<?php
require_once '../../include/configuration.php';
include '../../php_handler/function_handler.php';
include './methods/functions.php';

$userLevel = $_POST['UserLevel'];
$loggedUser = $_POST['LoggedUser'];
$CourseCode = $_POST['defaultCourseCode'];

$userInfo = GetUserDetails($link, $loggedUser);


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
                                    <input type="hidden" id="gradeValue" value="1">
                                    <div class="grade-value" id="counter"><?= number_format(1, 1) ?></div>
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
                    <img src="./lib/home/assets/images/helpdesk.gif" class="quiz-img rounded-4">
                </div>
                <h1 class="card-title text-center mt-2 fw-bold bg-light p-3 rounded-5 mb-0">Support Tickets</h1>
            </div>
        </div>


    </div>

    <!-- Include Mail Box -->
    <?php include './components/mailbox.php' ?>
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