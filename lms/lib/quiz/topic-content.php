<?php
require_once '../../include/configuration.php';
include '../../php_handler/function_handler.php';
include '../../php_handler/course_functions.php';
include './php_method/quiz_methods.php';

$userLevel = $_POST['UserLevel'];
$loggedUser = $_POST['LoggedUser'];
$courseCode = $_POST['defaultCourseCode']; // Course will be taken as Batch

$topicId = $_POST['topicId'];

$quizTopic = GetQuizTopics()[$topicId];
$topicName = $quizTopic['topicName'];

$questionList = GetQuiz($topicId);
?>

<div class="row">
    <div class="col-md-12">
        <h3 class="mb-2 pb-2 border-bottom card-title fw-bold"><?= $topicName ?></h3>

        <div class="row">
            <div class="col-12 text-end">
                <button onclick="QuestionContent('<?= $topicId ?>')" type="type" class="btn btn-dark"><i class="fa-solid fa-plus"></i> New Question</button>
                <button onclick="CreateTopics('<?= $topicId ?>')" type="type" class="btn btn-secondary"><i class="fa-solid fa-pencil"></i> Edit Name</button>
                <button onclick="AddTopics()" type="button" class="btn btn-light"><i class="fa-solid fa-arrow-left"></i> Back</button>
            </div>
        </div>

        <div class="row g-3 mt-2">
            <?php if (!empty($questionList)) {
                $questionCount = 1;
                foreach ($questionList as $selectedArray) {
                    $questionId = $selectedArray['question_id'];

                    $questionStatus = $selectedArray['question_status'];
                    if ($questionStatus == "Active") {
                        $badgeColor = "primary";
                    } else {
                        $badgeColor = "danger";
                    }
            ?>
                    <div class="col-12 col-md-6 d-flex">
                        <div onclick="QuestionContent('<?= $topicId ?>', '<?= $questionId ?>')" class="card border-0 shadow-sm rounded-3 clickable topic-quiz-card flex-fill">
                            <div class="card-body">
                                <h6 class="mb-0 fw-bold question-name"><?= $selectedArray['question'] ?></h6>
                                <span class="badge bg-<?= $badgeColor ?>"><?= $questionStatus ?></span>
                                <span class="badge bg-secondary">Question <?= $questionCount++ ?></span>
                            </div>
                        </div>
                    </div>
                <?php
                }
            } else {
                ?>
                <div class="alert alert-warning mb-0">No Questions!</div>
            <?php
            }
            ?>
        </div>

    </div>
</div>