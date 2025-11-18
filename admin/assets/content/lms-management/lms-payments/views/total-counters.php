<?php
require_once '../../../../vendor/autoload.php';

use Symfony\Component\HttpClient\HttpClient;

$dotenv = Dotenv\Dotenv::createImmutable('../../../../');
$dotenv->load();

$client = HttpClient::create();
$response = $client->request('GET', $_ENV["SERVER_URL"] .'/payment-request/statistics/');
$totalCount = $response->toArray();

?>

<div class="row mt-5 mb-3">
    <div class="col-md-3">
        <div class="card item-card shadow">
            <div class="overlay-box">
                <i class="fa-solid fa-file-contract icon-card"></i>
            </div>
            <div class="card-body">
                <p>All Payments</p>
                <h1><?= $totalCount["totalCount"] ?></h1>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card item-card shadow">
            <div class="overlay-box">
                <i class="fa-solid fa-hourglass-end icon-card"></i>
            </div>
            <div class="card-body">
                <p>Pending Payments</p>
                <h1><?= $totalCount["pendingCount"] ?></h1>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card item-card shadow">
            <div class="overlay-box">
                <i class="fa-solid fa-clipboard-check icon-card"></i>
            </div>
            <div class="card-body">
                <p>Approved payments</p>
                <h1><?= $totalCount["approvedCount"] ?></h1>
            </div>
        </div>
    </div>


</div>