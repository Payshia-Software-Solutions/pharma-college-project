<?php
require_once '../../include/configuration.php';
include '../../php_handler/function_handler.php';

$UserLevel = $_POST['UserLevel'];
$loggedUser = $_POST['LoggedUser'];
$imageID = $_POST['imageID'];
$prescriptionID = $_POST['prescriptionID'];
$patient =  GetPatients($link)[$prescriptionID];
$timer = GetTimer($link, $loggedUser, $prescriptionID);
?>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Indie+Flower&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

    .handwrite {
        font-family: 'Indie Flower', cursive;
        font-size: 20 px;
    }

    .prescription-card {
        background-color: #FFFEFE;
        border: 15px solid #009E60;
        border-radius: 0px !important;
    }

    .prescription-card .mini-text {
        font-size: 10px;
    }
</style>

<div class="row">
    <div class="col-12">
        <h4 class="section-topic">Let's Treat <?= $patient['prescription_name'] ?></h4>
    </div>

    <div class="col-12 text-end mt-3">
        <button class="btn btn-dark btn-sm rounded-3" onclick="OpenPrescription('<?= $prescriptionID ?>', '<?= $imageID ?>')"><i class="fa-solid fa-rotate-right player-icon"></i> Reload</button>
        <button class="btn btn-warning btn-sm rounded-3" onclick="OpenIndex()"><i class="fa-solid fa-home player-icon"></i> Home</button>
    </div>

    <div class="col-12 col-md-6 mb-2 mt-3">



        <div class="card border-0 rounded-4 shadow-sm flex-fill mt-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-4 text-center">
                        <img src="./lib/ceylon-pharmacy/assets/images/patient-<?= $imageID ?>.png" class="w-100">
                    </div>
                    <div class="col-8 text-start">
                        <h4 class="card-title border-bottom pb-2"><?= $patient['prescription_name'] ?></h4>
                        <p class="my-0">Status : <?= $timer['patient_status'] ?></p>
                        <p class="my-0">Start Time : <?= $timer['start_time'] ?></p>
                        <p class="my-0">End time : <?= $timer['end_time'] ?></p>
                    </div>

                    <?php
                    if (($timer['patient_status'] != "Died" && $timer['patient_status'] != "Recovered") || $UserLevel != "Student") { ?>
                        <div class="col-12">
                            <button class="btn btn-dark w-100 p-2 mt-3" onclick="GetPatient('<?= $prescriptionID ?>') ">Start</button>
                        </div>
                    <?php
                    } else {
                    ?><div class="col-12 mt-3">
                            <?php
                            if ($timer['patient_status'] == "Recovered") {
                                $patientStatus = "Recovered";
                            } else if ($timer['patient_status'] == "Died") {
                                $patientStatus = "Killed";
                            }
                            ?>
                            <div class="alert alert-warning mb-0">You <b><?= $patientStatus ?></b> <?= $patient['prescription_name'] ?> </div>
                        </div>
                    <?php
                    }
                    ?>

                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6 mb-2 d-flex" id="prescription"></div>
</div>

</div>