<?php
require_once '../../include/configuration.php';
include '../../php_handler/function_handler.php';

$loggedUser = $_POST['LoggedUser'];
$UserLevel = $_POST['UserLevel'];

// $UserLevel = "Student";
$coverID = $_POST['coverID'];
$prescriptionID = $_POST['prescriptionID'];
$patient =  GetPatients($link)[$prescriptionID];
$selectedArray = GetPrescriptionCovers($link, $prescriptionID)[$coverID];

$finish_status = false;

// GetSubmissionValues
$id = $answer_id = $pres_id = $cover_id = $date = $name = $drug_name = $drug_type = $drug_qty = $morning_qty = $afternoon_qty = $evening_qty = $night_qty = $meal_type = $using_type = $at_a_time = $hour_qty = $additional_description = $created_at = $created_by = $answer_status = $score = '';

$SubmissionArray = CeylonPharmacySubmittedAnswersByCover($link, $loggedUser, $coverID, $prescriptionID, "Correct");
if (!empty($SubmissionArray)) {
    $SubmissionArray = $SubmissionArray[0];
    $finish_status = true;
    foreach ($SubmissionArray as $key => $value) {
        $$key = $value;
    }
}
$instructions = GetAllInstructions($link);
$correctAnswer =  GetCorrectInstructions($link, $prescriptionID, $coverID);
$instructionsCount = count($correctAnswer);

