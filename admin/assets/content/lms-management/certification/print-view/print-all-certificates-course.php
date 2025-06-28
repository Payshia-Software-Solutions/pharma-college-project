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
$showSession = isset($_GET['showSession']) ? $_GET['showSession'] : null;


if (isset($courseCode) && isset($showSession)) {
    $packageBookings = $client->request(
        'GET',
        $_ENV['SERVER_URL'] . '/convocation-registrations-certificate?courseCode=' . $courseCode . '&viewSession=' . $showSession
    )->toArray();
}


function formatNameForCertificate($fullName, $maxLength = 30)
{
    // Normalize spaces and dots
    $fullName = preg_replace('/\s+/', ' ', $fullName); // Remove extra spaces
    $fullName = preg_replace('/(?<=\w)\.(?=\w)/', '. ', $fullName); // Add space after dots if missing (e.g. H.Virajini => H. Virajini)
    $fullName = trim($fullName);

    // Capitalize words properly
    $fullName = ucwords(strtolower($fullName));

    // If within character limit, return as-is
    if (strlen($fullName) <= $maxLength) {
        return $fullName;
    }

    // Break into words
    $words = explode(' ', $fullName);
    $numWords = count($words);

    if ($numWords < 3) {
        return substr($fullName, 0, $maxLength); // fallback for short names
    }

    // Last two full words (first name + surname)
    $lastTwo = array_slice($words, -2);
    $lastTwoStr = implode(' ', $lastTwo);

    // Initials from earlier words
    $initials = '';
    for ($i = 0; $i < $numWords - 2; $i++) {
        $word = $words[$i];
        // If word ends with a dot, keep it as-is (already an initial)
        if (preg_match('/^[a-zA-Z]\.$/', $word)) {
            $initials .= $word;
        } else {
            $initials .= strtoupper(substr($word, 0, 1)) . '.';
        }
    }

    $final = $initials . ' ' . $lastTwoStr;

    // Still too long? Truncate first of last two names
    if (strlen($final) > $maxLength) {
        $firstOfLastTwo = $lastTwo[0];
        $secondOfLastTwo = $lastTwo[1];
        $allowedLengthForFirst = $maxLength - strlen($initials) - strlen($secondOfLastTwo) - 2;
        $firstOfLastTwo = substr($firstOfLastTwo, 0, $allowedLengthForFirst);
        $final = $initials . ' ' . $firstOfLastTwo . ' ' . $secondOfLastTwo;
    }

    return $final;
}

