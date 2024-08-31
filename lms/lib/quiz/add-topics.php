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
$quizTopics = GetQuizTopics();
?>

<div class="row">
    <div class="col-md-12">
        <h3 class="mb-2 pb-2 border-bottom card-title fw-bold">Topics</h3>

        <div class="row">
            <div class="col-12 text-end">
                <button onclick="CreateTopics()" type="type" class="btn btn-dark"><i class="fa-solid fa-plus"></i> Add New</button>
            </div>
        </div>

        <div class="row g-3 mt-1">
            <?php
            if (!empty($quizTopics)) {
                foreach ($quizTopics as $selectedArray) {

                    $topicId = $selectedArray['quiz_topicID'];
            ?>
                    <div class="col-12 col-md-6 col-xxl-4">
                        <div class="card border-0 shadow-sm clickable topic-quiz-card" onclick="TopicContent('<?= $topicId ?>')">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <h6 class="mb-0 fw-bold"><?= $selectedArray['topicName'] ?></h6>
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