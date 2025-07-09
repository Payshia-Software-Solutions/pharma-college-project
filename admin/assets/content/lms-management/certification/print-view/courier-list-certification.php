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

$courseCode = isset($_GET['courseCode']) ? $_GET['courseCode'] : null;
$tableMode = isset($_GET['tableMode']) ? $_GET['tableMode'] : 1;
// echo $tableMode;

if ($courseCode == 1) {
    $courseName = "Certificate Course in Pharmacy Practice";
} else {
    $courseName = "Advanced Course in Pharmacy Practice";
}

if (isset($courseCode)) {
    $packageBookings = $client->request(
        'GET',
        $_ENV['SERVER_URL'] . '/certificate-orders'
    )->toArray();
}
?>
<!DOCTYPE html>
<title><?= $courseName ?> Print Session <?= $showSession ?></title>
<link
    href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Roboto:wght@400;500;700&display=swap"
    rel="stylesheet">
<link rel="stylesheet" href="cerificate-styles.css">

<?php if ($tableMode == 1) { ?>
    <?= $courseName ?>
    <table border="1" cellspacing="0">
        <tr>
            <th>#</th>
            <th style="padding: 10px;">Name on Certificate</th>
            <th>batchCode</th>
            <th style="padding: 10px;">Certificate ID</th>
            <th style="padding: 10px;">Username</th>
        </tr>
    <?php } ?>
    <?php
    $count = 1;
    foreach ($packageBookings as $booking) {
        // break;
        $s_user_name = $booking['created_by'];

        $batchStudents =  GetLmsStudents();
        $studentDetailsArray = $batchStudents[$s_user_name];

        $certificateId = ($courseCode == 1) ? $booking['certificate_id'] : $booking['advanced_id'];
        $certificateInfo = CertificatePrintStatusByCertificateId($certificateId);
        // var_dump($certificateInfo);

        $PrintDate = date("Y-m-d H:i:s");
        // $certificateEntryResult = EnterCertificateEntry($printDate, 1, $loggedUser, 'Workshop-Certificate', $s_user_name, $CourseCode);
        // var_dump($certificateEntryResult);

        // Include the qrlib file 
        if (empty($certificateId)) {
            $certificateInfo = CertificatePrintStatusByParentCourse($courseCode, 'Certificate', $s_user_name);
            var_dump($certificateInfo);
            // var_dump($certificateInfo);
            $certificateId = $certificateInfo[$s_user_name]['certificate_id'];
            $batchCode = $certificateInfo[$s_user_name]['course_code'];
        } else {
            $batchCode = $certificateInfo[0]['course_code'];
        }
        $batchCode = 1;

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

        <?php if ($tableMode == 1) { ?>

            <tr>
                <td><?= $count++ ?></td>
                <td style="padding: 10px;"><?= $studentDetailsArray['name_on_certificate'] ?></td>
                <td><?= $batchCode ?></td>
                <td style="padding: 10px;"><?= $certificateId ?></td>
                <td style="padding: 10px;"><?= $s_user_name ?></td>
            </tr>
        <?php } else { ?>
            <div class="certificate-container d-none">
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
        <?php } ?>

        <?php
        if ($count == 8) {
            break;
        }
        // Add a page break after each certificate except the last one
        if ($packageBookings !== end($packageBookings)) {
            echo '<div style="page-break-after: always;"></div>';
        }
    }
    if ($tableMode == 1) { ?>
    </table>
<?php }  ?>