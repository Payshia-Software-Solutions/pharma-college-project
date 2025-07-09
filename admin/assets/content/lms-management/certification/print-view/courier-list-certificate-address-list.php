<?php

set_time_limit(300);
require __DIR__ . '/../../../../../vendor/autoload.php';

use Dotenv\Dotenv;
use Symfony\Component\HttpClient\HttpClient;

$dotenv = Dotenv::createImmutable(dirname(__DIR__, 5))->load();
$client = HttpClient::create();

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('../../../../../include/config.php');

$courseCode = isset($_GET['courseCode']) ? $_GET['courseCode'] : 1;
$courseName = ($courseCode == 1)
    ? "Certificate Course in Pharmacy Practice"
    : "Advanced Course in Pharmacy Practice";

$response = $client->request(
    'GET',
    $_ENV['SERVER_URL'] . '/certificate-orders/'
);

$packageBookings = $response->toArray();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?= $courseName ?> - Courier Address Labels</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        @page {
            margin: 10mm;
        }

        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            margin: 20px 0;
        }

        .page {
            display: flex;
            flex-wrap: wrap;
            page-break-after: always;
            justify-content: space-between;
            padding: 0 10mm;
            box-sizing: border-box;
        }

        .label-box {
            width: calc(100%);
            height: 190px;
            border: 1px dashed #000;
            padding: 10px;
            margin-bottom: 10px;
            box-sizing: border-box;
            page-break-inside: avoid;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .address-row {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            height: 100%;
        }

        .from-address,
        .to-address {
            width: 50%;
            font-size: 13px;
            line-height: 1.4;
            box-sizing: border-box;
        }

        .from-address {
            border-right: 1px solid #ccc;
            padding-right: 10px;
        }

        .to-address {
            padding-left: 10px;
        }

        .to-address strong {
            display: block;
            margin-bottom: 5px;
            font-size: 15px;
        }

        .to-address p {
            margin: 2px 0;
        }

        @media print {
            body {
                margin: 0;
            }

            .label-box {
                break-inside: avoid;
            }

            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>

    <?php
    $chunked = array_chunk($packageBookings, 10); // 10 labels per page
    foreach ($chunked as $pageSet) {
        echo '<div class="page">';
        foreach ($pageSet as $booking) {
            $fullAddress = $booking['address_line1'];
            if (!empty($booking['address_line2'])) {
                $fullAddress .= ', ' . $booking['address_line2'];
            }

            $certificates = [];

            if (!empty($booking['certificate_id']) && $booking['certificate_id'] !== '0') {
                $certificates[] = htmlspecialchars($booking['certificate_id']);
            }

            if (!empty($booking['advanced_id']) && $booking['advanced_id'] !== '0') {
                $certificates[] = htmlspecialchars($booking['advanced_id']);
            }
    ?>
            <div class="label-box">
                <div class="address-row">
                    <div class="from-address">
                        <strong>From:</strong>
                        <p><strong>Ceylon Pharma College (PVT) LTD</strong></p>
                        <p>Midigahamulla,</p>
                        <p>Pelmadulla</p>
                        <p>0715 884 884</p>
                    </div>
                    <div class="to-address">
                        <strong><?= htmlspecialchars($booking['name_on_certificate']) ?></strong>
                        <p><?= htmlspecialchars($fullAddress) ?></p>
                        <p><?= htmlspecialchars($booking['city_id']) ?>, <?= htmlspecialchars($booking['district']) ?></p>
                        <p>Mobile: <?= htmlspecialchars($booking['mobile']) ?></p>
                        <?php if (!empty($booking['telephone_1'])): ?>
                            <p>Tel: <?= htmlspecialchars($booking['telephone_1']) ?></p>
                        <?php endif; ?>
                        <p>Ref #: <?= htmlspecialchars($booking['id']) ?></p>
                        <p>Certificate ID<?= count($certificates) > 1 ? 's' : '' ?>: <?= implode(', ', $certificates) ?></p>
                    </div>
                </div>
            </div>
    <?php
        }
        echo '</div>'; // end .page
    }
    ?>

</body>

</html>