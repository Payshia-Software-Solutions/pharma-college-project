<?php
require_once '../../include/configuration.php';
include '../../php_handler/function_handler.php';
include './php_methods/d-pad-methods.php';

$loggedUser = $_POST['LoggedUser'];
$UserLevel = $_POST['UserLevel'];

// $UserLevel = "Student";
$coverID = $_POST['coverID'];
$coverNumber = str_replace('Cover', '', $coverID);

$prescriptionID = $_POST['prescriptionID'];

$prescriptionArray = GetPrescriptions()[$prescriptionID];
$medicineEnvelopes =  GetPrescriptionCoversDpad($prescriptionID);
$correctAnswer = DpadGetSavedAnswersByCover($prescriptionID, $coverID);
$saveButtonClass = ' d-md-inline-block';

$finish_status = false;
// GetSubmissionValues
$id = $answer_id = $pres_id = $cover_id = $date = $name = $drug_name = $drug_type = $drug_qty = $morning_qty = $afternoon_qty = $evening_qty = $night_qty = $meal_type = $using_type = $at_a_time = $hour_qty = $additional_description = $created_at = $created_by = $answer_status = $score = '';

if ($UserLevel != "Student") {
    $SubmissionArray = $correctAnswer;
} else {
    $SubmissionArray = DpadSubmittedAnswersByCover($loggedUser, $coverID, $prescriptionID, "Correct");
    if (!empty($SubmissionArray)) {
        $SubmissionArray = $correctAnswer;
    }
}
if (!empty($SubmissionArray)) {
    if ($UserLevel == "Student") {
        $saveButtonClass = 'd-none d-md-none';
    }

    $SubmissionArray = $SubmissionArray[0];
    $finish_status = true;
    foreach ($SubmissionArray as $key => $value) {
        $$key = $value;
    }
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

    .envelope-button-set {
        position: fixed;
        bottom: 88px;
        left: 0;
    }

    #root {
        padding-bottom: 20px;
    }
</style>

