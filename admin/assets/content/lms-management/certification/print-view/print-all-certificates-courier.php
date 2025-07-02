<?php
set_time_limit(300);
require __DIR__ . '/../../../../../vendor/autoload.php';
define('PARENT_SEAT_RATE', 500);

// For use env file data & HTTP client
use Dotenv\Dotenv;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

$dotenv = Dotenv::createImmutable(dirname(__DIR__, 5))->load();
$client = HttpClient::create();

error_reporting(E_ALL); // Report all types of errors
ini_set('display_errors', 1); // Display errors on screen

require_once('../../../../../include/config.php');
include '../../../../../include/function-update.php';
include '../../../../../include/lms-functions.php';
require_once('../../../../../vendor/phpqrcode/qrlib.php');

$courseCode = 1;
if ($courseCode == 1) {
    $courseName = "Certificate Course in Pharmacy Practice";
} else {
    $courseName = "Advanced Course in Pharmacy Practice";
}

$coureirList = $client->request('GET', $_ENV['SERVER_URL'] . '/certificate-orders')->toArray();

?>
<title><?= $courseName ?> Print Session <?= $showSession ?></title>

<style>
    @import url('https://fonts.cdnfonts.com/css/chaparral-pro?styles=15266');
    @import url(https://db.onlinewebfonts.com/c/5c0d13eb3af810e996bce6c3482f881c?family=Chaparral+Pro+Bold+Italic);

    /* 
        font-family: 'Courier Prime', monospace;
        font-family: 'IBM Plex Mono', monospace;
    */

    * {
        padding: 0px !important;
        margin: 0px !important;
    }

    .certificate-container {
        position: relative;
        width: 210mm;
        height: 297mm;
        /* A4 full height */
        page-break-inside: avoid;
        padding: 0;
        margin: 0;
        overflow: hidden;
    }


    .back-image {
        width: 210mm;
        height: 209.8mm;
    }

    .name-box {
        padding-left: 0mm !important;
    }

    .pv-number {
        position: absolute;
        left: <?= 210 - 30 ?>mm;
        top: 5mm
    }

    .certificate-user {
        font-family: "Chaparral Pro Bold Italic";
        width: calc(210mm - 100px);
        font-size: 35px;
        /*text-align: center !important;*/
        font-weight: 800 !important;
        position: absolute;
        top: 0 !important;
    }

    .qr-code {
        left: 12mm !important;
        top: 246mm !important;
        position: absolute;
        width: 20mm !important;
    }

    .sign {
        left: 150mm !important;
        top: 253mm !important;
        position: absolute;
        width: 40mm !important;
    }

    .sign-dot {
        left: 150mm !important;
        top: 260mm !important;
        position: absolute;
        width: 40mm !important;
    }

    .director {
        left: 163mm !important;
        top: 265mm !important;
        position: absolute;
        width: 40mm !important;
    }

    .print-date {
        left: 12mm !important;
        top: 268mm !important;
        position: absolute;
        font-family: 'Courier Prime', monospace;
    }

    .print-number {
        left: 12mm !important;
        top: 272mm !important;
        position: absolute;
        font-family: 'Courier Prime', monospace;
    }

    .certificate-number {
        left: 12mm !important;
        top: 276mm !important;
        position: absolute;
        font-family: 'Courier Prime', monospace;

    }

    .pv-number2 {
        left: 180mm !important;
        top: 286mm !important;
        position: absolute;
        font-family: 'Courier Prime', monospace;
    }

    .page-break {
        page-break-after: always;
    }
</style>

<link
    href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Roboto:wght@400;500;700&display=swap"
    rel="stylesheet">

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Poppins', sans-serif;
    }

    .certificate {
        /* background-image: url('cer.jpeg'); */
        width: 210mm;
        height: 297mm;
        display: flex;
        /* border: 1px solid black; */
        flex-direction: column;
        align-items: center;
        text-align: center;
        page-break-inside: avoid;
    }

    .certificate-title {
        position: absolute;
        font-size: 25px;
        font-weight: bold;
        color: #333;
        top: 90mm;
        letter-spacing: 1px;
    }

    .awarded-to {
        position: absolute;
        font-size: 20px;
        font-family: 'Roboto', sans-serif;
        color: #333;
        top: 110mm;
    }

    .recipient-line {
        position: absolute;
        width: 120mm;
        height: 1px;
        top: 119mm;
        font-weight: 900;
        font-size: 25px;
    }

    .recognition-text {
        position: absolute;
        font-size: 20px;
        font-family: 'Roboto', sans-serif;
        color: #333;
        top: 132mm;
        line-height: 1.3;
    }

    .course-line {
        position: absolute;
        width: 150mm;
        height: 1px;
        top: 150mm;
        font-weight: 900;
        font-size: 20px;
    }

    .offered-by {
        position: absolute;
        font-size: 20px;
        color: #333;
        top: 160mm;
    }

    .institution {
        position: absolute;
        font-size: 20px;
        font-weight: bold;
        color: #333;
        top: 168mm;
    }

    .ceremony-details {
        position: absolute;
        font-size: 16px;
        color: #333;
        line-height: 1.4;
        top: 176mm;
    }

    @media print {
        body {
            margin: 0;
            padding: 0;
            background: white;
        }

        .certificate {
            background: white;
            margin: 0;
            box-shadow: none;
        }
    }
