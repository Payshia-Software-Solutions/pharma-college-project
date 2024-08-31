<?php
require_once '../../include/configuration.php';
include '../../php_handler/function_handler.php';
include '../../php_handler/course_functions.php';

$loggedUser = $_POST['LoggedUser'];
$defaultCourseCode = $_POST['defaultCourseCode'];
$enrollmentList =  getUserEnrollments($loggedUser);
$batchList =  GetCourses($link);
?>

<div class="row g-2">
    <?php
    if (!empty($enrollmentList)) {
        foreach ($enrollmentList as $selectedArray) {

    ?>
            <div class="col-12 col-md-4 d-flex">
                <div onclick="SaveDefaultCourse('<?= $selectedArray['course_code'] ?>')" class="card <?= ($defaultCourseCode == $selectedArray['course_code']) ? 'active-table-card' : '' ?> table-card border-0 shadow-sm mb-2 flex-fill clickable">
                    <div class="card-body">
                        <!-- <div class="text-center">
                            <img class="rounded-4" src="./assets/images/certificate-course-image.jpg" style="width: 100px;">
                        </div> -->
                        <span class="badge text-light mb-2 bg-primary"><?= $selectedArray['course_code'] ?></span>
                        <h6 class="mb-0"><?= $batchList[$selectedArray['course_code']]['course_name'] ?></h6>
                    </div>
                </div>
            </div>
    <?php
        }
    }
    ?>
</div>