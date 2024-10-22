<?php
require_once '../../../../../vendor/autoload.php';

use Symfony\Component\HttpClient\HttpClient;

$dotenv = Dotenv\Dotenv::createImmutable('../../../../../');
$dotenv->load();

$courseCode = $_POST['courseCode'];

$client = HttpClient::create();
$response = $client->request('GET', $_ENV["SERVER_URL"] .'/payment-request/getByCourseCode/' . $courseCode);
$paymentRequests = $response->toArray();

?>

<div class="row g-3">
    <div class="col-12">
        <h5 class="table-title mb-4">course - 2002 |
            Winpharma Payments</h5>
        <div class="row g-2 mb-4">
            <div class="col-6 col-md-2">
                <div class="card bg-black text-white clickable"
                    onclick="GetWinpharmaSubmissions('default course', 'All')">

                    <div class="card-body">
                        <p class="mb-0 text-white">All</p>
                        <h1>5785</h1>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-2">
                <div class="card bg-warning text-white clickable"
                    onclick="GetWinpharmaSubmissions('default corese', 'Pending')">

                    <div class="card-body">
                        <p class="mb-0 text-white">Pending</p>
                        <h1>889</h1>
                    </div>
                </div>
            </div>



        </div>
        <div class="card shadow-lg">
            <div class="card-body">

                <?php if (!empty($paymentRequests)) : ?>

                <p class="mb-0 mt-2">No <?= count($paymentRequests) ?> payments found.</p>

                <div class="table-responsive">
                    <table class="table table-hovered table-striped" id="submission-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Student Name</th>
                                <th>Upload Date</th>
                                <th>Action</th>
                                <th>Reason</th>
                                <th>Status</th>
                                <th>Reference Number</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($paymentRequests as $paymentRequest) : ?>
                            <tr>
                                <td><?= $paymentRequest['id'] ?></td>
                                <td><?= $paymentRequest['created_by'] ?></td>
                                <td>2024-10-15</td>
                                <td>
                                    <button onclick="OpenPaymentView()" class="btn btn-primary btn-sm" type="button"><i
                                            class="fa-solid fa-eye"></i>
                                        View</button>

                                </td>
                                <td><?= $paymentRequest['reason'] ?></td>

                                <?php if($paymentRequest['status'] == 1) : ?>
                                <td><span class="badge bg-success">Approved</span></td>
                                <?php else : ?>
                                <td><span class="badge bg-warning">Pending</span></td>
                                <?php endif; ?>

                                <td><?= $paymentRequest['reference_number'] ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <?php else : ?>
                <p class="mb-0 mt-2">No payments found.</p>
                <?php endif; ?>

            </div>
        </div>
    </div>
</div>


<script>
$(document).ready(function() {
    $('#submission-table').DataTable({
        order: false,
        pageLength: 20
    });

});
</script>