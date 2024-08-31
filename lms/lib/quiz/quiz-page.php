<?php
require_once '../../include/configuration.php';
include '../../php_handler/function_handler.php';
include '../../php_handler/course_functions.php';
include './php_method/quiz_methods.php';

$loggedUser = $_POST['LoggedUser'];
$courseCode = $_POST['defaultCourseCode']; // Course will be taken as Batch
$quizId = $_POST['quizId'];

$selectedTopic = GetQuizTopics()[$quizId];
$quizNavigation = GetQuiz($quizId);
$quizGrade =  GetGradeByQuiz($quizId, $loggedUser);
?>
<input type="hidden" id="progressValue" value="60" step="5" min="0" max="100" placeholder="progress">

<div class="row mt-2  mb-5">
    <div class="col-12">

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
                                    <div class="grade-value"><?= $quizGrade['quizGrade'] ?></div>
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
                <h2 class="card-title text-center mt-2 fw-bold bg-light p-3 rounded-4 mb-0"><?= $selectedTopic['topicName'] ?></h2>
            </div>
        </div>

        <div class="row g-2 mt-4">
            <?php
            $quizSubmissions = GetQuizSubmissionByUser($loggedUser);

            $gradePerCorrectAttempt = 10;
            $gradePerInCorrectAttempt = 5;

            if (!empty($quizNavigation)) {
                $questionNumber = 0;
                foreach ($quizNavigation as $selectedArray) {
                    if ($selectedArray['question_status'] == "Deleted") {
                        continue;
                    }

                    $questionGrade = $correctScore = $inCorrectScore = $correctAttemptCount = $inCorrectAttemptCount = $totalAttempts = 0;
                    $answerResult = "Not Open";
                    $openStatusBadgeColor = "info";

                    $questionId = $selectedArray['question_id'];

                    if (!empty($quizSubmissions)) {
                        foreach ($quizSubmissions as $selectedAnswer) {
                            $answerQuestionId = $selectedAnswer['question_id'];

                            if ($questionId == $answerQuestionId) {
                                $answerResult = $selectedAnswer['answer_status'];
                                if ($answerResult == "Correct") {
                                    $openStatusBadgeColor = 'success';
                                    $correctScore += $gradePerCorrectAttempt;
                                    $correctAttemptCount += 1;
                                } else {
                                    $openStatusBadgeColor = 'warning';
                                    $inCorrectScore += $gradePerInCorrectAttempt;
                                    $inCorrectAttemptCount += 1;
                                }
                            }
                        }
                    }
                    $questionGrade = number_format($correctScore - $inCorrectScore, 2);
            ?>
                    <div class="col-6 col-md-3 col-xl-2 d-flex">
                        <div class="card border-0 flex-fill shadow clickable topic-quiz-card" onclick="OpenQuestion('<?= $quizId ?>', '<?= $questionId ?>')">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <h6 class="mb-1 fw-bold">Q<?= ++$questionNumber ?></h6>
                                        <p class="mb-0 text-secondary">
                                            <span class="badge bg-<?= $openStatusBadgeColor ?>"><?= $answerResult ?></span>
                                            <span class="badge bg-primary"><?= number_format($questionGrade, 2) ?></span>
                                        </p>
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