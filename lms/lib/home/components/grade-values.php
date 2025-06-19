<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once '../../../include/configuration.php';

// Include Classes
include_once '../classes/Database.php';
include_once '../classes/Assignments.php';
include_once '../classes/AssignmentSubmissions.php';

// Create a new Database object with the path to the configuration file
$config_file = '../../../include/env.txt';
$database = new Database($config_file);
$db = $database->getConnection();

$Assignments = new Assignments($database);
$AssignmentSubmissions = new AssignmentSubmissions($database);

$loggedUser = $_POST['LoggedUser'];
$batchCode = $_POST['defaultCourseCode'];


$assignmentsList = $Assignments->fetchByCourseId($batchCode);
$userSubmissions = $AssignmentSubmissions->fetchByStudentId($loggedUser);

$totalGrade = 0;
?>

<div class="border-bottom my-3"></div>
<h4 class="fw-bold">My Grading</h4>

<div class="row g-2">
    <?php foreach ($assignmentsList as $assignment) :
        $submissionInfo = [];
        if (isset($userSubmissions[$assignment['assignment_id']])) {
            $submissionInfo = $userSubmissions[$assignment['assignment_id']];
        }

        $gradeValue = 0;
        if (!empty($submissionInfo)) {
            $gradeValue = $submissionInfo['grade'];
        }

        $totalGrade += $gradeValue;
    ?>
        <div class="col-6 col-md-4 col-lg-3 col-xl-3 d-flex">
            <div class="card bg-white rounded-4 shadow border-0 flex-fill">
                <div class="card-body">
                    <h4 class="text-muted fw-light border-bottom pb-1 text-center"><?= $assignment['assignment_name'] ?></h4>
                    <h1 class="fw-bold text-center"><?= $gradeValue ?> %</h1>
                    <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="<?= $gradeValue ?>" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar bg-success" style="width:<?= $gradeValue ?>%"><?= $gradeValue ?> %</div>
                    </div>
                </div>
            </div>
        </div>
    <?php
    endforeach;
    $assignmentCount = (count($assignmentsList) == 0) ? 1 : count($assignmentsList);
    $totalGrade = number_format($totalGrade / $assignmentCount, 2) ?>
    <div class="col-6 col-md-4 col-lg-3 col-xl-3 d-flex">
        <div class="card bg-white rounded-4 shadow border-0 flex-fill">
            <div class="card-body">
                <h4 class="fw-bold border-bottom pb-1 text-center">Average</h4>
                <h1 class="fw-bold text-primary text-center"><?= $totalGrade ?> %</h1>
                <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="<?= $totalGrade ?>" aria-valuemin="0" aria-valuemax="100">
                    <div class="progress-bar bg-primary" style="width:<?= $totalGrade ?>%"><?= $totalGrade ?> %</div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="border-bottom my-3"></div>