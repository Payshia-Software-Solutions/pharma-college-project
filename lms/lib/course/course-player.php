<?php
require_once '../../include/configuration.php';
include '../../php_handler/function_handler.php';
include '../../php_handler/course_functions.php';
include '../../php_handler/win-pharma-functions.php';

$courseCode = $_POST['defaultCourseCode'];
$topicId = $_POST['TopicID'];

$courseInfo = GetCourseDetails($courseCode);
$titleInfo = GetCourseContent($courseCode)[$topicId];
$titleContent = GetContentTitle($topicId)[0];
$courseContent = GetCourseContent($courseCode);

$formattedDate = date("j M Y", strtotime($titleInfo['created_at']));
$timestamp = strtotime($titleInfo['created_at']);


?>
<style>
    .content-player p {
        margin-bottom: 0px !important;
    }
</style>
<div class="row">
    <div class="col-12 text-end mt-3">
        <button class="btn btn-dark btn-sm rounded-3" onclick="OpenCoursePlayer('<?= $courseCode ?>', '<?= $topicId ?>')"><i class="fa-solid fa-rotate-right player-icon"></i> Reload</button>
        <button class="btn btn-dark btn-sm rounded-3" onclick="OpenIndex()"><i class="fa-solid fa-clone player-icon"></i> Home </button>
    </div>
</div>

<div class="video-player mt-3">
    <div class="row">
        <div class="col-lg-9">

            <div class="content-player mb-0">
                <?= $titleContent['description'] ?>
            </div>
            <h4 class="card-title my-0"><?= $titleInfo['title_name'] ?></h4>

            <div class="row">
                <div class="col-12">
                    <div class="card border-0 bg-light rounded-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="text-secondary mb-0"><?= $formattedDate ?></div>
                                </div>
                                <div class="col-6 text-end">
                                    <p class="text-secondary mb-0">Admin</p>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>

            <div class="row my-3">
                <div class="col-3 col-md-2 col-lg-1">
                    <div class="profile-image" style="background-image : url('./assets/images/user.png')"></div>
                </div>
                <div class="col-9 col-md-10 col-lg-11">
                    <input class="form-control border-0 border-bottom rounded-0 bg-light" type="text" name="comment_text" id="comment_text" placeholder="What do you Think?">
                    <div class="text-end mt-2">
                        <button type="button" class="btn btn-dark btn-sm rounded-5">Comment</button>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-lg-3">
            <div class="row g-3">
                <?php
                if (!empty($courseContent)) {
                    foreach ($courseContent as $selectedArray) {

                        $formattedDate = date("j M Y", strtotime($selectedArray['created_at']));
                        $timestamp = strtotime($selectedArray['created_at']);
                ?>
                        <div class="col-12 d-flex">
                            <div class="card clickable border-0 flex-fill" onclick="OpenCoursePlayer('<?= $courseCode ?>', '<?= $selectedArray['id'] ?>')">

                                <div class="row g-2">
                                    <div class="col-5">
                                        <img src="./assets/images/video-placeholder.webp" class="w-100 rounded-3">
                                    </div>
                                    <div class="col-7">
                                        <div class="row">
                                            <div class="col-12">
                                                <h6 class="card-title mt-2 mb-0"><?= $selectedArray['title_name'] ?></h6>
                                                <p class="text-secondary my-0" style="font-size: 10px;"><?= $formattedDate ?> ● <?= timeAgo($timestamp) ?></span></p>
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


</div>

</div>