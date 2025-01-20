<?php
// Include required files
require_once('../../../../include/config.php');
include '../../../../include/function-update.php';
include '../../../../include/lms-functions.php';
require __DIR__ . '/../../../../vendor/autoload.php';

use Dotenv\Dotenv;
use Symfony\Component\HttpClient\HttpClient;

// Load environment variables
$dotenv = Dotenv::createImmutable(dirname(__DIR__, 4));
$dotenv->load();

// Initialize HTTP client
$client = HttpClient::create();

$userThemeInput = isset($_POST['userTheme']) ? $_POST['userTheme'] : null;
$userTheme = getUserTheme($userThemeInput);

// Retrieve selected username from POST data
$selectedUsername = $_POST['selectedUsername'] ?? null;

if (!$selectedUsername) {
    echo '<div class="alert alert-danger">No username selected.</div>';
    exit;
}


$studentPayment = $client->request('GET', $_ENV["SERVER_URL"] . '/student-payment/' . $selectedUsername . '/');
$payments = $studentPayment->toArray();



?>
<div class="loading-popup-content-right <?= htmlspecialchars($userTheme) ?>">
    <div class="text-end">
        <button class="btn btn-dark" onclick="ClosePopUPRight(1)" type="button"><i class="fa solid fa-xmark"></i> Close</button>
    </div>
    <div class="index-content">
        <div class="card-body">
            <div class="col-12 mb-5">
                <h5 class="table-title">Payment History</h5>
            </div>
            <div class="row">
                <div class="col-12">
                    <?php if (!empty($payments)) : ?>
                        <table class="table">
                            <thead class="table-light">
                                <tr>
                                    <th class="fw-bold text-muted">Paid Amount</th>
                                    <th class="fw-bold text-muted">Discount</th>
                                    <th class="text-muted">Receipt No</th>
                                    <th class="text-muted">Payment Type</th>
                                    <th class="text-muted">Course</th>
                                    <th class="text-muted">Date</th>
                                </tr>
                            </thead>
                            <tbody class="border-bottom">
                                <?php foreach ($payments as $payment) :
                                    $dateTime = new DateTime($payment['created_at']);
                                    $formattedDate = $dateTime->format('Y-m-d H:i');
                                    $batchName = $payment['course_code'];
                                ?>
                                    <tr>
                                        <td>Rs. <?= number_format($payment['paid_amount'], 2) ?></td>
                                        <td>Rs. <?= number_format($payment['discount_amount'], 2) ?></td>
                                        <td><?= $payment['receipt_number'] ?></td>
                                        <td><?= $payment['payment_type'] ?></td>
                                        <td><?= $batchName ?></td>
                                        <td><?= $formattedDate ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else : ?>
                        <div class="text-center">
                            No payment history available for this user.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>