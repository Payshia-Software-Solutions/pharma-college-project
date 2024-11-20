<?php

// Assuming the class is HunterSaveAnswer
require_once '../../include/configuration.php';
require_once(__DIR__ . '/../../../server/models/Hunter/HunterSaveAnswer.php');  // Adjusted path

// Assuming $LoggedUser is passed dynamically
$LoggedUser = $_POST['LoggedUser'];  // Example: Logged user is passed as student number

// Create an instance of the HunterSaveAnswer class
$hunterSaveAnswer = new HunterSaveAnswer($pdo);

// Call the HunterSavedAnswersByUser method on the instance
$answerData = $hunterSaveAnswer->HunterSavedAnswersByUser($LoggedUser);  // Instance method call

// Extract the correct answer count from the result
$correctAnswerCount = isset($answerData[$LoggedUser]['correct_count']) ? $answerData[$LoggedUser]['correct_count'] : 0;

// Certificate criteria list
$criteraList = [
    [
        'id' => 1,
        'title' => 'Pharmer Hunter Game',
        'description' => ($correctAnswerCount / 1000) * 100 . '%',
        'bar_width' => ($correctAnswerCount / 1000) * 100 . '%',
        'moq' => 1000
    ],
    [
        'id' => 2,
        'title' => 'Pharmer Hunter Game 1',
        'description' => '11',
        'bar_width' => '30%',
        'moq' => 1000
    ],
    [
        'id' => 3,
        'title' => 'Pharmer Hunter Game 2',
        'description' => '22',
        'bar_width' => '60%',
        'moq' => 1000
    ],
    [
        'id' => 4,
        'title' => 'Pharmer Hunter Game 3',
        'description' => '33',
        'bar_width' => '100%',
        'moq' => 1000
    ],
    [
        'id' => 5,
        'title' => 'Pharmer Hunter Game 4',
        'description' => '44',
        'bar_width' => '70%',
        'moq' => 1000
    ],
];

// Logic to determine certificate eligibility (e.g., based on correct answer count)
$certificateEligibility = $correctAnswerCount >= 1000; // Assuming eligibility is based on the correct answer count

?>

<div class="card border-0 shadow-lg rounded-4">
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <h1 class="p-2">Certificate Criteria</h1>
            </div>

            <?php foreach ($criteraList as $index => $criteria) : ?>
                <div class="col-md-3 d-flex mt-2">
                    <div class="card rounded-3 knowledge-card flex-fill shadow">
                        <div class="card-body">
                            <h5 class="p-1 text-center"><?= $criteria['title'] ?></h5>
                            <p class="text-center"><?= $criteria['description'] ?></p>
                            <div
                                class="progress"
                                role="progressbar"
                                aria-label="Basic example"
                                aria-valuenow="<?= $correctAnswerCount ?>"
                                aria-valuemin="0"
                                aria-valuemax="1000">
                                <div class="progress-bar" style="width: <?= $criteria['bar_width'] ?>;"></div>

                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

        </div>
        <div class="row mt-4">
            <div class="col-12">

                <?php if ($certificateEligibility) : ?>
                    <!-- Button for getting certificate -->
                    <button class="btn btn-success w-100 btn-lg" type="button"><i class="fa fa-shopping-cart"></i> Order Certificate</button>
                <?php else : ?>
                    <div class="alert alert-warning mb-0">You are not eligible to order this certificate. Please complete all criteria.</div>
                <?php endif ?>
            </div>
        </div>

    </div>
</div>