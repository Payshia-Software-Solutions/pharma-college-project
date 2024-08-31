<?php
require_once '../../include/configuration.php';
include '../../php_handler/function_handler.php';
include '../../php_handler/course_functions.php';
include './php_method/quiz_methods.php';

$userLevel = $_POST['UserLevel'];
$loggedUser = $_POST['LoggedUser'];
$courseCode = $_POST['defaultCourseCode']; // Course will be taken as Batch

$topicId = $_POST['topicId'];
$questionId = $_POST['questionId'];

$answer_1 = $answer_2 = $answer_3 = $answer_4 = $questionContent = "";

$quizTopic = GetQuizTopics()[$topicId];
$topicName = $quizTopic['topicName'];

if ($questionId != '0') {
    $questionArray = GetQuiz($topicId)[$questionId];

    $answer_1 = $questionArray['answer_1'];
    $answer_2 = $questionArray['answer_2'];
    $answer_3 = $questionArray['answer_3'];
    $answer_4 = $questionArray['answer_4'];
    $correct_answer = $questionArray['correct_answer'];
    $questionContent = $questionArray['question_content'];
}

?>

<div class="row">
    <div class="col-md-12">

        <div class="row g-2">
            <div class="col-9 col-xl-10">
                <h4 class="mb-2 card-title fw-bold question-name"><?= ($questionContent != '') ? $questionContent : "New Question" ?></h4>
            </div>
            <div class="col-3 col-xl-2 text-end">
                <button onclick="TopicContent('<?= $topicId ?>')" type="button" class="btn btn-light"><i class="fa-solid fa-arrow-left"></i> Back</button>
            </div>
            <form method="post" id="submit-form">
                <div class="row  g-2">

                    <div class="col-12 mb-2">
                        <textarea class="form-control" rows="4" name="question" id="question"><?= $questionContent; ?></textarea>
                    </div>

                    <?php
                    $answerLabels = array("Answer 1", "Answer 2", "Answer 3", "Answer 4");
                    $answerKeys = array("answer_1", "answer_2", "answer_3", "answer_4");
                    $answers = array($answer_1, $answer_2, $answer_3, $answer_4);

                    for ($i = 0; $i < 4; $i++) {
                        $label = $answerLabels[$i];
                        $key = $answerKeys[$i];

                        $answer = ($questionId != '0') ? $questionArray[$key] : '';
                    ?>
                        <div class="col-12 col-md-6">
                            <p class="mb-0"><?= $label ?></p>
                            <input class="form-control p-3" type="text" name="answer<?= $i + 1 ?>" id="answer<?= $i + 1 ?>" placeholder="Enter <?= $label ?>" onblur="AddOption();" value="<?= $answer; ?>">
                        </div>
                    <?php
                    }
                    ?>

                    <div class="col-12">
                        <p class="mb-0 ">Correct Answer</p>
                        <select class="form-control p-3" name="correct_answer" id="correct_answer">
                            <option value="">Select Answer</option>
                            <?php
                            foreach ($answers as $answer) {
                                if ($answer == "") {
                                    continue;
                                }
                            ?>
                                <option <?= ($answer == $correct_answer) ? "selected" : "" ?> value="<?= $answer ?>"><?= $answer ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>

                    <div class="col-12 text-end mt-3">
                        <?php
                        if ($questionId != '0' && $questionArray['question_status'] == "Active") {
                        ?>
                            <button onclick="UpdateQuestionStatus('<?= $topicId ?>', '<?= $questionId ?>', 'Deleted')" class="btn btn-danger" type="button"><i class="fa-solid fa-trash"></i> Disable</button>
                        <?php
                        } else if ($questionId != '0' && $questionArray['question_status'] == "Deleted") {
                        ?>
                            <button onclick="UpdateQuestionStatus('<?= $topicId ?>', '<?= $questionId ?>', 'Active')" class="btn btn-primary" type="button"><i class="fa-solid fa-pencil"></i> Active</button>
                        <?php } ?>

                        <button onclick="SaveQuestion('<?= $topicId ?>', '<?= $questionId ?>')" class="btn btn-dark" type="button"><i class="fa-solid fa-floppy-disk"></i> Save Changes</button>
                    </div>

                </div>
            </form>
        </div>

    </div>
</div>


<script>
    tinymce.remove()
    tinymce.init({
        selector: 'textarea',
        height: 250,
        plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
    });
</script>