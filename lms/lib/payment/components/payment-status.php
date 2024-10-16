<?php

require '../../vendor/autoload.php';

use Dotenv\Dotenv;
use Symfony\Component\HttpClient\HttpClient;

//for use env file data
$dotenv = Dotenv::createImmutable(__DIR__ . '../../../../');
$dotenv->load();

$client = HttpClient::create();

// Make the GET request to fetch payement reasons
$response = $client->request('GET', $_ENV["SERVER_URL"] .'/payment-request/' . $loggedUser);
$paymentsHistory = $response->toArray();

?>


<div class="col">
    <div class="row">
        <?php if ($paymentsHistory) : ?>
        <?php foreach ($paymentsHistory as $payment) : ?>
        <div class="col-md-4 col-12 mb-2">
            <div class="card shadow border-0 rounded-3">
                <div class="card-body pt-4 pb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <h5 class="d-inline mb-0 text-truncate" style="max-width: 150px;"><?= $payment['reason'] ?>
                            </h5>
                            <i class="fas fa-info-circle ms-2" data-bs-toggle="tooltip" data-bs-placement="top"
                                title="<?= $payment['extra_note'] ?>"></i>
                        </div>
                    </div>
                    <!-- Date and Status Row -->
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <h6 class="mb-0"><?= $payment['created_at'] ?></h6>
                        <?php if ($payment['status'] == 0) : ?>
                        <h6 class="badge bg-danger text-uppercase text-light mb-0">Pending</h6>
                        <?php else : ?>
                        <h6 class="badge bg-success text-uppercase text-light mb-0 px-3">Paid</h6>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
        <?php else : ?>
        <div class="card shadow border-0 rounded-3">
            <div class="card-body">
                <p>No Entries ...</p>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>