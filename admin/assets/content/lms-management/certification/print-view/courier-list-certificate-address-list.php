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
        body {
            font-family: 'Poppins', sans-serif;
            margin: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 40px;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }

        .label-box {
            border: 2px dashed #333;
            padding: 15px;
            height: 200px;
            box-sizing: border-box;
        }

        .label-box strong {
            display: block;
            margin-bottom: 5px;
        }

        .label-box p {
            margin: 2px 0;
            line-height: 1.4;
            font-size: 14px;
        }
    </style>
</head>

<body>

    <h1><?= $courseName ?> - Courier Address Labels</h1>

    <div class="grid">
        <?php
        foreach ($packageBookings as $booking) {
            // Optional filter by courseCode
            // if ($booking['course_code'] != $courseCode) continue;

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
        <?php } ?>
    </div>

</body>

</html>