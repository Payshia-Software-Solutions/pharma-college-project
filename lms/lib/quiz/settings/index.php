<?php
require_once '../../../include/configuration.php';
include '../../../php_handler/function_handler.php';
include '../../../php_handler/course_functions.php';
include '../php_method/quiz_methods.php';

$userLevel = $_POST['UserLevel'];
$loggedUser = $_POST['LoggedUser'];
$courseCode = $_POST['defaultCourseCode']; // Course will be taken as Batch

$timesPerQuestion = $correctAttemptMark = $incorrectAttemptMark = 0;

$timesPerQuestion = 60;
$correctAttemptMark = 10;
$incorrectAttemptMark = -5;
?>

<div class="row g-2 mt-4">
    <div class="col-12">
        <h5 class="border-bottom mb-2 pb-1 fw-bold">Setting</h5>
    </div>

    <div class="col-6">
        <p class="mb-0 text-secondary">Seconds per Question</p>
        <input type="number" readonly class="form-control p-3" name="secondsPerQuestion" id="secondsPerQuestion" placeholder="Seconds Per Question" value="<?= $timesPerQuestion ?>">
    </div>

    <div class="col-6">
        <p class="mb-0 text-secondary">Grade per Correct Attempt</p>
        <input type="number" readonly class="form-control p-3" name="correctAttemptMark" id="correctAttemptMark" placeholder="Enter Value" value="<?= $correctAttemptMark ?>">
    </div>

    <div class="col-6">
        <p class="mb-0 text-secondary">Grade per In-Correct Attempt</p>
        <input type="number" readonly class="form-control p-3" name="incorrectAttemptMark" id="incorrectAttemptMark" placeholder="Enter Value" value="<?= $incorrectAttemptMark ?>">
    </div>

    <div class="col-12 text-end">
        <button type="button" class="btn btn-dark"><i class="fa-solid fa-floppy-disk"></i> Save Changes</button>
    </div>
</div>