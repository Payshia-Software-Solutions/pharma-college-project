<?php

set_time_limit(600);
require __DIR__ . '/../../../../../vendor/autoload.php';
define('PARENT_SEAT_RATE', 500);

// For use env file data & HTTP client
use Dotenv\Dotenv;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

$dotenv = Dotenv::createImmutable(dirname(__DIR__, 5))->load();
$client = HttpClient::create();

function generateTranscriptId($centreId, $courseCode, $certificateId, $issueDate)
{
    // Convert issue date (e.g. '2025-07-06 16:22:16') to YYMMDD format
    $dateFormatted = date('ymd', strtotime($issueDate));

    // Format the transcript ID
    return "TRNS/{$centreId}/{$dateFormatted}/{$courseCode}/{$certificateId}";
}
function CertificatePrintStatusByParentCourseNew($courseCode, $type, $studentNumber)
{
    $ArrayResult = array();
    global $lms_link;

    // Escape inputs for security
    $courseCode = $lms_link->real_escape_string($courseCode);
    $type = $lms_link->real_escape_string($type);
    $studentNumber = $lms_link->real_escape_string($studentNumber);

    $sql = "SELECT 
                ucps.id,
                ucps.student_number,
                ucps.certificate_id,
                ucps.print_date,
                ucps.print_status,
                ucps.print_by,
                ucps.type,
                ucps.course_code,
                c.parent_course_id
            FROM 
                user_certificate_print_status ucps
            JOIN 
                course c ON ucps.course_code = c.course_code
            WHERE 
                c.parent_course_id LIKE '$courseCode' AND
                ucps.type LIKE '$type' AND
                ucps.student_number LIKE '$studentNumber' AND
                ucps.certificate_id LIKE 'CREF%'";

    $result = $lms_link->query($sql);
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[$row['student_number']] = $row;
        }
    }

    return $ArrayResult;
}



error_reporting(E_ALL); // Report all types of errors
ini_set('display_errors', 1); // Display errors on screen

require_once('../../../../../include/config.php');
include '../../../../../include/function-update.php';
include '../../../../../include/lms-functions.php';
require_once('../../../../../vendor/phpqrcode/qrlib.php');

$courseCode = isset($_GET['courseCode']) ? $_GET['courseCode'] : null;
$showSession = isset($_GET['showSession']) ? $_GET['showSession'] : null;
$tableMode = isset($_GET['tableMode']) ? $_GET['tableMode'] : 1;
// echo $tableMode;

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

    usort($packageBookings, function ($a, $b) {
        $numA = (int) preg_replace('/[^0-9]/', '', $a['ceremony_number']);
        $numB = (int) preg_replace('/[^0-9]/', '', $b['ceremony_number']);
        return $numA - $numB;
    });
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
        font-family: 'Poppins', sans-serif;
        padding: 25px;
        padding-left: 80px;
        width: 210mm;
        height: 297mm;
        display: flex;
        /* border: 1px solid black; */
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

    h2 {
        font-size: 1.2em;
        margin-bottom: 10px;
    }

    .modules {
        position: absolute;
        margin: 20px 0;
        top: 78mm;
        font-size: 15px;
    }

    .modules ul {
        list-style-type: disc;
        padding-left: 20px;
    }

    .details {
        margin-top: 30px;
        position: absolute;
        top: 200mm;
        font-size: 15px;
    }

    .details dt {
        font-weight: bold;
        margin-top: 50px;
    }

    .details p {
        margin: 0 0 10px;
    }

    .details dd {
        margin: 0 0 20px 40px;
    }

    .signature-qr {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 40px;
        position: absolute;
        top: 155mm;
    }

    .signature {
        position: absolute;
        top: 220mm;
        left: 138mm;
    }

    .signature img {
        position: absolute;
        top: -5mm;
        left: 0mm;
        width: 150px;
        height: auto;
    }

    .signature p {
        /* margin: 5px 0 0; */
        font-weight: bold;
    }

    .qr-code img {
        position: absolute;
        left: 150mm;
        width: 80px;
        height: 80px;
        top: 4mm;
    }

    .qr-code p {
        position: absolute;
        left: 150mm;
        top: 26mm;
        width: 100px;
        font-size: 12px;
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
        top: 230mm;
    }

    .footer {
        left: 80px;
        position: absolute;
        top: 262mm;
    }

    .module-name {
        font-size: 16px;
    }

    .dots {
        font-family: 'Times New Roman', Times, serif;
        color: #808080;
    }

    .pv-number2 {
        position: absolute;
        top: 277mm;
        font-size: 0.8em;
        left: 170mm;
    }

    .grade {
        position: absolute;
        top: 260mm;
        left: 80px;
        font-size: 1.5em;
    }

    .grade-scale {
        top: 285mm;
        left: 0px;
        width: 210mm;
        text-align: center;
        position: absolute;
        font-size: 0.5em;
        color: #808080;
    }
</style>

