<?php

$criteraList = [
    [
        'id' => 1,
        'title' => 'Pharmer Hunter Game',
        'description' => 'you must pass 1000 level of hunter game',
        'bar_width' => '10%',
    ],
    [
        'id' => 2,
        'title' => 'Pharmer Hunter Game 1',
        'description' => '11',
        'bar_width' => '30%',
    ],
    [
        'id' => 3,
        'title' => 'Pharmer Hunter Game 2',
        'description' => '22',
        'bar_width' => '60%',
    ],
    [
        'id' => 4,
        'title' => 'Pharmer Hunter Game 3',
        'description' => '33',
        'bar_width' => '100%',
    ],
    [
        'id' => 5,
        'title' => 'Pharmer Hunter Game 4',
        'description' => '44',
        'bar_width' => '70%',
    ],
];

$certificateEligibility = true;
$certificateEligibility = false;

?>

<div class="card border-0 shadow-lg rounded-4">
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <h1 class="p-2">Certificate Criteria</h1>
            </div>

            <?php foreach ($criteraList as $criteria) : ?>
                <div class="col-md-3 d-flex mt-2">
                    <div class="card rounded-3 knowledge-card flex-fill shadow">
                        <div class="card-body">
                            <h5 class="p-1 text-center"><?= $criteria['title'] ?></h5>
                            <p class="text-center"><?= $criteria['description'] ?></p>
                            <div
                                class="progress"
                                role="progressbar"
                                aria-label="Basic example"
                                aria-valuenow="0"
                                aria-valuemin="0"
                                aria-valuemax="100">
                                <div class="progress-bar" style="width: <?= htmlspecialchars($criteria['bar_width']) ?>;"></div>
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

                    <button class="btn btn-primary w-100" type="button">Button</button>

                <?php else : ?>
                    <div class="alert alert-warning mb-0">You are not Eligible for order this certificate. Please complete all Criteria</div>
                <?php endif ?>
            </div>
        </div>

    </div>
</div>