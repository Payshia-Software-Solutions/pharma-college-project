<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include '../../../../include/function-update.php';
require __DIR__ . '/../../../../vendor/autoload.php';

use Dotenv\Dotenv;
use Symfony\Component\HttpClient\HttpClient;

// Load environment variables
$dotenv = Dotenv::createImmutable(dirname(__DIR__, 4));
$dotenv->load();

// Initialize HTTP client
$client = HttpClient::create();

// Fetch courier orders
$response = $client->request('GET', $_ENV['SERVER_URL'] . '/certificate-orders');
$courierOrders = $response->toArray();
?>

<div class="row mb-5">
    <div class="col-md-12">
        <h5 class="table-title">Courier Orders List</h5>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="courier-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Student Number</th>
                                <th>Course Code</th>
                                <th>Mobile</th>
                                <th>Status</th>
                                <th>COD Amount</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($courierOrders as $index => $order): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td><?= htmlspecialchars($order['created_by']) ?></td>
                                    <td><?= htmlspecialchars($order['course_code']) ?></td>
                                    <td><?= htmlspecialchars($order['mobile']) ?></td>
                                    <td>
                                        <span
                                            class="badge 
                                            <?= $order['certificate_status'] === 'Pending' ? 'bg-warning text-dark' :
                                                ($order['certificate_status'] === 'Delivered' ? 'bg-success' : 'bg-secondary') ?>">
                                            <?= htmlspecialchars($order['certificate_status']) ?>
                                        </span>
                                    </td>
                                    <td><?= number_format($order['cod_amount'], 2) ?></td>
                                    <td>
                                        <button type="button" class="btn btn-dark btn-sm"
                                            onclick="OpenCourierListModel('<?= $order['id'] ?>')">
                                            View
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- DataTables initialization -->
<script>
    $('#courier-table').dataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf'
        ],
        order: [[0, 'asc']]
    });
</script>