<?php

error_reporting(E_ALL); // Report all types of errors
ini_set('display_errors', 1); // Display errors on screen

require_once('../../../../../include/config.php');
include '../../../../../include/function-update.php';
include '../../../../../include/lms-functions.php';

function GetStudentNumbersByCourse($link, $courseCode = 'CPCC22')
{
    $studentNumbers = array();
    $sql = "SELECT `student_number` FROM `user_certificate_print_status` WHERE `course_code` LIKE ?";
    
    $stmt = $link->prepare($sql);
    $stmt->bind_param("s", $courseCode);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $studentNumbers[$row['student_number']] = $row['student_number'];
        }
    }

    return $studentNumbers;
}

$studentNumbers = GetStudentNumbersByCourse($lms_link, $courseCode = 'CPCC22');

function formatNameForCertificate($fullName, $maxLength = 30) {
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
foreach ($studentNumbers as $studentNumber) {

$loggedUser = $_GET['PrintedId'];
$s_user_name = $studentNumber;
$PrintDate = $_GET['issuedDate'];
$CourseCode = $_GET['selectedCourse'];
$templateId = $_GET['certificateTemplate'];
$backImageStatus = $_GET['backImageStatus'];
$TemplateDetails = GetTemplate($templateId);
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
$certificateEntryResult = EnterCertificateEntry($printDate, 1, $loggedUser, 'Workshop-Certificate', $s_user_name, $CourseCode);
// var_dump($certificateEntryResult);

// Include the qrlib file
require_once(__DIR__ . '/../../../../../vendor/phpqrcode/qrlib.php');

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
        height: 297mm; /* A4 full height */
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
        left: <?=210 -30 ?>mm;
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
    
    .page-break {
    page-break-after: always;
}

.certificate-container{
    
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
<p class="pv-number">PV00253555</p>
    <div class="name-box">
        <p class="certificate-user">
          <?= formatNameForCertificate(trim($studentDetailsArray['name_on_certificate'])) ?></p>
    
    </div>
    <img class="qr-code" src="data:image/png;base64,<?= base64_encode($image_data) ?>">
    <p class="print-date">Date:<?= $PrintDate ?></p>
    <p class="print-number">Index Number:<?= $s_user_name ?></p>
    <p class="certificate-number">Certificate ID:<?= GetCertificateID('Workshop-Certificate', $s_user_name, $CourseCode) ?></p>
</div>
<?php 
    // Add a page break after each certificate except the last one
    if ($studentNumber !== end($studentNumbers)) {
        echo '<div style="page-break-after: always;"></div>';
    }
}
?>