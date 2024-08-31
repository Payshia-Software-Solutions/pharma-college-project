<?php
require_once '../../../include/configuration.php';
include '../../../php_handler/function_handler.php';

// `id`, `answer_id`, `pres_id`, `cover_id`, `date`, `name`, `drug_name`, `drug_type`, `drug_qty`, `morning_qty`, `afternoon_qty`, `evening_qty`, `night_qty`, `meal_type`, `using_type`, `at_a_time`, `hour_qty`, `additional_description`, `created_at`, `created_by`

$colMdValue = 4;
$colValue = 6;
$contentType = $_POST['contentType'];
if ($contentType === 'name') {
    $choice = 'name';
    $iconPrefix = 'patient';
    $popUpTitle = "Patient Name";
    $answerType = "Name";
} else if ($contentType === 'drug-name') {
    $choice = 'drug_name';
    $iconPrefix = 'medicine';
    $popUpTitle = "Drug Name";
    $answerType = "DrugName";
} else if ($contentType === 'dosage-form') {
    $choice = 'drug_type';
    $iconPrefix = null;
    $popUpTitle = "Dosage Form";
    $answerType = "DosageForm";
} else if ($contentType === 'drug-quantity') {
    $choice = 'drug_qty';
    $iconPrefix = null;
    $popUpTitle = "Drug Quantity";
    $answerType = "Quantity";
} else if ($contentType === 'morning-quantity') {
    $choice = 'morning_qty';
    $iconPrefix = null;
    $popUpTitle = "Morning Drug Quantity";
    $answerType = "Quantity";
} else if ($contentType === 'afternoon-quantity') {
    $choice = 'morning_qty';
    $iconPrefix = null;
    $popUpTitle = "Afternoon Drug Quantity";
    $answerType = "Quantity";
} else if ($contentType === 'evening-quantity') {
    $choice = 'afternoon_qty';
    $iconPrefix = null;
    $popUpTitle = "Evening Drug Quantity";
    $answerType = "Quantity";
} else if ($contentType === 'night-quantity') {
    $choice = 'night_qty';
    $iconPrefix = null;
    $popUpTitle = "Night Drug Quantity";
    $answerType = "Quantity";
} else if ($contentType === 'night-quantity') {
    $choice = 'night_qty';
    $iconPrefix = null;
    $popUpTitle = "Night Drug Quantity";
    $answerType = "Quantity";
} else if ($contentType === 'meal-type') {
    $choice = 'meal_type';
    $iconPrefix = null;
    $popUpTitle = "Meal Type";
    $answerType = "MealType";
} else if ($contentType === 'using-frequency') {
    $choice = 'using_type';
    $iconPrefix = null;
    $popUpTitle = "Using Frequency";
    $answerType = "UsingType";
} else if ($contentType === 'at-a-time') {
    $choice = 'at_a_time';
    $iconPrefix = null;
    $popUpTitle = "බැගින්";
    $answerType = "Quantity";
} else if ($contentType === 'using-frequency-hour') {
    $choice = 'hour_qty';
    $iconPrefix = null;
    $popUpTitle = "පැය __ වරක්";
    $answerType = "Quantity";
} else if ($contentType === 'additional-instruction') {
    $choice = 'additional_instruction';
    $iconPrefix = null;
    $popUpTitle = "Additional instruction";
    $colValue = 12;
    $colMdValue = 6;
    $answerType = "Additional";
}
?>

<style>
    .answer-card:hover {
        background-color: #000;
        color: #fff !important;
    }

    .answer-card:hover h4 {
        color: #fff !important;
    }

    #envelop-content {
        max-height: 50vh;
        overflow-y: auto;
    }


    @media (max-width: 768px) {
        #envelop-content {
            max-height: 72vh !important;
        }
    }
</style>


<div class="row">
    <div class="col-12 mb-2">
        <h4>Select <?= $popUpTitle ?></h4>
    </div>

    <div class="col-12 mb-3">
        <input type="text" class="form-control" id="search-key" placeholder="Search Here..">
    </div>
    <div id="envelop-content">
        <div class="row">
            <?php

            $answers = GetAnswerListAdmin($link);
            if (!empty($answers)) {
                $loopCount = 0; // Initialize the loop count.


                foreach ($answers as $selectedArray) {
                    if ($selectedArray['answer_type'] != $answerType) {
                        continue;
                    }
                    // Reset the loop count to 0 after every 10 iterations.
                    if ($loopCount == 10) {
                        $loopCount = 0;
                    }

                    $loopCount++; // Increment the loop count.
            ?>
                    <div class="col-<?= $colValue ?> col-md-<?= $colMdValue ?> mb-2 d-flex answer-column">
                        <div style="cursor:pointer" class="answer-card card <?= ($iconPrefix) ? 'game-card ' : 'border-0' ?> shadow-sm flex-fill" onclick="SetElementValue('envelope-<?= $contentType ?>', '<?= $selectedArray['answer'] ?>')">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <?php
                                        if ($iconPrefix) { ?>
                                            <img src="./lib/ceylon-pharmacy/assets/images/<?= $iconPrefix ?>-<?= $loopCount ?>.png" class="game-icon">
                                        <?php
                                        }
                                        ?>
                                        <h4 class="card-title mb-0"><?= $selectedArray['answer'] ?></h4>
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
</div>

<script>
    document.getElementById("search-key").addEventListener("input", function() {
        const searchText = this.value.toLowerCase();
        const productColumns = document.querySelectorAll(".answer-column");

        productColumns.forEach(function(productColumn) {
            const productName = productColumn.querySelector(".card-title").textContent.toLowerCase();

            if (productName.includes(searchText)) {
                productColumn.classList.remove("d-none");
                productColumn.classList.add("d-block");
            } else {
                productColumn.classList.remove("d-block");
                productColumn.classList.add("d-none");
            }
        });
    });
</script>