<?php
require_once '../../include/configuration.php';
include '../../php_handler/function_handler.php';
include '../../php_handler/course_functions.php';
include './php_method/quiz_methods.php';


$userLevel = $_POST['UserLevel'];
$loggedUser = $_POST['LoggedUser'];
$courseCode = $_POST['defaultCourseCode']; // Course will be taken as Batch

// Payments
$studentBalanceArray = GetStudentBalance($loggedUser);
$studentBalance = $studentBalanceArray['studentBalance'];

$quizTopicsByCourse = GetQuizTopicsByCourse($courseCode);
$topicList = GetQuizTopics();
$overallQuizGrade = GetOverallGrade($loggedUser, $courseCode);

$quizSubmissions = GetQuizSubmissionByUser($loggedUser);
?>
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
                                    <div class="grade-value"><?= number_format($overallQuizGrade, 2) ?></div>
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
                    <img src="./lib/home/assets/images/question.gif" class="quiz-img rounded-4">
                </div>
                <h1 class="card-title text-center mt-2 fw-bold bg-light p-3 rounded-5 mb-0">Quiz</h1>

                <?php if ($userLevel != "Student") { ?>
                    <div class="border-top mt-3"></div>
                    <h3 class="card-title mt-3 fw-bold rounded-4 mb-1">Admin Panel</h3>
                    <div class="row g-3">
                        <div class="col-6 col-md-4 col-xl-4 d-flex">
                            <button onclick="SetupQuiz()" class="btn btn-purple w-100 p-3 flex-fill" type="button">
                                <i class="fa-solid fa-list-check fa-2x"></i>
                                <h5 class="mb-0 mt-1">Setup</h5>
                            </button>
                        </div>

                        <div class="col-6 col-md-4 col-xl-4 d-flex">
                            <button onclick="AddTopics()" class="btn btn-dark w-100 p-3 flex-fill" type="button">
                                <i class="fa-solid fa-plus fa-2x"></i>
                                <h5 class="mb-0 mt-1">Topics</h5>
                            </button>
                        </div>

                        <div class="col-6 col-md-4 col-xl-4 d-flex">
                            <button onclick="OpenSetting()" class="btn btn-primary w-100 p-3 flex-fill" type="button">
                                <i class="fa-solid fa-sliders fa-2x"></i>
                                <h5 class="mb-0 mt-1">Setting</h5>
                            </button>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>

        <div class="row g-2 mt-4">
            <div class="col-12">
                <h5 class="border-bottom mb-2 pb-1 fw-bold">Available Quizzes</h5>
            </div>

            <?php

            if (!empty($quizTopicsByCourse)) {
                foreach ($quizTopicsByCourse as $selectedArray) {
                    $quizId = $selectedArray['topicID'];

                    if ($selectedArray['active_status'] == 'Deleted') {
                        continue;
                    }

                    $selectedTopic = $topicList[$quizId];
                    $quizGrade =  GetGradeByQuiz($quizId, $loggedUser);
                    $totalAttempts = $quizGrade['correctAttemptCount'] + $quizGrade['inCorrectAttemptCount'];

                    $openStatus = ($totalAttempts > 0) ? 'Opened' : 'Not Open';
                    $openStatusBadgeColor = ($totalAttempts > 0) ? 'success' : 'primary';

                    if ($quizGrade['quizGrade'] == 100) {
                        $openStatus = "Completed";
                        $openStatusBadgeColor = "dark";
                    }
            ?>
                    <div class="col-12 col-md-6 col-xxl-4">
                        <div class="card border-0 shadow clickable topic-quiz-card" onclick="OpenQuiz('<?= $quizId ?>')">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-9">
                                        <h6 class="mb-1 fw-bold"><?= $selectedTopic['topicName'] ?></h6>
                                        <p class="mb-0 text-secondary">Attempt : <span class="badge bg-<?= $openStatusBadgeColor ?>"><?= $openStatus ?></span></p>
                                    </div>
                                    <div class="col-3">
                                        <div class="bg-warning p-3 text-dark rounded-2 text-center grade-quiz fw-bold">
                                            <?= $quizGrade['quizGrade']; ?>
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
</script>