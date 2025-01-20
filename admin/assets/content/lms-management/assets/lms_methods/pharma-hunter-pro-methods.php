<?php

include __DIR__ . '/../../../../../include/config.php'; // Database Configuration

// Enable MySQLi error reporting
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);


function GetHPCorrectAttempts($lms_link, $IndexNumber)
{
    $ArrayResult = array();
    $sql = "SELECT * FROM `hp_save_answer` WHERE `index_number` LIKE '$IndexNumber' AND `answer_status` LIKE 'Correct'";
    $result = $lms_link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[] = $row;
        }
    }
    return $ArrayResult;
}


function GetAllSubmissionsByMedicine($lms_link, $UserName)
{
    $ArrayResult = array();
    $sql = "SELECT `medicine_id`, count(`medicine_id`) as `attemptCount` FROM `hp_save_answer` WHERE `index_number` LIKE '$UserName' GROUP BY `medicine_id`";
    $result = $lms_link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[] = $row;
        }
    }
    return $ArrayResult;
}

function GetAllSubmissions($lms_link, $UserName)
{
    $ArrayResult = array();
    $sql = "SELECT * FROM `hp_save_answer` WHERE `index_number` LIKE '$UserName'";
    $result = $lms_link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[] = $row;
        }
    }
    return $ArrayResult;
}
