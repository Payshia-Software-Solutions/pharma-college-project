<?php
require_once '../../../../include/configuration.php';
include '../../../../php_handler/function_handler.php';
include '../../php_methods/d-pad-methods.php';

$studentNumber = $_POST['studentNumber'];
$savedAnswers = GetSubmittedAnswersByUser($studentNumber);


$prescriptionArray = GetPrescriptions();
// var_dump($savedAnswers);

?>

<div class="row g-2">
    <?php
    if (!empty($savedAnswers)) {
        foreach ($savedAnswers as $selectedItem) {

            $prescriptionId = $selectedItem['pres_id'];

            $medicineEnvelopes =  GetPrescriptionCoversDpad($prescriptionId);
            $prescriptionDetails = $prescriptionArray[$prescriptionId];

            if (!empty($medicineEnvelopes)) {
                $medicineCount = 1;
                foreach ($medicineEnvelopes as $envelope) {
                    $badgeColor = "warning";
                    $answerStatus = "Not Completed";

                    $coverId = 'Cover' . $medicineCount++;
                    if ($selectedItem['cover_id'] == $coverId) {
                        $medicineName = $envelope;
                    }
                }
            }

            if ($selectedItem['answer_status'] == "Correct") {
                $badgeColor = "primary";
            } else {
                $badgeColor = "danger";
            }
            // var_dump($prescriptionDetails);
    ?>
            <div class="col-12 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-9">
                                <h6 class="mb-0 fw-bold"><?= $medicineName ?> - <?= $prescriptionDetails['prescription_name'] ?></h6>
                                <p class="text-secondary mb-0">
                                    <?= $selectedItem['cover_id'] ?> - <?= $prescriptionId ?> | <?= $selectedItem['created_at'] ?>
                                </p>
                                <span class="badge bg-<?= $badgeColor ?>"> <?= $selectedItem['answer_status'] ?></span>
                            </div>
                            <div class="col-3 text-end">
                                <i onclick="DeleteSubmission(<?= $selectedItem['id'] ?>, '<?= $studentNumber ?>')" class="clickable fa-solid fa-trash text-danger"></i>
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