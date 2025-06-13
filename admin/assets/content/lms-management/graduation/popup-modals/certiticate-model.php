<?php
require __DIR__ . '/../../../../../vendor/autoload.php';

use Dotenv\Dotenv;
use Symfony\Component\HttpClient\HttpClient;

define('PARENT_SEAT_RATE', 500);

$dotenv = Dotenv::createImmutable(dirname(__DIR__, 5))->load();
$client = HttpClient::create();

$referenceId = $_POST['referenceId'];
$bookingInfo = $client->request('GET', $_ENV['SERVER_URL'] . '/convocation-registrations/' . $referenceId)->toArray();
$studentInfo = $client->request('GET', $_ENV['SERVER_URL'] . '/userFullDetails/username/' . $bookingInfo['student_number'])->toArray();
$studentBalanceInfo = $client->request('GET', $_ENV['SERVER_URL'] . '/get-student-balance?loggedUser=' . $bookingInfo['student_number'])->toArray();
$packageInfo = $client->request('GET', $_ENV["SERVER_URL"] . '/packages/' . $bookingInfo['package_id'])->toArray();
$dueAmount = $packageInfo['price'] + ($bookingInfo['additional_seats'] * PARENT_SEAT_RATE);
$courseBalance = $studentBalanceInfo['studentBalance'];
$convocationBalance = $dueAmount - $bookingInfo['payment_amount'];
?>

<div class="loading-popup-content">
    <div class="row">
        <div class="col-12 w-100 text-end">
            <button class="btn btn-sm btn-dark" onclick="ClosePopUP()"><i class="fa-regular fa-circle-xmark"></i></button>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <h5 class="text-center mb-2 border-bottom pb-2">Certificate Generation</h5>
            <div class="row">
                <div class="col-3">
                    <div>Reference #</div>
                    <strong><?= $bookingInfo['student_number'] ?></strong>
                </div>

                <div class="col-3">
                    <div>Student Name</div>
                    <strong><?= $bookingInfo['student_number'] ?></strong>
                </div>

                <div class="col-4">
                    <div>Name on Certificate</div>
                    <strong><?= $studentInfo['name_on_certificate'] ?></strong>
                </div>
            </div>


            <div class="row mt-2">
                <div class="col-3">
                    <div>Course Balance</div>
                    <strong><?= number_format($courseBalance, 2) ?></strong>
                </div>

                <div class="col-3">
                    <div>Convocation Balance</div>
                    <strong><?= number_format($convocationBalance, 2) ?></strong>
                </div>
            </div>


            <?php if (floatval($courseBalance) == 0 && floatval($convocationBalance) == 0): ?>
                <div class="alert alert-success mt-2">
                    ✅ Eligible to generate certificate
                </div>
            <?php else: ?>
                <div class="alert alert-warning mt-2">
                    ⚠️ Payments are available to get
                </div>
            <?php endif; ?>

            <div class="row">
                <div class="col-12 text-end">
                    <button class="btn btn-dark btn-sm" type="button" onclick="GenerateCertificate()">Generate Certificate</button>
                </div>
            </div>


        </div>
    </div>
</div>