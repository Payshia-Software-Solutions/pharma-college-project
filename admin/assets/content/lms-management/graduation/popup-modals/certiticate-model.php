<?php
require __DIR__ . '/../../../../../vendor/autoload.php';

use Dotenv\Dotenv;
use Symfony\Component\HttpClient\HttpClient;

$dotenv = Dotenv::createImmutable(dirname(__DIR__, 5))->load();
$client = HttpClient::create();

$referenceId = $_POST['referenceId'];
$bookingInfo = $client->request('GET', $_ENV['SERVER_URL'] . '/convocation-registrations/' . $referenceId)->toArray();
?>

<div class="loading-popup-content">
    <div class="row">
        <div class="col-12 w-100 text-end">
            <button class="btn btn-sm btn-dark" onclick="ClosePopUP()"><i class="fa-regular fa-circle-xmark"></i></button>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <h5 class="text-center">Certificate Generation</h5>

            <div class="row">
                <div class="col-3">
                    <div>Reference #</div>
                    <strong><?= $bookingInfo['student_number'] ?></strong>
                </div>

                <div class="col-3">

                </div>
            </div>


        </div>
    </div>
</div>