<?php if ($tableMode == 1) { ?>
    <table border="1" cellspacing="0">
        <tr>
            <th>#</th>
            <th style="padding: 10px;">Ceremony Number</th>
            <th style="padding: 10px;">Name on Certificate</th>
            <th style="padding: 10px;">Certificate ID</th>
            <th style="padding: 10px;">Username</th>
            <th style="padding: 10px;">batchCode</th>
            <th style="padding: 10px;">Grade</th>
            <th style="padding: 10px;">Transcript ID</th>
        </tr>
    <?php } ?>
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
        // if (empty($certificateId)) {
        //     $certificateInfo = CertificatePrintStatusByParentCourse($courseCode, 'Certificate', $s_user_name);
        //     // var_dump($certificateInfo);
        //     $certificateId = $certificateInfo[$s_user_name]['certificate_id'];
        //     $batchCode = $certificateInfo[$s_user_name]['course_code'];
        // } else {
        //     $batchCode = $certificateInfo[0]['course_code'];
        // }

        $certificateInfo = CertificatePrintStatusByParentCourseNew($courseCode, 'Certificate', $s_user_name);
        // var_dump($certificateInfo);
        $certificateId = $certificateInfo[$s_user_name]['certificate_id'];
        $batchCode = $certificateInfo[$s_user_name]['course_code'];

        $assignmentAvg = $client->request(
            'GET',
            $_ENV['SERVER_URL'] . '/get-assignments-results?CourseCode=' . $batchCode . '&loggedUser=' . $s_user_name
        )->toArray();

        $final_percentage_value = $assignmentAvg['average_grade'] ?? 0;

        if ($final_percentage_value == "Result Not Submitted") {
            $finalGrade = "Result Not Submitted";
        } elseif ($final_percentage_value >= 90) {
            $finalGrade = "A+";
        } elseif ($final_percentage_value >= 80) {
            $finalGrade = "A";
        } elseif ($final_percentage_value >= 75) {
            $finalGrade = "A-";
        } elseif ($final_percentage_value >= 70) {
            $finalGrade = "B+";
        } elseif ($final_percentage_value >= 65) {
            $finalGrade = "B";
        } elseif ($final_percentage_value >= 60) {
            $finalGrade = "B-";
        } elseif ($final_percentage_value >= 55) {
            $finalGrade = "C+";
        } elseif ($final_percentage_value >= 45) {
            $finalGrade = "C";
        } elseif ($final_percentage_value >= 40) {
            $finalGrade = "C-";
        } elseif ($final_percentage_value >= 35) {
            $finalGrade = "D+";
        } elseif ($final_percentage_value >= 30) {
            $finalGrade = "D";
        } elseif ($final_percentage_value >= 0) {
            $finalGrade = "E";
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

        <?php


        $centreId = 253555;
        $transcriptId = generateTranscriptId($centreId, $batchCode, $certificateId, $PrintDate);

        ?>
        <?php if ($tableMode == 1) { ?>

            <tr>
                <td><?= $count++ ?></td>
                <td style="padding: 10px;"><?= $booking['ceremony_number'] ?></td>
                <td style="padding: 10px;"><?= $studentDetailsArray['name_on_certificate'] ?></td>
                <td style="padding: 10px;"><?= $certificateId ?></td>
                <td style="padding: 10px;"><?= $s_user_name ?></td>
                <td style="padding: 10px;"><?= $batchCode ?></td>
                <td style="padding: 10px;"><?= $finalGrade ?></td>
                <td style="padding: 10px;"><?= $transcriptId ?></td>
            </tr>
        <?php } else { ?>
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
                            <li>Gastrointestinal Medicines</li>
                            <li>Cardiovascular Medicines</li>
                            <li>Respiratory Medicines</li>
                            <li>Anti-Infective Medicines</li>
                            <li>Endocrine Medicines</li>
                            <li>Ophthalmic & ENT Medicines</li>
                            <li>Dermatological Medicines</li>
                            <li>Central Nervous Medicines</li>
                            <li>Pharmaceutical Law & Regulations</li>
                            <li>Assist in Dispensing Medications</li>

                        </ul>
                    </section>

                    <div class="details">
                        <p><strong>Candidate Name:</strong> <?= $studentDetailsArray['name_on_certificate'] ?></p>
                        <p><strong>Duration:</strong> 6 Months</p>
                        <p><strong>Completed Date:</strong> <?= date("F j, Y", strtotime("2025-06-30")) ?></p>
                        <p><strong>Student Number:</strong> <?= $s_user_name ?></p>
                        <p><strong>Certificate Number:</strong> <?= $certificateId ?></p>
                    </div>


                    <p class="grade">Grade:<strong> <?= $finalGrade ?></strong></strong></p>

                    <div class="signature">
                        <!-- Replace src with actual signature image -->
                        <img src="sign.png" alt="Signature of Katie Powell">
                        <p class="dots">....................................................</p>
                        <p>Dilip Fonseka,<br>Executive Director</p>
                    </div>
                    <div class="signature-qr">

                        <div class="qr-code">
                            <img class="" src="data:image/png;base64,<?= base64_encode($image_data) ?>">
                            <p>Scan & Verify</p>
                            <!-- Replace src with actual QR code image -->
                        </div>
                    </div>

                    <p class="grade-scale">
                        <strong>Grade Scale:</strong>
                        A+ (90-100), A (80-89), A- (75-79), B+ (70-74), B (65-69), B- (60-64),
                        C+ (55-59), C (45-54), C- (40-44), D+ (35-39), D (30-34), E (0-29)
                    </p>

                    <div class="footer">
                        <?= $transcriptId ?>
                    </div>
                    <p class="pv-number2">PV00253555</p>
                </div>

            </div>
        <?php
            if ($count == 5) {
                break;
            }
            // Add a page break after each certificate except the last one
            if ($packageBookings !== end($packageBookings)) {
                echo '<div style="page-break-after: always;"></div>';
            }
        }
    }
    if ($tableMode == 1) { ?>
    </table>
<?php }  ?>