</style>
<?php

$count = 1;
foreach ($coureirList as $booking) {
    // break;
    $s_user_name = $booking['created_by'];
    // $CourseCode = 1;

    $batchStudents =  GetLmsStudents();
    $studentDetailsArray = $batchStudents[$s_user_name];
    $PrintDate = date("Y-m-d H:i:s");

    $certificateId = $batchCode = "";

    // $certificateId = ($courseCode == 1) ? $booking['certificate_id'] : $booking['advanced_id'];
    // $certificateInfo = CertificatePrintStatusByCertificateId($certificateId);
    // var_dump($certificateInfo);

    // $certificateEntryResult = EnterCertificateEntry($printDate, 1, $loggedUser, 'Workshop-Certificate', $s_user_name, $CourseCode);
    // var_dump($certificateEntryResult);

    // Include the qrlib file 
    // if (empty($certificateId)) {
    //     $certificateInfo = CertificatePrintStatusByParentCourse($courseCode, 'Certificate', $s_user_name);
    //     // var_dump($certificateInfo);
    //     $certificateId = $certificateInfo[$s_user_name]['certificate_id'];
    //     $batchCode = $certificateInfo[$s_user_name]['course_code'];
    // } else {
    //     $batchCode = $certificateInfo[0]['course_code'];
    // }

    $text = "https://pharmacollege.lk/result-view.php?CourseCode=" . $batchCode . "&LoggedUser=" . $s_user_name;
    $ecc = 'L';
    $pixel_Size = 10;
    $frame_Size = 0;

    // Generate the QR code image
    ob_start();
    QRcode::png($text, null, QR_ECLEVEL_L, 10, 0);
    $image_data = ob_get_contents();
    ob_end_clean();
?>



    <div class="certificate-container">
        <div class="certificate">
            <h1 class="certificate-title">CERTIFICATE OF COMPLETION</h1>

            <p class="awarded-to">This certificate is awarded to</p>
            <div class="recipient-line"><?= $studentDetailsArray['name_on_certificate'] ?></div>

            <div class="recognition-text">
                in recognition of the<br>
                successful completion of the
            </div>
            <div class="course-line"><?= $courseName ?></div>

            <p class="offered-by">offered by</p>
            <div class="institution">Ceylon Pharma College</div>
            <div class="ceremony-details">
                The certificate award ceremony was held at the<br>
                BMICH, Colombo, Sri Lanka.
            </div>
        </div>

        <img class="qr-code" src="data:image/png;base64,<?= base64_encode($image_data) ?>">
        <?php
        if ($courseCode == 2) { ?>
            <img class="sign" src="sign.png" alt="">
            <div>
            </div>
            <p class="sign-dot">...................................................</p>
            <p class="director">Director</p>
        <?php } ?>
        <p class="print-date">Date: <?= date("F j, Y", strtotime("2025-06-30")) ?></p>
        <p class="print-number">Index Number:<?= $s_user_name ?></p>
        <p class="certificate-number">Certificate
            ID:<?= $certificateId ?></p>
        <p class="pv-number2">PV00253555</p>
    </div>
<?php
    $count++;
    if ($count == 10) {
        // break;
    }
    // Add a page break after each certificate except the last one
    if ($coureirList !== end($coureirList)) {
        echo '<div style="page-break-after: always;"></div>';
    }
}
?>