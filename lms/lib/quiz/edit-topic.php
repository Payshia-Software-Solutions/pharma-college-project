<?php
require_once '../../include/configuration.php';
include '../../php_handler/function_handler.php';
include '../../php_handler/course_functions.php';
include './php_method/quiz_methods.php';

$userLevel = $_POST['UserLevel'];
$loggedUser = $_POST['LoggedUser'];
$courseCode = $_POST['defaultCourseCode']; // Course will be taken as Batch

$topicId = $_POST['topicId'];

$topicName = "";
if (isset(GetQuizTopics()[$topicId])) {
    $quizTopic = GetQuizTopics()[$topicId];

    $topicName = $quizTopic['topicName'];
}
?>

<div class="row">
    <div class="col-12 text-end">
        <button onclick="TopicContent('<?= $topicId ?>')" type="button" class="btn btn-light"><i class="fa-solid fa-arrow-left"></i> Back</button>
    </div>
    <div class="col-12 mt-2">
        <p class="fw-bold mb-1">Topic Name</p>
        <input class="form-control p-3" type="text" name="topicName" id="topicName" placeholder="Enter Topic Name" value="<?= $topicName ?>">
    </div>

    <div class="col-12 text-end mt-3">
        <button onclick="SaveTopic('<?= $topicId ?>')" type="button" class="btn btn-dark"><i class="fa-solid fa-floppy-disk"></i> Save Changes</button>
    </div>
</div>