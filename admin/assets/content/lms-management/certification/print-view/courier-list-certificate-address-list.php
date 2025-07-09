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
        }

        .label-box {
            width: calc(50% - 10px);
            /* 2 columns per row */
            height: 48%;
            /* Fit 2 rows per page */
            border: 1px dashed #000;
            padding: 10px;
            margin-bottom: 10px;
            box-sizing: border-box;
            page-break-inside: avoid;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .label-box strong {
            display: block;
            margin-bottom: 5px;
            font-size: 16px;
        }

        .label-box p {
            margin: 2px 0;
            font-size: 13px;
            line-height: 1.4;
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

    <h1><?= $courseName ?> - Courier Address Labels</h1>

    <?php
    $chunked = array_chunk($packageBookings, 8); // 8 boxes per page
    foreach ($chunked as $pageSet) {
        echo '<div class="page">';
        foreach ($pageSet as $booking) {
            $fullAddress = $booking['address_line1'];
            if (!empty($booking['address_line2'])) {
                $fullAddress .= ', ' . $booking['address_line2'];
            }
    ?>
            <div class="label-box">
                <strong><?= htmlspecialchars($booking['name_on_certificate']) ?></strong>
                <p><?= htmlspecialchars($fullAddress) ?></p>
                <p><?= htmlspecialchars($booking['city_id']) ?>, <?= htmlspecialchars($booking['district']) ?></p>
                <p>Mobile: <?= htmlspecialchars($booking['mobile']) ?></p>
                <?php if (!empty($booking['telephone_1'])): ?>
                    <p>Tel: <?= htmlspecialchars($booking['telephone_1']) ?></p>
                <?php endif; ?>
                <p>Ref #: <?= htmlspecialchars($booking['id']) ?></p>
                <p>Certificate ID: <?= htmlspecialchars($booking['certificate_id']) ?></p>
            </div>
    <?php
        }
        echo '</div>'; // end .page
    }
    ?>


</body>

</html>