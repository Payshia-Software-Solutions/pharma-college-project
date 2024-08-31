<?php
require_once '../../include/configuration.php';
include '../../php_handler/function_handler.php';
include '../../php_handler/course_functions.php';
include './php_method/quiz_methods.php';

$loggedUser = $_POST['LoggedUser'];
$userLevel = $_POST['UserLevel'];
$courseCode = $_POST['defaultCourseCode']; // Course will be taken as Batch

$quizId = $_POST['quizId'];
$questionId = $_POST['questionId'];

$questionDetails = GetQuestion($quizId, $questionId);
$getAllSubmissions =  GetAllAnswerSubmission($questionId, $loggedUser);

$correctSubmissionStatus =  CheckCorrectAnswerSubmission($questionId, $loggedUser);
$quizTimer = 60;
$gradePerCorrectAttempt = 10;
$gradePerInCorrectAttempt = 5;
$attemptPerQuestion = 1;
?>
<input type="hidden" id="progressValue" value="<?= $quizTimer ?>" step="5" min="0" max="100" placeholder="progress">

<div class="row mt-2  mb-5">
    <div class="col-12">
        <div class="card border-0 rounded-bottom-4 rounded-top-3" id="bubbleCard">
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <button onclick="goBack('<?= $quizId ?>') " type="button" class="btn btn-light back-button">
                            <i class="fa-solid fa-arrow-left-long"></i>
                        </button>
                    </div>

                    <div class="col-6">
                        <div class="profile-image profile-image-mini" style="background-image : url('./assets/images/user.png')"></div>
                    </div>

                </div>

            </div>
        </div>
        <div class="card quiz-card border-0">
            <div class="card-body">
                <div class="timer-content">
                    <div class="time-left" data-time="18">
                        <svg class="progress-ring" width="70" height="70">
                            <circle class="progress-ring__circle" stroke="#a42fc1" stroke-width="5" fill="transparent" r="30" cx="35" cy="35" />
                            <div class="time-text" id="time-text"><?= $quizTimer ?></div>
                        </svg>
                    </div>
                </div>
                <h4 class="mt-3 text-center"><?= $questionDetails['question_content'] ?></h4>
            </div>
        </div>

        <div class="answer-card-set mt-2 p-4 ">
            <div class="row g-2">
                <?php
                for ($i = 1; $i <= 4; $i++) {
                ?>
                    <div class="col-12">
                        <div class="answer-card border p-3 bg-white clickable">
                            <h6 for="answerId-<?= $i ?>" class="mb-0 fw-bold" style="margin-right: 5px;"><?= $questionDetails['answer_' . $i] ?></h6>
                            <input type="radio" id="answerId-<?= $i ?>" name="answerId" value="<?= $questionDetails['answer_' . $i] ?>">
                            <div class="custom-checkbox"></div>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <?php if ($userLevel == "Admin") {
                    ?>
                        <div class="bg-light rounded-4 p-3 shadow-sm mb-3">
                            <p class="text-secondary mb-2 border-bottom">Only Admin User can see this</p>
                            <h5 class="mb-2 card-title fw-bold">Correct Answer</h5>
                            <div class="alert alert-success fw-bold mb-0"><?= $questionDetails['correct_answer'] ?></div>
                        </div>
                    <?php
                    }

                    if (count($correctSubmissionStatus) == 0 && count($getAllSubmissions) < $attemptPerQuestion) {
                    ?>
                        <button onclick="ValidateAnswer('<?= $quizId ?>', '<?= $questionId ?>')" class="rounded-3  btn-lg btn btn-purple w-100">
                            <i class="fa-regular fa-floppy-disk"></i>
                            Validate Answer
                        </button>
                    <?php
                    } else {
                    ?>

                        <div class="bg-light rounded-4 p-3 shadow-sm">
                            <h5 class="mb-2 card-title fw-bold">Correct Answer</h5>
                            <div class="alert alert-success fw-bold mb-0"><?= $questionDetails['correct_answer'] ?></div>
                        </div>

                        <div class="bg-light rounded-4 p-3 shadow-sm mt-3">
                            <h5 class="mb-2 card-title">Your Answer Attempts</h5>
                            <div class="row g-2">
                                <?php
                                if (!empty($getAllSubmissions)) {
                                    foreach ($getAllSubmissions as $selectedAnswer) {
                                        $answerResult = $selectedAnswer['answer_status'];
                                        $openStatusBadgeColor = 'warning';
                                        if ($answerResult == "Correct") {
                                            $openStatusBadgeColor = 'success';
                                        }
                                ?>
                                        <div class="col-12">
                                            <div class="alert alert-<?= $openStatusBadgeColor ?> fw-bold mb-0">
                                                <h5 class="mb-0 fw-bold"><?= $selectedAnswer['selected_answer'] ?></h5>
                                                <span class="badge bg-<?= $openStatusBadgeColor ?>"><?= $answerResult ?></span>
                                            </div>
                                        </div>
                                <?php
                                    }
                                }
                                ?>

                            </div>
                        </div>
                    <?php
                    }
                    ?>

                </div>
            </div>
        </div>




    </div>
</div>

<script>
    var circle = document.querySelector('circle');
    var radius = circle.r.baseVal.value;
    var circumference = radius * 2 * Math.PI;

    circle.style.strokeDasharray = `${circumference} ${circumference}`;
    circle.style.strokeDashoffset = `${circumference}`;

    function setProgress(percent) {
        const offset = circumference - percent / 100 * circumference;
        circle.style.strokeDashoffset = offset;
    }
    // Assuming setProgress function updates the progress bar or performs some action to display the progress

    var totalTime = $('#progressValue').val(); // Total time for the countdown in seconds

    var timeLeft = totalTime;
    $('#time-text').html(timeLeft)
    setProgress(100);

    var countdownInterval = setInterval(() => {
        setProgress((timeLeft / totalTime) * 100); // Update the progress based on the remaining time
        timeLeft--;

        if (timeLeft < 0) {
            clearInterval(countdownInterval);
            // Timer has reached 0, perform any actions you need when the timer finishes

            goBack('<?= $quizId ?>')
        }
    }, 1000); // Interval set to 1000 milliseconds (1 second)

    function goBack(quizId) {
        clearInterval(countdownInterval);
        OpenQuiz(quizId)
    }
</script>

<!-- Script to add random bubbles -->
<script>
    var card = document.getElementById("bubbleCard");
    var positionPoints = [
        ['20%', '60%', '60px'],
        ['50%', '0%', '40px'],
        ['-10%', '30%', '70px'],
        ['25%', '30%', '30px'],
        ['70%', '50%', '20px'],
    ];

    for (let i = 0; i < positionPoints.length; i++) {
        xPos = positionPoints[i][0];
        yPos = positionPoints[i][1];
        widthVal = positionPoints[i][2];
        createBubble(card, xPos, yPos, widthVal);
    }
    var answerCards = document.querySelectorAll('.answer-card');

    // Add a click event listener to each '.answer-card' element
    answerCards.forEach(function(card) {
        card.addEventListener('click', function() {
            var radioInput = card.querySelector('input[type="radio"]');
            radioInput.checked = !radioInput.checked;
        });
    });
</script>