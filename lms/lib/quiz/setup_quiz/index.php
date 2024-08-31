<?php
require_once '../../../include/configuration.php';
include '../../../php_handler/function_handler.php';
include '../../../php_handler/course_functions.php';
include '../php_method/quiz_methods.php';

$userLevel = $_POST['UserLevel'];
$loggedUser = $_POST['LoggedUser'];
$courseCode = $_POST['defaultCourseCode']; // Course will be taken as Batch

$quizTopicsByCourse = GetQuizTopicsByCourse($courseCode);
$topicList = GetQuizTopics();
?>

<div class="row g-2 mt-4">
    <div class="col-6">

        <h5 class="border-bottom mb-2 pb-1 fw-bold">Available Quizzes</h5>
        <div class="row g-2">

            <?php
            if (!empty($topicList)) {
                foreach ($topicList as $selectedTopic) {
                    $quizId = $selectedTopic['quiz_topicID'];

                    if (isset($quizTopicsByCourse[$quizId])) {
                        if ($quizTopicsByCourse[$quizId]['topicID'] == $quizId && $quizTopicsByCourse[$quizId]['active_status'] == 'Active') {
                            continue;
                        }
                    }
            ?>
                    <div class="col-12">
                        <div class="card border-0 shadow-sm clickable topic-quiz-card" onclick=" SaveOrRemoveTopicByCourse('<?= $quizId ?>', '<?= $courseCode ?>')">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-9">
                                        <h6 class="mb-1 fw-bold"><?= $selectedTopic['topicName'] ?></h6>
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
    <div class="col-6">

        <h5 class="border-bottom mb-2 pb-1 fw-bold">Selected Quizzes</h5>
        <div class="row g-2">
            <?php
            if (!empty($quizTopicsByCourse)) {
                foreach ($quizTopicsByCourse as $selectedArray) {
                    $quizId = $selectedArray['topicID'];
                    $selectedTopic = $topicList[$quizId];

                    if ($selectedArray['active_status'] == 'Deleted') {
                        continue;
                    }
            ?>
                    <div class="col-12">
                        <div class="card border-0 shadow-sm clickable topic-quiz-card" onclick=" SaveOrRemoveTopicByCourse('<?= $quizId ?>', '<?= $courseCode ?>')">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-9">
                                        <h6 class="mb-1 fw-bold"><?= $selectedTopic['topicName'] ?></h6>
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