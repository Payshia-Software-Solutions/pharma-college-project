<?php
require_once '../../include/configuration.php';
include '../../php_handler/function_handler.php';
include '../../php_handler/course_functions.php';
include '../../php_handler/win-pharma-functions.php';

$UserLevel = $_POST["UserLevel"];
$LoggedUser = $_POST["LoggedUser"];
$DefaultCourse = $_POST["defaultCourseCode"];


?>
<div class="site-title">
    <?php $UserDetails =  GetUserDetails($link, $LoggedUser); ?>
    <div class="row">
        <div class="col-8">
            <h2 class="greet-text">Hi <?= $UserDetails['first_name'] ?> <?= $UserDetails['last_name'] ?></h2>
            <p class="text-secondary">Let's Make this day Productive</p>
        </div>
        <div class="col-4 text-center">
            <div class="profile-image" style="background-image : url('./assets/images/user.png')"></div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="alert alert-warning border-2 shadow-sm" id="courseAlert">
            Your Default course is <b><?= $DefaultCourse ?> - <?= GetCourseDetails($DefaultCourse)['course_name'] ?></b>
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
$Submissions = GetWinpharmaSubmissions($link, $LoggedUser);
if (!empty($Submissions)) {
    $LastLevel = $Submissions[0]['level_id'];
}

$Levels = GetLevels($link, $DefaultCourse);
if (count($Levels) > 1) {
    $indexedLevels = array_values($Levels);
}

$LevelCount = GetLevelCount($link, $LoggedUser, $DefaultCourse);
if ($LevelCount == 0) {
    // echo "No Levels";
    // exit;
}
// $CurrentTopLevel = reset($Levels)["level_id"];

$CurrentTopLevel = GetTopLevel($link, $LoggedUser, $DefaultCourse);

if ($CurrentTopLevel == -1) {
    $CurrentTopLevel = GetCourseTopLevel($link, $DefaultCourse);
}
$Tasks = GetTasks($link, $CurrentTopLevel);

?>
<style>
    .level-title {
        font-size: 2.5rem !important;
    }
</style>


<div id="level-content"></div>
<script>
    GetLevelContent('<?= $DefaultCourse; ?>', '<?= $CurrentTopLevel; ?>', '<?= $LevelCount ?>');
</script>