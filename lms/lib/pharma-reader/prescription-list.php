<?php

require_once '../../include/configuration.php';
include '../../php_handler/function_handler.php';
include './php_methods/pharma-reader-methods.php';

$userLevel = $_POST['UserLevel'];
$LoggedUser = $_POST['LoggedUser'];
$CourseCode = $_POST['defaultCourseCode'];

$timeOfDay = getCurrentTimeOfDay();
$prescriptionDetailedList = GetPrescriptions();

$overallGrade = 10;
$CompleteRate = 5;

?>

<div class="row g-3">
    <div class="col-12">
        <h5 class="border-bottom mb-2 pb-1 fw-bold">Available Prescriptions</h5>
    </div>

    <div class="col-12 text-end">
        <button onclick="EditPrescription()" type="button" class="btn btn-dark">Add New Prescription</button>
    </div>

    <?php
    if (!empty($prescriptionDetailedList)) {
        foreach ($prescriptionDetailedList as $selectedArray) {
            $prescriptionId = $selectedArray['id'];
    ?>
            <div class="col-12 col-md-6 col-xxl-4">
                <div class="card border-0 shadow-sm clickable topic-quiz-card" onclick="EditPrescription('<?= $prescriptionId ?>')">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <h6 class="mb-1 fw-bold"><?= $selectedArray['pres_name'] ?></h6>
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