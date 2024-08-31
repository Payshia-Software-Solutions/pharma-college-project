<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../../include/configuration.php';
include '../../php_handler/function_handler.php';

// Include Classes
include_once './Classes/Database.php';
include_once './Classes/Assignments.php';

$config_file = '../../include/env.txt';
$database = new Database($config_file);
$db = $database->getConnection();

$userLevel = $_POST['UserLevel'];
$loggedUser = $_POST['LoggedUser'];
$courseCode = $_POST['CourseCode'];

$assignments = new Assignments($database);
$assignmentArray = $assignments->fetchAllByCourseCode($courseCode);
?>

<div class="row mt-2 mb-5">
    <div class="col-12 mt-3">
        <div class="card shadow mt-5 border-0">
            <div class="card-body">
                <div class="quiz-img-box sha">
                    <img src="./lib/assignments/assets/images/homework.gif" class="quiz-img shadow rounded-4">
                </div>
                <h1 class="card-title text-center mt-2 fw-bold bg-light p-3 rounded-5 mb-0">Assignments</h1>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <?php foreach ($assignmentArray as $assignment) :
        if ($assignment['active_status'] != 1) {
            continue;
        }
    ?>
        <div class="col-md-4">
            <div class="card border-0 shadow rounded-4 clickable" onclick="ViewAssignment('<?= $assignment['id'] ?>')">
                <div class="card-body">
                    <h3 class="mb-0"><?= $assignment['assignment_name'] ?></h3>
                    <p class="mb-0"><?= $assignment['course_code'] ?></p>
                </div>
            </div>
        </div>
    <?php endforeach ?>
</div>