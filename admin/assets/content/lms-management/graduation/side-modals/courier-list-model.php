<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require __DIR__ . '/../../../../../vendor/autoload.php';
include '../../../../../include/function-update.php';

use Dotenv\Dotenv;
use Symfony\Component\HttpClient\HttpClient;

$dotenv = Dotenv::createImmutable(dirname(__DIR__, 5));
$dotenv->load();

$client = HttpClient::create();

$userThemeInput = $_POST['userTheme'] ?? null;
$courierOrderId = $_POST['courierOrderId'] ?? null;
$userTheme = getUserTheme($userThemeInput);

if (!$courierOrderId) {
    echo "<div class='alert alert-danger'>Invalid request: Missing courierOrderId</div>";
    exit;
}

$response = $client->request('GET', $_ENV['SERVER_URL'] . '/certificate-orders/' . $courierOrderId);
$orderData = $response->toArray();

$courseResponse = $client->request('GET', $_ENV['SERVER_URL'] . '/parent-main-course');
$courseList = $courseResponse->toArray();

$courseName = 'Unknown';
if (!empty($orderData['course_code'])) {
    foreach ($courseList as $course) {
        if (isset($course['course_code']) && $course['course_code'] === $orderData['course_code']) {
            $courseName = $course['course_name'];
            break;
        }
    }
}
?>

<div class="loading-popup-content-right <?= htmlspecialchars($userTheme) ?>">
    <div class="row mb-3">
        <div class="col-6">
            <h3 class="mb-0">Courier Order Info</h3>
        </div>
        <div class="col-6 text-end">
            <button class="btn btn-warning btn-sm" onclick="OpenCourierListModel('<?= $courierOrderId ?>')">
                <i class="fa solid fa-refresh"></i> Reload
            </button>
            <button class="btn btn-light btn-sm" onclick="ClosePopUPRight(0)">
                <i class="fa solid fa-xmark"></i> Cancel
            </button>
        </div>
    </div>

    <div class="row g-3">
        <!-- Order Info Section -->
        <div class="col-12">
            <h5 class="border-bottom pb-1">Order Details</h5>
        </div>

        <?php
        $fields = [
            ['label' => 'Order ID', 'value' => $orderData['id']],
            ['label' => 'Created By', 'value' => htmlspecialchars($orderData['created_by'])],
            ['label' => 'Created At', 'value' => $orderData['created_at']],
            ['label' => 'Course Name', 'value' => htmlspecialchars($courseName)],
            ['label' => 'Mobile', 'value' => htmlspecialchars($orderData['mobile'])],
        ];

        foreach ($fields as $field) {
            echo "
            <div class='col-md-4'>
                <div class='card h-100'>
                    <div class='card-body'>
                        <p class='mb-1 text-muted'>{$field['label']}</p>
                        <h5 class='mb-0'>{$field['value']}</h5>
                    </div>
                </div>
            </div>";
        }
        ?>

        <!-- Address -->
        <div class="col-12 col-md-8">
            <div class="card h-100">
                <div class="card-body">
                    <p class="mb-1 text-muted">Address</p>
                    <h5 class="mb-0"><?= htmlspecialchars($orderData['address_line1']) ?>,
                        <?= htmlspecialchars($orderData['address_line2']) ?>
                    </h5>
                    <h6 class="text-muted mt-1"><?= htmlspecialchars($orderData['city_id']) ?></h6>
                </div>
            </div>
        </div>

        <!-- Payment Info -->
        <div class="col-12 mt-4">
            <h5 class="border-bottom pb-1">Payment Info</h5>
        </div>

        <?php
        $payments = [
            ['label' => 'Payment', 'value' => number_format($orderData['payment'], 2)],
            ['label' => 'COD Amount', 'value' => number_format($orderData['cod_amount'], 2)],
        ];

        foreach ($payments as $payment) {
            echo "
            <div class='col-md-3'>
                <div class='card h-100'>
                    <div class='card-body'>
                        <p class='mb-1 text-muted'>{$payment['label']}</p>
                        <h5 class='mb-0'>{$payment['value']}</h5>
                    </div>
                </div>
            </div>";
        }
        ?>

        <!-- Status and IDs -->
        <div class="col-12 mt-4">
            <h5 class="border-bottom pb-1">Tracking & Status</h5>
        </div>

        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <p class="mb-1 text-muted">Certificate Status</p>
                    <h5 class="mb-0">
                        <span class="badge 
                            <?= $orderData['certificate_status'] === 'Pending' ? 'bg-warning text-dark' :
                                ($orderData['certificate_status'] === 'Delivered' ? 'bg-success' : 'bg-secondary') ?>">
                            <?= htmlspecialchars($orderData['certificate_status']) ?>
                        </span>
                    </h5>
                </div>
            </div>
        </div>

        <?php
        $ids = [
            ['label' => 'Package ID', 'value' => htmlspecialchars($orderData['package_id'])],
            ['label' => 'Certificate ID', 'value' => htmlspecialchars($orderData['certificate_id'])],
        ];

        foreach ($ids as $id) {
            echo "
            <div class='col-md-4'>
                <div class='card h-100'>
                    <div class='card-body'>
                        <p class='mb-1 text-muted'>{$id['label']}</p>
                        <h5 class='mb-0'>{$id['value']}</h5>
                    </div>
                </div>
            </div>";
        }
        ?>
    </div>
</div>