foreach ($packageBookings as $booking) {

    $loggedUser = $_GET['PrintedId'];
    $s_user_name = $booking['student_number'];
    $PrintDate = $_GET['issuedDate'];
    $CourseCode = $_GET['selectedCourse'];
    $templateId = $_GET['certificateTemplate'];
    $backImageStatus = $_GET['backImageStatus'];
    $TemplateDetails = GetTemplate($templateId);
    // var_dump($TemplateDetails);
    $batchStudents =  GetLmsStudents();
    $studentDetailsArray = $batchStudents[$s_user_name];

    if (isset($TemplateDetails[$templateId])) {
        $Template = $TemplateDetails[$templateId];
    }

    $qr_position_from_left = $Template['left_to_qr'];
    $qr_position_from_top = $Template['top_to_qr'];
    $qr_code_width = $Template['qr_width'];

    $date_position_from_left = $Template['left_to_date'];
    $date_position_from_top = $Template['top_to_date'];

    $name_position_from_left = $Template['left_margin'];
    $name_position_from_top = $Template['top_to_name'];
    $backImage = $Template['back_image'];

    $printDate = date("Y-m-d H:i:s");
    // $certificateEntryResult = EnterCertificateEntry($printDate, 1, $loggedUser, 'Workshop-Certificate', $s_user_name, $CourseCode);
    // var_dump($certificateEntryResult);

    // Include the qrlib file

    $text = "https://pharmacollege.lk/result-view.php?CourseCode=" . $CourseCode . "&LoggedUser=" . $s_user_name;
    $ecc = 'L';
    $pixel_Size = 10;
    $frame_Size = 0;

    // Generate the QR code image
    ob_start();
    QRcode::png($text, null, QR_ECLEVEL_L, 10, 0);
    $image_data = ob_get_contents();
    ob_end_clean();




?>

    <title><?= $s_user_name ?> - <?= $CourseCode ?> - Certificate Print</title>

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
            padding-left: <?= $name_position_from_left ?>mm !important;
        }

        .pv-number {
            position: absolute;
            left: <?= 210 - 30 ?>mm;
            top: 5mm
        }

        .certificate-user {

            /* border: 1px solid black; */

            font-family: "Chaparral Pro Bold Italic";
            width: calc(210mm - 100px);
            font-size: 35px;
            /*text-align: center !important;*/
            font-weight: 800 !important;
            position: absolute;
            top: <?= $name_position_from_top ?> !important;
        }

        .qr-code {
            left: <?= $qr_position_from_left ?> !important;
            top: <?= $qr_position_from_top ?> !important;
            position: absolute;
            width: <?= $qr_code_width ?>mm !important;
        }

        .print-date {
            left: <?= $date_position_from_left ?> !important;
            top: <?= $date_position_from_top ?> !important;
            position: absolute;
            font-family: 'Courier Prime', monospace;
        }

        .print-number {
            left: <?= $date_position_from_left ?> !important;
            top: <?= $date_position_from_top + (16 * 1) ?> !important;
            position: absolute;
            font-family: 'Courier Prime', monospace;
        }

        .certificate-number {
            left: <?= $date_position_from_left ?> !important;
            top: <?= $date_position_from_top + (16 * 2) ?> !important;
            position: absolute;
            font-family: 'Courier Prime', monospace;

        }

        .pv-number2 {

            left: <?= $date_position_from_left ?> !important;
            top: <?= $date_position_from_top + (16 * 3) ?> !important;
            position: absolute;
            font-family: 'Courier Prime', monospace;
        }

        .page-break {
            page-break-after: always;
        }
    </style>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            /* background: #f8f8f8; */
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .certificate {
            /* background-image: url('cer.jpeg'); */
            width: 210mm;
            height: 297mm;
            display: flex;
            border: 1px solid black;
            flex-direction: column;
            align-items: center;
            text-align: center;
            page-break-inside: avoid;
            position: relative;
        }

        .certificate-title {
            font-size: 25px;
            font-weight: bold;
            color: #333;
            margin-top: 90mm;
            letter-spacing: 1px;
        }

        .awarded-to {
            font-size: 20px;
            font-family: 'Roboto', sans-serif;
            color: #333;
            margin-top: 10mm;
        }

        .recipient-line {
            width: 120mm;
            height: 1px;
            margin-top: 3mm;
            font-weight: 900;
            font-size: 25px;
        }

        .recognition-text {
            font-size: 20px;
            font-family: 'Roboto', sans-serif;
            color: #333;
            margin-top: 12mm;
            line-height: 1.3;
        }

        .course-line {
            width: 150mm;
            height: 1px;
            margin-top: 4mm;
            font-weight: 900;
            font-size: 20px;
        }

        .offered-by {
            font-size: 20px;
            color: #333;
            margin-top: 10mm;
        }

        .institution {
            font-size: 20px;
            font-weight: bold;
            color: #333;
        }

        .ceremony-details {
            font-size: 16px;
            color: #333;
            line-height: 1.4;
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
    if ($backImage != "" && $backImageStatus == 1) {
    ?>
        <img class="back-image" src="../assets/images/certificate-back/<?= $backImage ?>">
    <?php
    }
    ?>
    <div class="certificate-container">
        <div class="certificate">
            <h1 class="certificate-title">CERTIFICATE OF COMPLETION</h1>

            <p class="awarded-to">This certificate is awarded to</p>
            <div class="recipient-line">G. T. R. K. Doloswala</div>

            <div class="recognition-text">
                in recognition of the<br>
                successful completion of the
            </div>
            <div class="course-line">Certificate course in Pharmacy Practise</div>

            <p class="offered-by">offered by</p>
            <div class="institution">Ceylon Pharma College</div>
            <div class="ceremony-details">
                The certificate award ceremony was held at the<br>
                BMICH, Colombo, Sri Lanka.
            </div>
        </div>

        <img class="qr-code" src="data:image/png;base64,<?= base64_encode($image_data) ?>">
        <p class="print-date">Date:<?= $PrintDate ?></p>
        <p class="print-number">Index Number:<?= $s_user_name ?></p>
        <p class="certificate-number">Certificate ID:<?= GetCertificateID('Certificate', $s_user_name, $CourseCode) ?></p>
        <p class="pv-number2">PV00253555</p>
    </div>
<?php
    // Add a page break after each certificate except the last one
    if ($packageBookings !== end($packageBookings)) {
        echo '<div style="page-break-after: always;"></div>';
    }
}
?>