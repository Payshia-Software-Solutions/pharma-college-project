<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('../../../include/config.php');
require '../../../vendor/autoload.php';
include '../../../helper/errorHandler.php';
include '../../../include/function-update.php';

use Symfony\Component\HttpClient\HttpClient;

$client = HttpClient::create();
$studentBatch = isset($_GET['studentBatch']) ? $_GET['studentBatch'] : null;
$locationId = isset($_GET['locationId']) ? $_GET['locationId'] : null;
$locationId = isset($_GET['locationId']) ? $_GET['locationId'] : null;
// Handle Error
if ($studentBatch === null) {
    handleError("studentBatch Required", "The Student Batch is required to access this page.");
}

$Locations = GetLocations($link);
$companyInfo = GetCompanyInfo($link);
$location_name = $Locations[$locationId]['location_name'];

// Get User Details
$response = $client->request('GET', 'https://api.pharmacollege.lk/userFullDetails/');
$usersInfo = $response->toArray();
$userDetails = array_column($usersInfo, null, 'student_id');

// Get Assignments
$response = $client->request('GET', 'https://api.pharmacollege.lk/assignments/course/' . $studentBatch);
$assignmentsByCourse = $response->toArray();

// Course Enrollments
$response = $client->request('GET', 'https://api.pharmacollege.lk/studentEnrollments/course/' . $studentBatch);
$courseEnrollments = $response->toArray();

// Get Submission by Course
$response = $client->request('GET', 'https://api.pharmacollege.lk/submissions/course/' . $studentBatch);
$submissionsByCourse = $response->toArray();



$generateDate = new DateTime();
$reportDate = $generateDate->format('d/m/Y H:i:s');

$pageTitle = "Course Assignment Report - " . $studentBatch;;
$reportTitle = "Course Assignment Report";
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?></title>

    <!-- Favicons -->
    <link href="../../../assets/images/favicon/apple-touch-icon.png" rel="icon">
    <link href="../../../assets/images/favicon/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- CSS -->
    <link rel="stylesheet" href="../../../assets/css/report-viewer.css">

</head>

<body>
    <div class="invoice">
        <div id="container">
            <div id="left-section">
                <h3 class="company-title"><?= $companyInfo['company_name'] ?></h3>
                <p><?= $companyInfo['company_address'] ?>, <?= $companyInfo['company_address2'] ?></p>
                <p><?= $companyInfo['company_city'] ?>, <?= $companyInfo['company_postalcode'] ?></p>
                <p>Tel: <?= $companyInfo['company_telephone'] ?>/ <?= $companyInfo['company_telephone2'] ?></p>
                <p>Email: <?= $companyInfo['company_email'] ?></p>
                <p>Web: <?= $companyInfo['website'] ?></p>
            </div>

            <div id="right-section">
                <h4 class="report-title-mini"><?= strtoupper($reportTitle) ?></h4>
                <table>
                    <tr>
                        <th>Location</th>
                        <td class="text-end"><?= $location_name ?></td>
                    </tr>
                    <tr>
                        <th>Batch Code</th>
                        <td class="text-end"><?= $studentBatch ?></td>
                    </tr>

                </table>
            </div>

        </div>


        <p style="font-weight:600;margin-top:10px; margin-bottom:0px">Report is generated on <?= $reportDate ?></p>
        <div id="container" class="section-4">
            <table id="grade-table" class="display compact" style="width:100% !important">
                <thead>
                    <tr>
                        <th>Index No</th>
                        <th>Student Name</th>
                        <?php foreach ($assignmentsByCourse as $assignment) : ?>
                            <th><?= $assignment['assignment_name'] ?></th>
                        <?php endforeach ?>

                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($courseEnrollments)) {
                        foreach ($courseEnrollments as $selectedArray) {
                            $selectedStudent = $selectedArray['student_id'];
                            if (!isset($userDetails[$selectedStudent])) {
                                continue;
                            }
                            $selectedUsername =  $userDetails[$selectedStudent]['username'];
                    ?>
                            <tr>
                                <td class="border-bottom"><?= $userDetails[$selectedStudent]['username'] ?></td>
                                <td class="border-bottom"><?= $userDetails[$selectedStudent]['name_on_certificate'] ?></td>
                                <?php foreach ($assignmentsByCourse as $assignment) :
                                    if (isset($submissionsByCourse[$selectedUsername . '_' . $assignment['id']])) {
                                        $selectedSubmisssions = $submissionsByCourse[$selectedUsername . '_' . $assignment['id']];
                                        $grade = $selectedSubmisssions['grade'];
                                        if ($grade == 0 || $grade == "") {
                                            $grade = "Not graded";
                                        }
                                    } else {
                                        $grade = "Not Submitted";
                                    }
                                ?>
                                    <td class="border-bottom text-center"><?= $grade ?></td>
                                <?php endforeach ?>
                            </tr>
                    <?php

                        }
                    }
                    ?>

                </tbody>
            </table>
        </div>
    </div>
</body>

</html>