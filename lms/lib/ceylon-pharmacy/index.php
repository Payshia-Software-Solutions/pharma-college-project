<?php
require_once '../../include/configuration.php';
include '../../php_handler/function_handler.php';
$UserLevel = $_POST['UserLevel'];
$loggedUser = $_POST['LoggedUser'];
$CourseCode = $_POST['CourseCode'];
$patients =  GetPatients($link);
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

<div class="site-title">
    <?php $UserDetails =  GetUserDetails($link, $loggedUser); ?>
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

<div id="index-content">
    <div class="row">
        <?php if ($UserLevel != "Student") { ?>
            <div class="col-12">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <h4 class="section-topic mt-0">Admin Panel</h4>
                            </div>

                            <div class="col-6 col-md-4 mb-2 d-flex">
                                <div class="card admin-card border-0 rounded-4 shadow-sm flex-fill clickable" onclick="AddAnswers(0)">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <i class="fa-brands fa-3x fa-wirsindhandwerk"></i>
                                                <h5 class="card-title mb-0">Answers</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-6 col-md-4 mb-2 d-flex">
                                <div class="card admin-card border-0 rounded-4 shadow-sm flex-fill clickable" onclick="NewPatient(0)">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <i class="fa-solid fa-3x fa-hospital-user"></i>
                                                <h5 class="card-title mb-0">New Patient</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        <?php } ?>
        <div class="col-12">
            <h4 class="section-topic">Let's Treat Patients</h4>
        </div>

        <div class="col-12">
            <div class="row">
                <div class="col-12 offset-md-4 col-md-4 mb-2 d-flex">
                    <div class="card admin-card border-0 rounded-4 shadow-sm flex-fill clickable" onclick="RecoverPatients('<?= $CourseCode ?>')">
                        <div class="card-body text-center">
                            <div class="row">
                                <div class="col-12">
                                    <i class="fa-solid fa-3x fa-hospital-user"></i>
                                    <h5 class="card-title mb-0">Recover Patient</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="border-bottom my-3"></div>
        </div>
        <?php
        $lifeLinesCount = count($patients) * (50 / 100);
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
                if ($timer['patient_status'] == "Died") {
                    $bgColor = "danger";
                } else if ($timer['patient_status'] == "Pending") {
                    $bgColor = "warning";
                } else if ($timer['patient_status'] == "Recovered") {
                    $bgColor = "success";
                }

                if ($UserLevel == "Student" && CheckCoursePatientAvailability($link, $CourseCode, $selectedArray['prescription_id']) == false) {
                    continue;
                }
        ?>
                <div class="col-6 col-md-4 mb-2 d-flex">
                    <div class="card game-card shadow-sm flex-fill text-center" onclick="OpenPrescription('<?= $selectedArray['prescription_id'] ?>', '<?= $loopCount ?>')">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <img src="./lib/ceylon-pharmacy/assets/images/patient-<?= $loopCount ?>.png" class="game-icon">
                                    <h4 class="card-title"><?= $selectedArray['prescription_name'] ?></h4>
                                    <div class="badge badge-primary bg-<?= $bgColor ?>"><?= $timer['patient_status'] ?></div>
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