<div class="row">
    <div class="col-12 text-end mt-3">
        <button class="btn btn-success btn-sm rounded-3" onclick="GetPatient('<?= $prescriptionID ?>')"><i class="fa-solid fa-arrow-left player-icon"></i> Back</button>
        <button class="btn btn-dark btn-sm rounded-3" onclick="OpenEnvelope('<?= $prescriptionID ?>', '<?= $coverID ?>')"><i class="fa-solid fa-rotate-right player-icon"></i> Reload</button>
        <button class="btn btn-warning btn-sm rounded-3" onclick="OpenIndex()"><i class="fa-solid fa-home player-icon"></i> Home</button>
    </div>
    <div class="col-12">
        <h4 class="section-topic mb-0">Task 1</h4>
        <p class="my-0 border-bottom pb-2 mini-text">Fill the Medicine Envelopes</p>

    </div>

    <div class="col-12 col-md-4 mb-2 d-none d-md-block" id="prescription"></div>

    <div class="col-12 col-md-8 mb-2 mt-3 d-flex">
        <div class="card border-0 shadow-sm flex-fill">
            <div class="card-body">
                <form class="" id="envelope-form" method="post">
                    <div class="row">
                        <div class="col-12">
                            <h4 class="mb-3 fw-bold pb-2 border-bottom"><?= $medicineEnvelopes[$coverNumber - 1] ?> Envelope</h4>
                        </div>
                        <!-- Parameters -->
                        <input required type="hidden" value="<?= $prescriptionID ?>" name="prescriptionID" id="prescriptionID">
                        <input required type="hidden" value="<?= $coverID ?>" name="coverID" id="coverID">

                        <!-- Section 1 -->
                        <div class="col-6 col-md-4 mb-3">
                            <?php $data_value = "date"; ?>
                            <label for="envelope-<?= $data_value ?>"><?= formatLabelName($data_value) ?></label>
                            <input required type="date" name="envelope-<?= $data_value ?>" id="envelope-<?= $data_value ?>" class="flex-fill w-100 btn btn-light" value="<?= $date ?>">
                        </div>

                        <div class="col-6 col-md-4 mb-3">
                            <?php
                            $data_value = "name";
                            $answer_input = $name;
                            ?>
                            <?php include './requests/input-care-center.php' ?>
                        </div>

                        <div class="col-12 col-md-4 mb-3">
                            <?php
                            $data_value = "drug-name";
                            $answer_input = $drug_name;
                            ?>
                            <?php include './requests/input-care-center.php' ?>
                        </div>

                        <div class="col-8 col-md-4 mb-3">
                            <?php
                            $data_value = "dosage-form";
                            $answer_input = $drug_type;
                            ?>
                            <?php include './requests/input-care-center.php' ?>
                        </div>

                        <div class="col-4 col-md-4 mb-3">
                            <?php
                            $data_value = "drug-quantity";
                            $answer_input = $drug_qty;
                            ?>
                            <?php include './requests/input-care-center.php' ?>
                        </div>
                        <!-- End of Section 1 -->

                        <!-- Section 2 -->
                        <div class="col-12">
                            <h5 class="border-bottom pb-2 mt-3">Drug Quantities</h5>
                        </div>

                        <div class="col-6 col-md-3 mb-3">
                            <?php
                            $data_value = "morning-quantity";
                            $answer_input = $morning_qty;
                            ?>
                            <?php include './requests/input-care-center.php' ?>
                        </div>

                        <div class="col-6 col-md-3 mb-3">
                            <?php $data_value = "afternoon-quantity";
                            $answer_input = $afternoon_qty; ?>
                            <?php include './requests/input-care-center.php' ?>
                        </div>

                        <div class="col-6 col-md-3 mb-3">
                            <?php $data_value = "evening-quantity";
                            $answer_input = $evening_qty; ?>
                            <?php include './requests/input-care-center.php' ?>
                        </div>

                        <div class="col-6 col-md-3 mb-3">
                            <?php $data_value = "night-quantity";
                            $answer_input = $night_qty; ?>
                            <?php include './requests/input-care-center.php' ?>
                        </div>
                        <!-- End of Section 2 -->

                        <!-- Section 3 -->
                        <div class="col-12">
                            <h5 class="border-bottom pb-2 mt-3">Other</h5>
                        </div>

                        <div class="col-12 col-md-4 mb-3">
                            <?php $data_value = "meal-type";
                            $answer_input = $meal_type; ?>
                            <?php include './requests/input-care-center.php' ?>
                        </div>

                        <div class="col-12 col-md-4 mb-3">
                            <?php $data_value = "using-frequency";
                            $answer_input = $using_type; ?>
                            <?php include './requests/input-care-center.php' ?>
                        </div>
                        <!-- End of Section 3 -->

                        <!-- Section 4 -->
                        <div class="col-12">
                            <h5 class="border-bottom pb-2 mt-3">Other Quantities</h5>
                        </div>

                        <div class="col-6 col-md-4 mb-3">
                            <?php $data_value = "at-a-time"; ?>
                            <label for="envelope-<?= $data_value ?>">බැගින්</label>
                            <input required type="text" name="envelope-<?= $data_value ?>" id="envelope-<?= $data_value ?>" class="flex-fill w-100 btn btn-light" <?= ($finish_status && $UserLevel == "Student") ? '' : 'onclick="SelectEnvelopeContent(\'' . $data_value . '\')" ' ?> value="<?= $at_a_time ?>" readonly>
                        </div>

                        <div class="col-6 col-md-4 mb-3">
                            <?php $data_value = "using-frequency-hour"; ?>
                            <label for="envelope-<?= $data_value ?>">පැය __ වරක්</label>
                            <input required type="text" name="envelope-<?= $data_value ?>" id="envelope-<?= $data_value ?>" class="flex-fill w-100 btn btn-light" <?= ($finish_status && $UserLevel == "Student") ? '' : 'onclick="SelectEnvelopeContent(\'' . $data_value . '\')" ' ?> value="<?= $hour_qty ?>" readonly>
                        </div>
                        <!-- End of Section 4 -->

                        <!-- Section 5 -->
                        <div class="col-12 col-md-4 mb-3">
                            <?php $data_value = "additional-instruction"; ?>
                            <label for="envelope-<?= $data_value ?>"><?= formatLabelName($data_value) ?></label>
                            <input required type="text" name="envelope-<?= $data_value ?>" id="envelope-<?= $data_value ?>" class="flex-fill w-100 btn btn-light" <?= ($finish_status && $UserLevel == "Student") ? '' : 'onclick="SelectEnvelopeContent(\'' . $data_value . '\')" ' ?> value="<?= $additional_description ?>" readonly>
                        </div>
                        <!-- End of Section 5 -->


                        <div class="col-12 text-end">

                            <button type="button" onclick="SaveEnvelopAnswer('<?= $prescriptionID ?>')" class="btn btn-success btn-sm <?= $saveButtonClass ?>"><i class="fa-solid fa-floppy-disk player-icon"></i> Save</button>

                            <?php if ($UserLevel != "Student") { ?>
                                <button type="button" onclick="SaveEnvelopAnswerAdmin('<?= $prescriptionID ?>')" class="btn btn-dark btn-sm d-none d-md-inline-block"><i class="fa-solid fa-floppy-disk player-icon"></i> Save Admin</button>
                            <?php } ?>


                        </div>

                    </div>

                </form>
            </div>

        </div>
    </div>

    <div class="envelope-button-set d-md-none">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="btn-group w-100" role="group" aria-label="Basic example">
                        <button type="button" onclick="ViewPrescription('<?= $prescriptionID ?>')" class="btn btn-dark  w-100" style="border-radius: 15px 0 0 15px"><i class="fa-solid fa-file-prescription player-icon"></i> Prescription</button>
                        <button type="button" onclick="SaveEnvelopAnswer('<?= $prescriptionID ?>')" class="btn btn-success <?= $saveButtonClass ?>  w-100" style="border-radius: 0 15px 15px 0"><i class="fa-solid fa-floppy-disk player-icon"></i> Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>