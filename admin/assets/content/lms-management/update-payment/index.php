<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include '../../../../include/function-update.php';
include '../../../../include/lms-functions.php';
require __DIR__ . '/../../../../vendor/autoload.php';

// For use env file data
use Dotenv\Dotenv;
use Symfony\Component\HttpClient\HttpClient;

$dotenv = Dotenv::createImmutable(dirname(__DIR__, 4))->load(); // Load environment variables
$client = HttpClient::create(); // Initialize HTTP client

// Get Payment Requests
$paymentRequests = $client->request('GET', $_ENV['SERVER_URL'] . '/payment-portal-requests')->toArray();
?>

<div class="row mt-5">
    <div class="col-md-6 col-lg-3 d-flex">
        <div class="card item-card flex-fill">
            <div class="overlay-box">
                <i class="fa-solid fa-chart-line icon-card"></i>
            </div>
            <div class="card-body">
                <p>Payment Requests</p>
                <h1><?= count($paymentRequests) ?></h1>
            </div>
        </div>
    </div>
</div>


<div id="page-table">
    <div class="row g-2 mb-5">
        <div class="col-md-12">
            <h5 class="table-title">Payment Requests</h5>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="payment-requests-table">
                            <thead>
                                <tr>
                                    <th scope="col">TXN #</th>
                                    <th scope="col">REF #</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Reason</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Slip</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($paymentRequests as $request) {
                                ?>
                                    <tr>
                                        <td><?= $request['id'] ?></td>
                                        <td><?= $request['unique_number'] ?></td>
                                        <td><?= $request['number_type'] ?></td>
                                        <td><?= $request['payment_reson'] ?></td>
                                        <td><?= $request['paid_amount'] ?></td>
                                        <td>
                                            <a style="color: white !important;" class="btn btn-dark btn-sm"
                                                href="http://content-provider.pharmacollege.lk<?= $request['slip_path'] ?>"
                                                download target="_blank">
                                                <i class="fa fa-download" aria-hidden="true"></i>

                                            </a>
                                        </td>

                                        <td><?= $request['paid_date'] ?></td>
                                        <td> <span
                                                class="badge <?= getBadgeClassByStatus($request['payment_status']) ?>"><?= ucfirst($request['payment_status']) ?></span>
                                        </td>
                                        <td>
                                            <button type="button" onclick="OpenPayment('<?= $request['id'] ?>')"
                                                class="btn btn-dark btn-sm">
                                                <i class="fa-solid fa-credit-card me-1"></i> Payment
                                            </button>
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('#payment-requests-table').dataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf'
            // 'colvis'
        ],
        order: [
            [0, 'asc']
        ]
    })
</script>