<?php
require_once '../../include/configuration.php';
include '../../php_handler/function_handler.php';

$UserLevel = $_POST['UserLevel'];
$loggedUser = $_POST['LoggedUser'];
$prescriptionID = $_POST['prescriptionID'];
$patient =  GetPatients($link)[$prescriptionID];
$medicineEnvelopes = GetPrescriptionCovers($link, $prescriptionID);

$task_2_active = "Not Permitted. Please Complete Above Task!";
$task_2_bg = "warning";

$task_3_active = "Not Permitted. Please Complete Above Task!";
$task_3_bg = "warning";

if ($UserLevel == "Student") {
    $StartTreatments = StartTreatments($link, $loggedUser, $prescriptionID);
}
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
    <div class="col-12 text-end mt-3">
        <button class="btn btn-dark btn-sm rounded-3" onclick="GetPatient('<?= $prescriptionID ?>')"><i class="fa-solid fa-rotate-right player-icon"></i> Reload</button>
        <button class="btn btn-warning btn-sm rounded-3" onclick="OpenIndex()"><i class="fa-solid fa-home player-icon"></i> Home</button>
    </div>

    <div class="col-12 col-md-6 mb-2 d-none" id="prescription"></div>

    <div class="col-12">
        <h4 class="section-topic mb-0">Task 1</h4>
        <p class="my-0 border-bottom pb-2 mini-text">Fill the Medicine Envelopes</p>
    </div>

    <?php
    $correctLoopCount = 0; // Initialize the loop count.
    if (!empty($medicineEnvelopes)) {


        foreach ($medicineEnvelopes as $selectedArray) {
            $badgeColor = "warning";
            $answerStatus = "Not Completed";

            $SubmissionArray = CeylonPharmacySubmittedAnswersByCover($link, $loggedUser, $selectedArray['cover_id'], $prescriptionID, "Correct");

            if (!empty($SubmissionArray)) {
                $answerStatus = "Completed";
                $badgeColor = "primary";
                $correctLoopCount++; // Increment the loop count.
            }

    ?>
            <div class="col-6 col-md-4 mb-2 d-flex">
                <div class="card game-card shadow-sm flex-fill" onclick="OpenEnvelope('<?= $selectedArray['prescription_id'] ?>', '<?= $selectedArray['cover_id'] ?>')">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <img src="./lib/ceylon-pharmacy/assets/images/envelope.png" class="game-icon">
                                <h4 class="card-title"><?= $selectedArray['content'] ?></h4>
                                <span class="bg-<?= $badgeColor ?> badge badge-<?= $badgeColor ?> mt-2"><?= $answerStatus ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    <?php
        }
    }
    ?>
    <div class="col-12">
        <div class="row">
            <div class="col-12 mt-2">
                <h4 class="section-topic mb-0">Task 2</h4>
                <p class="my-0 border-bottom pb-2 mini-text">Counselling Unit</p>
                <div class="row">

                    <?php
                    if (count($medicineEnvelopes) == $correctLoopCount || $UserLevel != "Student") {
                        if (!empty($medicineEnvelopes)) {
                            $correctLoopCount = 0; // Initialize the loop count.

                            foreach ($medicineEnvelopes as $selectedArray) {
                                $badgeColor = "warning";
                                $answerStatus = "Not Completed";
                                $SubmissionArray = CeylonPharmacySubmittedInstructionsByCover($link, $loggedUser, $selectedArray['cover_id'], $prescriptionID, "Correct");

                                if (!empty($SubmissionArray)) {
                                    $answerStatus = "Completed";
                                    $badgeColor = "primary";
                                    $correctLoopCount++; // Increment the loop count.
                                }
                    ?>
                                <div class="col-6 col-md-4 mb-2 d-flex">
                                    <div class="card game-card shadow-sm flex-fill" onclick="OpenCounselling('<?= $selectedArray['prescription_id'] ?>', '<?= $selectedArray['cover_id'] ?>')">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <img src="./lib/ceylon-pharmacy/assets/images/envelope.png" class="game-icon">
                                                    <h4 class="card-title"><?= $selectedArray['content'] ?></h4>
                                                    <span class="bg-<?= $badgeColor ?> badge badge-<?= $badgeColor ?> mt-2"><?= $answerStatus ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        <?php
                            }
                        }
                    } else { ?>
                        <div class="col-12">
                            <div class="alert alert-<?= $task_2_bg ?> border-2"><?= $task_2_active ?></div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>

            <div class="col-12 mt-2">
                <h4 class="section-topic mb-0">Task 3</h4>
                <p class="my-0 border-bottom pb-2 mini-text">Get The Payment</p>
                <div class="row">

                    <?php
                    if (count($medicineEnvelopes) == $correctLoopCount || $UserLevel != "Student") { ?>
                        <div class="col-12 col-md-4 mb-2 d-flex">
                            <div class="card border-0 rounded-3 mt-3 ">
                                <div class="card-body text-center">
                                    <img src="./lib/ceylon-pharmacy/assets/images/cash-payment.png" style="max-width: 150px;">
                                    <button onclick="OpenPayment('<?= $prescriptionID ?>')" class="btn btn-primary mt-3 btn-lg w-100">Take The Payment</button>
                                </div>
                            </div>
                        </div>

                    <?php } else { ?>
                        <div class="col-12">
                            <div class="alert alert-<?= $task_3_bg ?> border-2"><?= $task_3_active ?></div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>


        </div>
    </div>
</div>