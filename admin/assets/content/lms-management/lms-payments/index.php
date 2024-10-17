<?php

require_once '../../../../vendor/autoload.php';
use Symfony\Component\HttpClient\HttpClient;

$dotenv = Dotenv\Dotenv::createImmutable('../../../../');
$dotenv->load();

$client = HttpClient::create();
$response = $client->request('GET', $_ENV["SERVER_URL"] .'/course/');
$courseList = $response->toArray();

?>

<?php include './views/total-counters.php' ?>
<div id="submission-list">
    <div class="row g-3">
        <div class="col-12">
            <h5 class="table-title mb-4">Please Choose Batch to open Payments</h5>
            <div class="row g-3">

                <?php foreach ($courseList as $course) : ?>
                <div class="col-md-3 d-flex">
                    <div class="card clickable flex-fill" onclick="GetCoursePayments('<?= $course['course_code'] ?>')">
                        <div class="card-body">
                            <h6 class="mb-0"><?= $course['course_name']?></h6>
                            <p class="mb-0"><?= $course['course_code']?></p>
                        </div>
                    </div>
                </div>
                <?php endforeach ?>

            </div>
        </div>
    </div>
</div>