$userAnswers = GetSavedAnswersByUser($link, $loggedUser, $prescriptionID, $coverID);
?>
<input type="hidden" name="instructionsCount" id="instructionsCount" value="<?= $instructionsCount ?>">
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
        <button class="btn btn-dark btn-sm rounded-3" onclick="OpenCounselling('<?= $prescriptionID ?>', '<?= $coverID ?>')"><i class="fa-solid fa-rotate-right player-icon"></i> Reload</button>
        <button class="btn btn-warning btn-sm rounded-3" onclick="OpenIndex()"><i class="fa-solid fa-home player-icon"></i> Home</button>
    </div>
    <div class="col-12">
        <h4 class="section-topic mb-0">Task 1</h4>
        <p class="my-0 border-bottom pb-2 mini-text">Give the Instructions</p>

    </div>

    <div class="col-12 col-md-4 mb-2 d-none d-md-block" id="prescription"></div>

    <div class="col-12 col-md-8 mb-2 mt-3 d-flex">
        <div class="card border-0 shadow-sm flex-fill">
            <div class="card-body">

                <div class="row">
                    <div class="col-12 mb-2">
                        <h4>Instruction List</h4>
                    </div>

                    <?php if (empty($userAnswers) || $UserLevel != "Student") { ?>
                        <div class="col-12 mb-2">
                            <div class="alert alert-warning"><b><?= $instructionsCount ?> Instruction</b>(s) must be given!</div>
                        </div>
                        <div class="col-9">
                            <label>Choice Instruction</label>
                            <select id="instructionSelect" class="form-control">
                                <?php
                                if (!empty($instructions)) {
                                    foreach ($instructions as $selectedArray) {
                                ?>
                                        <option value="<?= $selectedArray['id'] ?>"><?= $selectedArray['id'] ?> - <?= $selectedArray['instruction'] ?></option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-3">
                            <label>Action</label>
                            <button class="btn btn-dark w-100 text-center" <?= ($UserLevel != "Student") ? 'onclick="addInstructionAdmin()"' : 'onclick="addInstruction()"' ?>><i class="fa-solid fa-plus player-icon"></i></button>
                        </div>
                    <?php } ?>
                    <div class="col-12 mt-3">
                        <table id="instructionTable" class="table table-hover table-striped table-bordered">
                            <thead>
                                <th>ID</th>
                                <th>Instructions</th>
                            </thead>
                            <tbody>
                                <?php
                                if (!empty($userAnswers) && $UserLevel == "Student") {
                                    foreach ($userAnswers as $selectedArray) {
                                ?>
                                        <tr>
                                            <td><?= $selectedArray['id'] ?></td>
                                            <td><?= $instructions[$selectedArray['Instruction']]['instruction'] ?></td>
                                        </tr>
                                <?php
                                    }
                                }
                                ?>

                                <?php
                                if (!empty($correctAnswer) && $UserLevel != "Student") {
                                    foreach ($correctAnswer as $selectedArray) {
                                ?>
                                        <tr>
                                            <td><?= $selectedArray['content'] ?></td>
                                            <td><?= $instructions[$selectedArray['content']]['instruction'] ?></td>
                                        </tr>
                                <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <?php if (empty($userAnswers)) { ?>
                        <div class="col-12 text-end">
                            <button type="button" onclick="ValidateInstructions('<?= $prescriptionID ?>', '<?= $coverID ?>')" class="btn btn-success btn-sm d-none d-md-inline-block"><i class="fa-solid fa-floppy-disk player-icon"></i> Validate</button>
                        </div>
                    <?php }

                    if ($UserLevel != "Student") { ?>
                        <div class="col-12 text-end mt-2">
                            <button type="button" onclick="ClearInstructions('<?= $prescriptionID ?>', '<?= $coverID ?>')" class="btn btn-primary btn-sm"><i class="fa-solid fa-trash  player-icon"></i> Clear</button>
                            <button type="button" onclick="SaveInstructions('<?= $prescriptionID ?>', '<?= $coverID ?>')" class="btn btn-dark btn-sm"><i class="fa-solid fa-floppy-disk player-icon"></i> Save</button>
                        </div>
                    <?php
                    }
                    ?>


                </div>
            </div>
        </div>
    </div>
    <div class="envelope-button-set d-md-none">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="btn-group w-100" role="group" aria-label="Basic example">
                        <button type="button" onclick="ViewPrescription('<?= $prescriptionID ?>')" class="btn btn-dark  w-100" style="border-radius: 15px 0 0 15px"><i class="fa-solid fa-file-prescription player-icon"></i> Prescription</button>
                        <button type="button" onclick="ValidateInstructions('<?= $prescriptionID ?>', '<?= $coverID ?>')" class="btn btn-success  w-100" style="border-radius: 0 15px 15px 0"><i class="fa-solid fa-floppy-disk player-icon"></i> Validate</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    var correctAnswerIds = <?php echo json_encode(array_column($correctAnswer, 'content')); ?>;

    var maxInstructionsCount = parseInt($('#instructionsCount').val(), 10);

    function addInstruction() {
        var error_msg;
        var selectedOption = $('#instructionSelect option:selected');
        var selectedInstructionId = selectedOption.val();
        var selectedInstructionText = selectedOption.text();

        // Extract text after the hyphen
        var textAfterHyphen = selectedInstructionText.split('-')[1].trim();

        // Check if the instruction is not already added and the limit is not reached
        if (
            selectedInstructionId &&
            textAfterHyphen &&
            addedInstructions.indexOf(selectedInstructionId) === -1 &&
            addedInstructions.length < maxInstructionsCount
        ) {
            // Check if the added instruction ID is in the correctAnswerIds array
            var isCorrect = correctAnswerIds.indexOf(selectedInstructionId) !== -1;

            // Display an alert if the instruction is incorrect
            if (!isCorrect) {
                error_msg = 'Incorrect instruction selected.';

                showNotification(error_msg, 'error', 'Oops!')
                return; // Do not add the row if the instruction is incorrect
            }

            // Add the instruction ID to the list
            addedInstructions.push(selectedInstructionId);

            // Add a new row to the table with separate columns for ID and Instructions, highlighting if it's correct
            var newRow = '<tr><td>' + selectedInstructionId + '</td><td style="color: green;">' + textAfterHyphen + '</td></tr>';
            $('#instructionTable tbody').append(newRow);
        } else {
            if (addedInstructions.length >= maxInstructionsCount) {
                error_msg = 'Maximum instruction count reached.';
            } else {
                error_msg = 'Instruction already added or not selected.';
            }
        }

        if (error_msg) {
            showNotification(error_msg, 'error', 'Oops!')
        }
    }
</script>