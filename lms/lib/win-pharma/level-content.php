<?php
require_once '../../include/configuration.php';
include '../../php_handler/function_handler.php';
include '../../php_handler/win-pharma-functions.php';

$UserLevel = $_POST["UserLevel"];
$LoggedUser = $_POST["LoggedUser"];
$CourseCode = $_POST["defaultCourseCode"];
$CurrentTopLevel = $_POST["CurrentTopLevel"];
$Count = $_POST["Count"];

$Levels = GetLevels($link, $CourseCode);
if (count($Levels) == 0) {
    echo "No Levels";
    exit;
}
$RootLevel = reset($Levels)["level_id"];

if (!empty($Levels)) {
    $Level = $Levels[$CurrentTopLevel];

    $Tasks = GetTasks($link, $Level['level_id']);

    $Submissions = GetWinpharmaSubmissions($link, $LoggedUser);
    if (!empty($Submissions)) {
        $LastLevel = $Submissions[0]['level_id'];
    }

    if (count($Levels) > 1) {
        $indexedLevels = array_values($Levels);
    }

?>

    <style>
        .admin-card:hover {
            background-color: #000;
            color: #fff !important;
        }

        .admin-card:hover h4 {
            color: #fff !important;
        }

        .game-card:hover {
            background-color: #000;
            color: #fff !important;
        }

        .game-card:hover h4 {
            color: #fff !important;
        }
    </style>
    <div class="col-12 mt-2">
        <h4 class="card-title text-secondary pb-0 mb-0">Your are now at</h4>
        <h3 style="font-weight: 600;" class="card-title"><?= $Level['level_name'] ?></h3>
        <p class="card-title pt-0 text-secondary">You have to complete following tasks. Select one task then follow the instructions given</p>

        <div class="row mt-4">
            <?php
            if (!empty($Tasks)) {
                $actions = "active";
                $next_level = 1;
                foreach ($Tasks as $Task) {
                    $current_status = "Not Completed";
                    $bg_color = "info";
                    $TaskStatus = GetSubmitionResult($link, $LoggedUser, $Task['resource_id']);

                    if (!empty($TaskStatus)) {
                        $current_status = $TaskStatus[0]['grade_status'];
                    }

                    if ($current_status == "Pending") {
                        $bg_color = "danger";
                    }

                    if ($Task['is_active'] != 1) {
                        continue;
                    }
            ?>
                    <div class="col-6 col-md-4 col-lg-3 mb-2">
                        <div class="card admin-card border-0 rounded-4 shadow-sm <?= ($actions == "active") ? "focus-card clickable" : "" ?>" <?php if ($actions == "active") { ?>onclick="GetTaskInfo ('<?= $Task['resource_id'] ?>', '<?= $Level['level_id'] ?>', '<?= $CourseCode ?>')" <?php } ?>>
                            <img class="rounded-4 course-img" src="./uploads/tasks/<?= ($Task['task_cover'] == "") ? "No-Image.jpg" : $Task['task_cover'] ?>" alt="Cover Image">
                            <div class="card-body text-center">
                                <h3 class="card-title "><?= $Task['resource_title'] ?></h3>
                                <div class="text-center">
                                    <div class="badge bg-<?= $bg_color ?> rounded-2 text-white"><?= $current_status ?></div>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php

                    if ($current_status == "Not Completed") {
                        // $actions = "inactive";
                    }

                    if ($current_status == "Not Completed" || $current_status == "Re-Correction"  || $current_status == "Pending" || $current_status == "Sp-Pending" || $current_status == "Try Again") {
                        // $actions = "inactive";
                        $next_level += 1;
                    }
                }
            } else { ?>
                <div class="col-12">
                    <div class="alert alert-warning" role="alert">Not Tasks</div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
    <?php

    if (!empty($Tasks)) {
    ?>
        <div class="text-center mt-4">
            <?php
            if ($Count > 1) {
            ?>
                <button class="rounded-2 btn-sm btn btn-secondary" onclick="GetLevelContent('<?= $CourseCode; ?>', '<?= $indexedLevels[$Count - 2]['level_id']; ?>', '<?= $Count - 2 ?>')"><i class="ti-angle-left btn-icon-prepend"></i> Previous</button>
            <?php
            }
            ?>
            <button class="rounded-2 btn-sm btn btn-secondary" onclick="GetLevelContent('<?= $CourseCode; ?>', '<?= $RootLevel; ?>', '<?= 1 ?>')"><i class="ti-home  btn-icon-prepend"></i></button>

            <?php
            if ($Count < count($indexedLevels)) {
                $HelpHTML = "Please Complete all tasks first!";
            ?>
                <button class="rounded-2 btn-sm btn btn-secondary" <?php if ($next_level == 1) { ?> onclick="GetLevelContent('<?= $CourseCode; ?>', '<?= $indexedLevels[$Count]['level_id']; ?>', '<?= $Count + 1 ?>')" <?php } else { ?> onclick="showNotification('<?= $HelpHTML ?>', 'error', 'Oops!');" <?php } ?>>Next <i class="ti-angle-right btn-icon-prepend"></i></button>
            <?php
            }
            ?>
        </div>
    <?php

    }
} else {
    ?>
    <h4 class="card-title text-center">No Levels. Try again Later</h4>
<?php
}
?>