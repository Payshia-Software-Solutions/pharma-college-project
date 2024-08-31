<?php
require_once '../../include/configuration.php';
include '../../php_handler/function_handler.php';
include '../../php_handler/course_functions.php';
include '../../php_handler/win-pharma-functions.php';

$courseCode = $_POST['defaultCourseCode'];
$loggedUser = $_POST['LoggedUser'];
$courseInfo = GetCourseDetails($courseCode);
$courseContent = GetCourseContent($courseCode);
$videoCount = count($courseContent);


include '../common-components/greeting.php';
?>

<div id="index-content">
    <?php
    if ($courseCode != null) {
    ?>
        <div class="row">
            <div class="col-12">
                <div class="alert alert-warning border-2 shadow-sm" id="courseAlert">

                    Your Default course is <b><?= $courseCode ?> - <?= GetCourseDetails($courseCode)['course_name'] ?></b>
                    <div class="text-start">
                        <button onclick="SetDefaultCourse(1)" type="button" class="btn btn-dark btn-sm">
                            <i class="fa-brands fa-slack"></i> Change Default Course
                        </button>
                        <button class="btn btn-danger btn-sm" onclick="$('#courseAlert').hide(1000)">
                            <i class="fa-solid fa-xmark"></i> Close
                        </button>
                    </div>


                </div>
            </div>
        </div>
    <?php
    } else {
        exit;
    }
    ?>
    <div class="row my-2">
        <div class="col-12">
            <div class="card border-0"> <img class="rounded-4 mb-3" src="./lib/course/assets/images/banner.png" style="width: 100%;">
                <div class="text-center">
                    <h3 class="card-title mb-0"><?= $courseInfo['course_code']; ?> | <?= $courseInfo['course_name']; ?></h3>
                    <p class="text-success"><?= $videoCount ?> Videos</p>
                </div>
            </div>

        </div>
    </div>


    <div class="row g-3">
        <div class="col-12">
            <h4 class="section-topic">Topics</h4>
        </div>

        <?php
        if (!empty($courseContent)) {
            foreach ($courseContent as $selectedArray) {

                $formattedDate = date("j M Y", strtotime($selectedArray['created_at']));
                $timestamp = strtotime($selectedArray['created_at']);

        ?>
                <div class="col-12 col-md-4 mb-3 d-flex">
                    <div class="card other-card flex-fill" onclick="OpenCoursePlayer('<?= $courseCode ?>', '<?= $selectedArray['id'] ?>')">
                        <img src="./assets/images/video-placeholder.webp" class="w-100 rounded-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <h5 class="card-title mb-0"> <?= $selectedArray['title_name'] ?></h5>
                                    <p class="text-secondary my-0" style="font-size: 14px;"><?= $formattedDate ?> ● <?= timeAgo($timestamp) ?></span></p>
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