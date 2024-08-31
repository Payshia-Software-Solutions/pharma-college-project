<?php
require_once '../../include/configuration.php';
include '../../php_handler/function_handler.php';
include './methods/functions.php';


$diedCount = 0;
$patientCount = 0;
$loopCount = 0; // Initialize the loop count.

$loggedUser = $_POST['LoggedUser'];
$UserLevel = $_POST['UserLevel'];
$courseCode = $_POST['courseCode'];
$patients =  GetPatients($link);

$patientRecoveries = GetPatientsRecoveriesByUser($loggedUser);
$recoveryCount = count($patientRecoveries);


foreach ($patients as $selectedArray) {
    // Reset the loop count to 0 after every 10 iterations.
    if ($loopCount == 10) {
        $loopCount = 0;
    }

    $loopCount++; // Increment the loop count.
    $timer = GetTimer($link, $loggedUser, $selectedArray['prescription_id']);


    if ($UserLevel == "Student" && CheckCoursePatientAvailability($link, $courseCode, $selectedArray['prescription_id']) == false) {
        continue;
    }
    $bgColor = "primary";
    if ($timer['patient_status'] == "Died") {
        $bgColor = "danger";
        $diedCount++;
    }
    $patientCount++;
}

$lifeLinesCount = floor($patientCount * (50 / 100));



$availableCount = $lifeLinesCount - $recoveryCount;
?>
<div class="row">
    <div class="col-12 text-end mt-3">
        <button class="btn btn-warning btn-sm rounded-3" onclick="RecoverPatients('<?= $courseCode ?>')"><i class="fa-solid fa-rotate-left player-icon"></i> Reload</button>
        <button class="btn btn-success btn-sm rounded-3" onclick="OpenIndex()"><i class="fa-solid fa-home player-icon"></i> Home</button>
    </div>

</div>

<div class="row my-3 order-1">
    <div class="col-12">
        <div class="card border-0  shadow-sm bg-light">
            <div class="card-body">
                <h3 class="mb-3 border-bottom pb-2 fw-bold">Patient Recovery Center</h3>

                <div class="row g-2">

                    <div class="col-6 col-md-3">
                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-body">
                                <p class="mb-0">Lifelines</p>
                                <h4 class="mb-0"><?= $lifeLinesCount ?></h4>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 col-md-3">
                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-body">
                                <p class="mb-0">Usage</p>
                                <h4 class="mb-0"><?= $recoveryCount ?></h4>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 col-md-3">
                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-body">
                                <p class="mb-0">Available</p>
                                <h4 class="mb-0"><?= $availableCount ?></h4>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 col-md-3">
                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-body">
                                <p class="mb-0">Died</p>
                                <h4 class="mb-0"><?= $diedCount ?></h4>
                            </div>
                        </div>
                    </div>
                </div>

                <?php if ($availableCount <= 0) : ?>
                    <div class="alert alert-warning mt-3 mb-0">You cannot recover Patients. your lifelines are over.</div>
                <?php endif ?>

            </div>
        </div>
    </div>
</div>

<div class="row order-2">
    <?php
    if (!empty($patients)) {
        $loopCount = 0; // Initialize the loop count.

        foreach ($patients as $selectedArray) {
            // Reset the loop count to 0 after every 10 iterations.
            if ($loopCount == 10) {
                $loopCount = 0;
            }

            $loopCount++; // Increment the loop count.

            $timer = GetTimer($link, $loggedUser, $selectedArray['prescription_id']);
            $bgColor = "primary";


            if ($UserLevel == "Student" && CheckCoursePatientAvailability($link, $courseCode, $selectedArray['prescription_id']) == false) {
                continue;
            }

            if ($timer['patient_status'] == "Died") {
                $bgColor = "danger";
            } else {
                continue;
            }
    ?>
            <div class="col-6 col-md-4 mb-2 d-flex">
                <div class="card game-card shadow-sm flex-fill text-center" <?php if ($availableCount >= 1) : ?> onclick="DeletePatientEntry('<?= $selectedArray['prescription_id'] ?>')" <?php endif; ?>>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <img src="./lib/ceylon-pharmacy/assets/images/patient-<?= $loopCount ?>.png" class="game-icon">
                                <h4 class="card-title"><?= $selectedArray['prescription_name'] ?></h4>
                                <div class="badge badge-primary bg-<?= $bgColor ?>"><?= $timer['patient_status'] ?></div>

                                <?php if ($availableCount >= 1) :
                                    $bgColor = 'primary'; ?>
                                    <div class="badge badge-primary bg-<?= $bgColor ?>">Recoverable</div>
                                <?php else : $bgColor = 'danger'; ?>
                                    <div class="badge badge-primary bg-<?= $bgColor ?>">Not Recoverable</div>
                                <?php endif ?>
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