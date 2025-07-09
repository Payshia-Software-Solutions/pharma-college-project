<?php
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

if ($courseCode == 1) {
    $courseName = "Certificate Course in Pharmacy Practice";
} else {
    $courseName = "Advanced Course in Pharmacy Practice";
}

if (isset($courseCode) && isset($showSession)) {
    $packageBookings = $client->request(
        'GET',
        $_ENV['SERVER_URL'] . '/convocation-registrations-certificate?courseCode=' . $courseCode . '&viewSession=' . $showSession
    )->toArray();

    if ($courseCode == 1) {
        // Sort by certificate_id (ascending)
        usort($packageBookings, function ($a, $b) {
            return strcmp($a['certificate_id'], $b['certificate_id']);
        });
    } else {
        // Sort by advanced_id (ascending)
        usort($packageBookings, function ($a, $b) {
            return strcmp($a['advanced_id'], $b['advanced_id']);
        });
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <title><?= $courseName ?> Print Session <?= $showSession ?></title>
</head>

<body>
    <h1><?= $courseName ?> Print Session <?= $showSession ?></h1>
    <table class="table table-stripped table-hover">
        <tr>
            <th>Student Number</th>
            <th>Name on Certificate</th>
            </th>
        </tr>
        <?php
        $count = 1;
        foreach ($packageBookings as $booking) {
            // break;
            $s_user_name = $booking['student_number'];
            // $CourseCode = 1;

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
                // var_dump($certificateInfo);
                $certificateId = $certificateInfo[$s_user_name]['certificate_id'];
                $batchCode = $certificateInfo[$s_user_name]['course_code'];
            } else {
                $batchCode = $certificateInfo[0]['course_code'];
            }

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
            <tr>
                <td><?= $s_user_name ?></td>
                <td><?= $studentDetailsArray['name_on_certificate'] ?></td>
            </tr>
        <?php
            $count++;
            if ($count == 10) {
                // break;
            }
            // Add a page break after each certificate except the last one
            if ($packageBookings !== end($packageBookings)) {
                echo '<div style="page-break-after: always;"></div>';
            }
        }
        ?>

    </table>
</body>

</html>