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
}
?>
<title><?= $courseName ?> Print Session <?= $showSession ?></title>


<link
    href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Roboto:wght@400;500;700&display=swap"
    rel="stylesheet">
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .transcript {
        padding: 15px;
        width: 210mm;
        height: 297mm;
        display: flex;
        border: 1px solid black;
        flex-direction: column;
        page-break-inside: avoid;
        position: relative;
    }

    h1 {
        width: 210mm;
        text-align: center;
        margin-top: 20px;
        font-size: 1.5em;
    }

    .modules {
        position: absolute;
        margin: 20px 0;
        top: 80mm;
    }

    .modules ul {
        list-style-type: disc;
        padding-left: 20px;
    }

    .details {
        margin-top: 30px;
        position: absolute;
        top: 165mm;
    }

    .details dt {
        font-weight: bold;
        margin-top: 10px;
    }

    .details dd {
        margin: 0 0 10px 20px;
    }

    .signature-qr {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 40px;
    }

    .signature {
        text-align: center;
    }

    .signature img {
        width: 150px;
        height: auto;
    }

    .signature p {
        margin: 5px 0 0;
        font-weight: bold;
    }

    .qr-code img {
        position: absolute;
        left: 140mm;
        width: 100px;
        height: 100px;
    }

    .footer {
        text-align: center;
        margin-top: 60px;
        font-size: 0.8em;
        color: #666;
    }

    .course-name {
        left: 0mm;
        position: absolute;
        /* background-color: antiquewhite; */
        top: 55mm;
    }

    .signature-qr {
        position: absolute;
        top: 220mm;
    }

    .footer {
        left: 0mm;
        /* background-color: #666; */
        width: 210mm;
        position: absolute;
        text-align: center;
        top: 250mm;
    }

    .module-name {
        font-size: 16px;
    }

    .pv-number2 {
        position: absolute;
        top: 290mm;
        left: 185mm;
    }
</style>

<?php


$count = 1;
foreach ($packageBookings as $booking) {
    $s_user_name = $booking['student_number'];
    $CourseCode = 1;

    $batchStudents =  GetLmsStudents();
    $studentDetailsArray = $batchStudents[$s_user_name];

    $certificateId = ($courseCode == 1) ? $booking['certificate_id'] : $booking['advanced_id'];
    $certificateInfo = CertificatePrintStatusByCertificateId($certificateId);
    // var_dump($certificateInfo);


    $PrintDate = date("Y-m-d H:i:s");
    // $certificateEntryResult = EnterCertificateEntry($printDate, 1, $loggedUser, 'Workshop-Certificate', $s_user_name, $CourseCode);
    // var_dump($certificateEntryResult);

    // Include the qrlib file
    $text = "https://pharmacollege.lk/result-view.php?CourseCode=" . $certificateInfo[0]['course_code'] . "&LoggedUser=" . $s_user_name;
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
        <div class="transcript">
            <h1 class="course-name"><?= $courseName ?></h1>

            <section class="modules">
                <h2 class="module-name">Module Name</h2>
                <ul>
                    <li>Introduction to Pharmacy Practice & Professional Ethics</li>
                    <li>Fundamental Principles of Pharmacology & Drug Action</li>
                    <li>Understanding Prescriptions & Dispensing Essentials</li>
                    <li>Routes of Drug Administration & Dosage Forms</li>
                    <li>Pharmaceutical Calculations</li>
                    <li>Gastro intestinal medicines</li>
                    <li>Cardio Vascular Medicines</li>
                    <li>Respiratory Medicines</li>
                    <li>Anti-Infective Medicines</li>
                    <li>Endocrine medicines</li>
                    <li>Ophthalmic & ENT Medicines</li>
                    <li>Dermatological Medicines</li>
                    <li>Central Nervous Medicines</li>
                    <li>Pharmaceutical Law & Regulations</li>
                    <li>Assist in Dispensing Medications</li>
                </ul>
            </section>

            <div class="details">
                <p><strong>Candidate Name:</strong> <?= $studentDetailsArray['name_on_certificate'] ?></p>
                <p><strong>DOB:</strong> 28/05/1991</p>
                <p><strong>Centre Name:</strong> Ceylon Pharma College</p>
                <p><strong>Award Date:</strong> 03/12/2024</p>
                <p><strong>Candidate Number:</strong> BRD62485</p>
                <p><strong>Certificate Number:</strong> 2024/GA/81510</p>
                <p><strong>GLH:</strong> 1200</p>
            </div>


            <div class="signature-qr">
                <div class="signature">
                    <!-- Replace src with actual signature image -->
                    <img src="sign.png" alt="Signature of Katie Powell">
                    <p>....................................................</p>
                    <p>Dilip Fonseka,<br>Executive Director</p>
                </div>
                <div class="qr-code">
                    <!-- Replace src with actual QR code image -->
                    <img src="#" alt="QR Code">
                </div>
            </div>

            <div class="footer">
                TRNS/2103/240703/L7SME/0017
            </div>
            <p class="pv-number2">PV00253555</p>
        </div>

    </div>
<?php
    $count++;
    if ($count == 3) {
        break;
    }
    // Add a page break after each certificate except the last one
    if ($packageBookings !== end($packageBookings)) {
        echo '<div style="page-break-after: always;"></div>';
    }
}
?>