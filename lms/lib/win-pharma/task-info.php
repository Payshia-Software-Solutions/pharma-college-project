<?php
require_once '../../include/configuration.php';
include '../../php_handler/function_handler.php';
include '../../php_handler/course_functions.php';
include '../../php_handler/win-pharma-functions.php';

$UserLevel = $_POST["UserLevel"];
$LoggedUser = $_POST["LoggedUser"];
$TaskID = $_POST["TaskID"];
$LevelCode = $_POST["LevelCode"];
$DefaultCourse = $_POST["defaultCourseCode"];

$Submissions = GetWinpharmaSubmissions($link, $LoggedUser);
$commonReasons = GetCommonReasons($link);
$Tasks = GetTasks($link, $LevelCode);
// var_dump($Tasks);
$Task = $Tasks[$TaskID];
?>
<style>
    img {
        max-width: 100%;
        border-radius: 10px;
    }

    iframe {
        width: 100% !important;
        border-radius: 15px !important;
    }

    @media only screen and (max-width: 600px) {
        iframe {
            height: 30vh !important;
        }
    }

    .dropify-wrapper .dropify-message .file-icon p {
        font-size: 15px !important;
    }
</style>
<div class="row text-end mb-3">
    <div class="col-12">
        <button class="btn btn-sm rounded-2 btn-warning btn-icon-text" onclick="GetTaskInfo('<?php echo $TaskID; ?>', '<?php echo $LevelCode; ?>', '<?php echo $DefaultCourse; ?>');"><i class="ti-reload btn-icon-prepend"></i> Reload</button>
        <button class="btn btn-sm rounded-2 btn-success btn-icon-text" onclick="OpenIndex('<?php echo $DefaultCourse; ?>');"><i class="ti-home btn-icon-prepend"></i> Home </button>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <h2 class="card-title border-bottom pb-2 mb-3" style="font-weight: 600;">Winpharma : <?= $Task["resource_title"] ?></h2>
    </div>
    <div class="col-md-7">
        <div class="pb-3">
            <?= $Task["resource_data"] ?>
        </div>
    </div>

    <div class="col-md-5">
        <?php
        $Submissions = GetSubmitionResult($link, $LoggedUser, $TaskID);

        if (!empty($Submissions)) {
            if ($Submissions[0]["grade_status"] == "Try Again") {

                $SubmissionID = $Submissions[0]['submission_id'];
                if ($Submissions[0]["grade_status"] == "Try Again") {
                    $reasonString = $Submissions[0]["reason"];

                    // Convert to array and clean up the values
                    $reasonArray = array_map('trim', explode(',', $reasonString)); ?>
                    <div class="mb-3">
                        <h3>Your Attempt result</h3>

                        <button type="button" class="w-100 btn btn-warning p-3 rounded-3 fw-bold">Try Again</button>

                        <div class="alert alert-light my-2">
                            <span class="card-title mb-1 pb-0 fw-bolder text-danger">Reason(s)</span>
                            <?php foreach ($reasonArray as $reasonId): ?>
                                <div class="alert alert-warning"><?= $commonReasons[$reasonId]['reason'] ?></div>
                            <?php endforeach ?>
                        </div>

                        <p class="text-start text-muted mt-2 border-top pt-2">If you need to re-check your submission please press on re-correction button</p>

                        <div class="text-end">
                            <button onclick="ReCorrection ('<?= $SubmissionID  ?>', '<?= $LoggedUser ?>', '<?= $DefaultCourse ?>', '<?php echo $LevelCode; ?>', '<?php echo $TaskID; ?>')" type="button" id="re-correction" class="btn btn-warning btn-sm rounded-2">Re-Correction</button>
                        </div>
                    </div>

                <?php
                }
                ?>
                <hr>
                <form method="post" class="mt-3" id="submission-form">
                    <div class="row">
                        <div class="col-md-12">
                            <p class="">Or Again Submit your Submission</p>
                        </div>
                        <div class="col-md-12">
                            <input type="file" name="submission" class="form-control form-control-sm dropify" required>
                        </div>
                    </div>
                    <div class="text-center mt-3">
                        <button type="button" id="addSubmission" onclick="AddSubmission('<?php echo $LevelCode; ?>', '<?php echo $TaskID; ?>', '<?php echo $DefaultCourse; ?>')" class="btn btn-primary btn-sm rounded-2">Submit</button>
                        <div class="" id="SubmitionInfo"></div>
                    </div>
                </form>
            <?php
            } else if ($Submissions[0]["grade_status"] == "Re-Correction") {
            ?>
                <div class="badge bg-warning rounded-2 text-white mb-3">Re-Correction Pending</div>
            <?php } ?>
            <h5>Your Submission</h5>
            <p><a target="_blank" href="./uploads/tasks/submission/<?= $LoggedUser ?>/<?= $TaskID ?>/<?= $Submissions[0]["submission"] ?>" target="_blank"><?= $Submissions[0]["submission"] ?></a></p>
            <img src="./uploads/tasks/submission/<?= $LoggedUser ?>/<?= $TaskID ?>/<?= $Submissions[0]["submission"] ?>">
        <?php
        } else { ?>
            <form method="post" id="submission-form">
                <div class="row">
                    <div class="col-md-12">
                        <h5 class="card-title mb-2">Submission</h5>
                        <p class="text-secondary">Please Note: if your submission file size is large, your submission will take little time to uploading process. so we recommend you to upload low scale clear image.</p>
                    </div>
                    <div class="col-md-12">
                        <input type="file" style="font-size: 10px !important;" name="submission" class="form-control form-control-sm dropify" required>
                        <p>Max Size - 3MB</p>
                    </div>

                </div>
                <div class="text-center mt-3">
                    <button type="button" id="addSubmission" onclick="AddSubmission('<?php echo $LevelCode; ?>', '<?php echo $TaskID; ?>', '<?php echo $DefaultCourse; ?>')" class="btn btn-dark rounded-2 p-2 w-100"> <i class="fa-solid fa-floppy-disk"></i> Save Submission</button>
                    <div class="" id="SubmitionInfo"></div>
                </div>
            </form>
        <?php
        }
        ?>
    </div>
</div>




<script>
    $('.dropify').dropify();
</script>