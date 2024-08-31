<?php

include __DIR__ . '/../include/configuration.php';
// Enable MySQLi error reporting
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

function GetCourseDetails($courseCode)
{
    global $link;

    $ArrayResult = array();
    $sql = "SELECT * FROM `course` WHERE `course_code` LIKE '$courseCode'";

    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[$row['course_code']] = $row;
        }
    }
    if (isset($ArrayResult[$courseCode])) {
        return $ArrayResult[$courseCode];
    } else {
        return null;
    }
}


function GetCourseContent($courseCode)
{
    global $link;
    $ArrayResult = array();

    $sql = "SELECT `id`, `course_code`, `title_name`, `title_description`, `created_by`, `created_at` FROM `course_content` WHERE `course_code` LIKE '$courseCode' ORDER BY id";
    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[$row['id']] = $row;
        }
    }
    return $ArrayResult;
}

function GetContentTitle($titleId)
{
    global $link;

    $ArrayResult = array();

    $sql = "SELECT `id`, `course_code`, `title_id`, `resource_type`, `description`, `file_path`, `web_link`, `created_by`, `created_at` FROM `course_content_title` WHERE `title_id` LIKE '$titleId' ORDER BY id";
    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[] = $row;
        }
    }

    return $ArrayResult;
}


function getStudentPaymentDetails($userName)
{

    global $link;
    $ArrayResult = array();

    $studentId = GetLmsStudentsByUserName($userName)['student_id'];
    $sql = "SELECT * FROM `student_payment` WHERE `student_id` LIKE '$studentId'";

    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[$row['receipt_number']] = $row;
        }
    }

    return $ArrayResult;
}

function getLmsBatches()
{

    global $link;
    $ArrayResult = array();

    $sql = "SELECT `id`, `course_name`, `course_code`, `instructor_id`, `course_description`, `course_duration`, `course_fee`, `registration_fee`, `other`, `created_at`, `created_by`, `update_by`, `update_at`, `enroll_key`, `display`, `CertificateImagePath`, `course_img`, `certification`, `mini_description` FROM `course` ORDER BY `id` DESC";

    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[$row['course_code']] = $row;
        }
    }

    return $ArrayResult;
}


function GetStudentBalance($userName)
{
    $totalPaymentAmount = $TotalStudentPaymentRecords = $studentBalance = $TotalRegistrationFee = 0;
    $paymentRecords = getStudentPaymentDetails($userName);
    $studentEnrollments = getUserEnrollments($userName);
    $courseList = getLmsBatches();

    if (!empty($studentEnrollments)) {
        foreach ($studentEnrollments as $selectedArray) {
            $totalCourseFee = 0;
            $courseDetails = $courseList[$selectedArray['course_code']];
            $totalCourseFee = $courseDetails['course_fee'] + $courseDetails['registration_fee'];
            $TotalRegistrationFee += $courseDetails['registration_fee'];
            $totalPaymentAmount += $totalCourseFee;
        }
    }

    if (!empty($paymentRecords)) {
        foreach ($paymentRecords as $selectedArray) {
            $paymentRecord = 0;
            $paymentRecord = ($selectedArray['paid_amount'] + $selectedArray['discount_amount']);
            $TotalStudentPaymentRecords += $paymentRecord;
        }
    }

    $studentBalance = $totalPaymentAmount - $TotalStudentPaymentRecords;

    // Construct Result Array
    $resultArray = array(
        'totalPaymentAmount' => $totalPaymentAmount,
        'TotalStudentPaymentRecords' => $TotalStudentPaymentRecords,
        'studentBalance' => $studentBalance,
        'TotalRegistrationFee' => $TotalRegistrationFee
    );
    return $resultArray;
}
