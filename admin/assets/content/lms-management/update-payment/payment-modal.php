<?php
require __DIR__ . '/../../../../vendor/autoload.php';
include '../../../../include/function-update.php';

// Get User Theme
$userThemeInput = isset($_POST['userTheme']) ? $_POST['userTheme'] : null;
$userTheme = getUserTheme($userThemeInput);


define('PARENT_SEAT_RATE', 500); // example value
// For use env file data
use Dotenv\Dotenv;
use Symfony\Component\HttpClient\HttpClient;

// Load environment variables
$dotenv = Dotenv::createImmutable(dirname(__DIR__, 4))->load();

// Initialize HTTP client
$client = HttpClient::create();
$txnNumber = $_POST['txnNumber'];


// Get Payment Requests
$paymentRequest = $client->request('GET', $_ENV['SERVER_URL'] . '/payment-portal-requests/' . $txnNumber)->toArray();
$checkHashInfo = $client->request('GET', $_ENV['SERVER_URL'] . '/payment-portal-requests/check-hash?hashValue=' . $paymentRequest['hash_value'])->toArray();

?>
<div class="loading-popup-content-right <?= htmlspecialchars($userTheme) ?>">
    <div class="row">
        <div class="col-6">
            <h3 class="mb-0">Payment Request Info</h3>
        </div>

        <div class="col-6 text-end">
            <button class="btn btn-warning btn-sm" onclick="OpenPayment('<?= $txnNumber ?>')" type="button"><i
                    class="fa solid fa-refresh"></i> Reload</button>
            <button class="btn btn-light btn-sm" onclick="ClosePopUPRight(0)" type="button"><i
                    class="fa solid fa-xmark"></i> Cancel</button>
        </div>

        <div class="col-12">
            <div class="border-bottom border-5 my-2"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="row g-2">

                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <p class="mb-0">TXN #</p>
                            <h5 class="mb-0"><?= $paymentRequest['id'] ?></h5>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <p class="mb-0">Ref # (<?= $paymentRequest['number_type'] ?>)</p>
                            <h5 class="mb-0"><?= $paymentRequest['unique_number'] ?></h5>
                        </div>
                    </div>
                </div>

                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <p class="mb-0">Reason</p>
                            <h5 class="mb-0"><?= $paymentRequest['payment_reson'] ?></h5>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <p class="mb-0">Paid Date</p>
                            <h5 class="mb-0"><?= $paymentRequest['paid_date'] ?></h5>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <p class="mb-0">Payment Status</p>
                            <span
                                class="badge <?= getBadgeClassByStatus($paymentRequest['payment_status']) ?>"><?= ucfirst($paymentRequest['payment_status']) ?></span>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="text-end mb-2">
                        <a style="color: white !important;" class="btn btn-dark btn-sm"
                            href="http://content-provider.pharmacollege.lk<?= $paymentRequest['slip_path'] ?>" download
                            target="_blank">
                            <i class="fa fa-download" aria-hidden="true"></i> Download Slip
                        </a>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="border-bottom pb-2">Payment Record</h5>
                            <div class="row g-2">
                                <div class="col-4">
                                    <p class="mb-0">Paid Amount</p>
                                    <h5 class="mb-0"><?= $paymentRequest['paid_amount'] ?></h5>
                                </div>
                                <div class="col-8">
                                    <p class="mb-0">Bank : <?= $paymentRequest['bank'] ?></p>
                                    <p class="mb-0">Branch : <?= $paymentRequest['branch'] ?></p>
                                    <p class="mb-0">Reference : <?= $paymentRequest['payment_reference'] ?></p>
                                </div>

                            </div>

                            <?php if (count($checkHashInfo) > 1) : ?>
                                <div class="row g-2">
                                    <div class="col-12">
                                        <h5 class="table-title">Slip Dupplicate Status</h5>
                                    </div>
                                    <?php foreach ($checkHashInfo as $hashRecord) {
                                    ?>
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-body">
                                                    <p class="mb-0"><?= $hashRecord['unique_number'] ?></p>
                                                    <a target="_blank" class="btn btn-dark btn-sm text-light"
                                                        href="https://content-provider.pharmacollege.lk<?= $hashRecord['slip_path'] ?>">Download
                                                        Slip</a>
                                                </div>
                                            </div>

                                        </div>
                                    <?php
                                    }
                                    ?>

                                </div>

                            <?php else : ?>
                                <h6 class="mt-2">No Dupplicate Receipts</h6>
                            <?php endif ?>
                        </div>
                    </div>



                </div>

            </div>
        </div>
        <div class="col-md-4">

            <?php
            $filePath = $paymentRequest['slip_path'];
            $fullUrl = "https://content-provider.pharmacollege.lk" . $filePath;
            $fileExtension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

            if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                // Show image
                echo '<img class="w-100" src="' . $fullUrl . '" alt="Payment Sip">';
            } elseif ($fileExtension === 'pdf') {
                // Show link to PDF
                echo '<a href="' . $fullUrl . '" target="_blank" class="btn btn-primary">View PDF Receipt</a>';
            } else {
                // Optional: Handle unsupported file types
                echo '<p>Unsupported file type.</p>';
            }
            ?>
        </div>
        <div class="col-md-4"></div>
    </div>


</div>