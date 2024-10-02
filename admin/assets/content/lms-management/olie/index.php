<?php
require_once '../../../../vendor/autoload.php';

use Symfony\Component\HttpClient\HttpClient;

$loggedUser = $_POST['LoggedUser'];

$dotenv = Dotenv\Dotenv::createImmutable('../../../../');
$dotenv->load();

$client = HttpClient::create();
$response = $client->request('GET', $_ENV["SERVER_URL"] .'/community-post-reply/statistics/');
$response2 = $client->request('GET', $_ENV["SERVER_URL"] .'/community-post/');
$answersCount = $response->toArray();
$communityPostTotal = count($response2->toArray());
$answersTotal = count($answersCount);

?>

<!-- these not work on common scripts -->
<!-- <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css"> -->






<div id="submission-list">

    <div class="row mt-5">

        <div class="col-md-3">
            <div class="card item-card">
                <div class="overlay-box">
                    <i class="fa-solid fa-comments icon-card"></i>
                </div>
                <div class="card-body">
                    <p>Total Topics</p>
                    <h1><?= $communityPostTotal ?></h1>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card item-card">
                <div class="overlay-box">
                    <i class="fa-solid fa-square-poll-vertical icon-card"></i>
                </div>
                <div class="card-body">
                    <p>Total Answers</p>
                    <h1><?= $answersTotal ?></h1>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-12">
            <h5 class="table-title mb-4">Students Answers Submissions</h5>
            <div class="row g-3">

                <div class="row g-2">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hovered table-striped" id="answer-table">
                                        <thead>
                                            <tr>
                                                <th>Student Name</th>
                                                <th class="text-center">Total Answers</th>
                                                <th class="text-center">Total Questions</th>
                                                <th class="text-center">Total Ratings</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($answersCount as $answer) { ?>
                                            <tr>
                                                <td><?= $answer['student_name'] ?></td>
                                                <td class="text-center"><?= $answer['reply_count'] ?></td>
                                                <td class="text-center"><?= $answer['reply_post_count'] ?></td>

                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
$('#answer-table').DataTable({
    dom: 'Bfrtip',
    buttons: [
        'copy', 'csv', 'excel', 'pdf'
        // 'colvis'
    ],

});
</script>