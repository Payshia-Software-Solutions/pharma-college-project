<?php
// Include required files
require_once('../../../../include/config.php');
include '../../../../include/function-update.php';
include '../../../../include/lms-functions.php';
require __DIR__ . '/../../../../vendor/autoload.php';

// For use env file data
use Dotenv\Dotenv;
use Mpdf\Tag\Br;
use Symfony\Component\HttpClient\HttpClient;

// Load environment variables
$dotenv = Dotenv::createImmutable(dirname(__DIR__, 4)); // Go up 5 directories
$dotenv->load();

// Initialize HTTP client
$client = HttpClient::create();

$userThemeInput = isset($_POST['userTheme']) ? $_POST['userTheme'] : null;
$userTheme = getUserTheme($userThemeInput);

$selectedUsername = $_POST['selectedUsername'];


//get delivery details
$responseForDeliveryOrder = $client->request('GET', $_ENV["SERVER_URL"] . '/delivery-orders/' . $selectedUsername . '/');
$deliveryOrders = $responseForDeliveryOrder->toArray();


$responseForCertificateOrder = $client->request('GET', $_ENV["SERVER_URL"] . '/cc_certificate_order/' . $selectedUsername . '/');
$certificateOrders = $responseForCertificateOrder->toArray();
//print_r($certificateOrders);
// print_r($certificateOrders['course_code']);

?>

<div class="loading-popup-content-right <?= htmlspecialchars($userTheme) ?>">
    <div class="index-content">
        <div class="text-end">
            <button class="btn btn-dark " onclick="ClosePopUPRight(1)" type="button"><i class="fa solid fa-xmark"></i> close</button>
        </div>
        <!-- Certificate Orders Table -->
        <div class="row mt-3">
            <div class="card-body">
                <div class="col-12 mb-3">
                    <h5 class="table-title">Certificate Orders</h5>
                </div>
                <?php if (!empty($certificateOrders)) { ?>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Certificate</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $ordersList = isset($certificateOrders[0]) ? $certificateOrders : [$certificateOrders];
                            foreach ($ordersList as $orders) {
                                if (is_array($orders)) {
                                    $responseForCertificate = $client->request('GET', $_ENV["SERVER_URL"] . '/cc_certificate_list/' . $orders['certificate_id'] . '/');
                                    $certificateList = $responseForCertificate->toArray();
                                    $certificateStatus = htmlspecialchars($orders['certificate_status'] ?? 'Pending');
                            ?>
                                    <tr>
                                        <td><?= htmlspecialchars($certificateList['list_name']) ?></td>
                                        <td>
                                            <span class="<?= $certificateStatus === 'Printed' ? 'badge bg-primary text-white' : 'badge bg-danger text-white' ?>">
                                                <?= $certificateStatus ?>
                                            </span>
                                        </td>
                                    </tr>
                            <?php
                                } else {
                                    echo "<tr><td colspan='2' class='text-danger'>Invalid data format for certificate order.</td></tr>";
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                <?php } else { ?>
                    <p class="text-center">No Certificate Orders.</p>
                <?php } ?>
            </div>
        </div>

        <!-- Delivery Orders Table -->
        <div class="row mt-3">
            <div class="card-body">
                <div class="col-12 mb-3">
                    <h5 class="table-title">Delivery Orders</h5>
                </div>
                <?php if (!empty($deliveryOrders)) { ?>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Tracking Number</th>
                                <th>Order Date</th>
                                <th>Packed Date</th>
                                <th>Send Date</th>
                                <th>Current Status</th>
                                <th>Delivery Partner</th>
                                <th>Value</th>
                                <th>Payment Method</th>
                                <th>Course Code</th>
                                <th>Estimate Delivery</th>
                                <th>Full Name</th>
                                <th>Street Address</th>
                                <th>City</th>
                                <th>District</th>
                                <th>Phone 1</th>
                                <th>Phone 2</th>
                                <th>Received Date</th>
                                <th>COD Amount</th>
                                <th>Package Weight</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($deliveryOrders as $delivery) { ?>
                                <tr>
                                    <td><?= htmlspecialchars($delivery['tracking_number']) ?></td>
                                    <td><?= htmlspecialchars($delivery['order_date']) ?></td>
                                    <td><?= htmlspecialchars($delivery['packed_date']) ?></td>
                                    <td><?= htmlspecialchars($delivery['send_date']) ?></td>
                                    <td><?= htmlspecialchars($delivery['current_status']) ?></td>
                                    <td><?= htmlspecialchars($delivery['delivery_partner']) ?></td>
                                    <td>Rs. <?= number_format($delivery['value'], 2) ?></td>
                                    <td><?= htmlspecialchars($delivery['payment_method']) ?></td>
                                    <td><?= htmlspecialchars($delivery['course_code']) ?></td>
                                    <td><?= htmlspecialchars($delivery['estimate_delivery']) ?></td>
                                    <td><?= htmlspecialchars($delivery['full_name']) ?></td>
                                    <td><?= htmlspecialchars($delivery['street_address']) ?></td>
                                    <td><?= htmlspecialchars($delivery['city']) ?></td>
                                    <td><?= htmlspecialchars($delivery['district']) ?></td>
                                    <td><?= htmlspecialchars($delivery['phone_1']) ?></td>
                                    <td><?= htmlspecialchars($delivery['phone_2']) ?></td>
                                    <td><?= htmlspecialchars($delivery['received_date']) ?></td>
                                    <td>Rs. <?= number_format($delivery['cod_amount'], 2) ?></td>
                                    <td><?= htmlspecialchars($delivery['package_weight']) ?> kg</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                <?php } else { ?>
                    <p class="text-center">No Delivery Orders.</p>
                <?php } ?>
            </div>
        </div>

    </div>
</div>