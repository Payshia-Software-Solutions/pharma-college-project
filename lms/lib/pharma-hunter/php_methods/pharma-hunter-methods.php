<?php

include __DIR__ . '../../../../include/configuration.php'; // Database Configuration

// Enable MySQLi error reporting
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

function GetSource($sourceType)
{

    if ($sourceType == "racks") {
        $sql = "SELECT `id`, `rack_name` as `name`, `active_status`, `created_at`, `created_by` FROM `hunter_racks`WHERE `active_status` NOT LIKE 'Deleted' ORDER BY `name`";
    } else if ($sourceType == 'dosageForm') {
        $sql = "SELECT `id`, `dosageForm` as `name`, `active_status`, `created_at`, `created_by` FROM `hunter_dosage` WHERE `active_status` NOT LIKE 'Deleted' ORDER BY `name`";
    } else if ($sourceType == 'drugCategory') {
        $sql = "SELECT `id`, `category_name` as `name`, `active_status`, `created_at`, `created_by` FROM `hunter_category` WHERE `active_status` NOT LIKE 'Deleted' ORDER BY `name`";
    } else if ($sourceType == 'drugGroup') {
        $sql = "SELECT `id`, `name`, `is_active`, `created_by`, `created_at` FROM `hp_drug_types`";
    }
    global $link;
    $ArrayResult = array();

    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[$row['id']] = $row;
        }
    }

    return $ArrayResult;
}

function HunterSavedAnswersByUser($studentNumber)
{
    global $link;

    $sql = "SELECT 
                `index_number`, 
                SUM(CASE WHEN `answer_status` LIKE 'Correct' THEN 1 ELSE 0 END) AS `correct_count`, 
                SUM(CASE WHEN `answer_status` LIKE 'Wrong' THEN 1 ELSE 0 END) AS `incorrect_count`, 
                SUM(CASE WHEN `answer_status` LIKE 'Correct' AND `score_type` LIKE 'Jem' THEN  1 ELSE 0 END) AS `gem_count`, 
                SUM(CASE WHEN `answer_status` LIKE 'Correct' AND `score_type` LIKE 'Coin' THEN 1 ELSE 0 END) AS `coin_count` 
            FROM 
                `hunter_saveanswer` 
            WHERE
                `index_number` LIKE '$studentNumber'";

    $result = $link->query($sql);
    $ArrayResult = array(); // Initialize the array
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[$row['index_number']] = $row;
        }
    }
    return $ArrayResult;
}

function getCurrentTimeOfDay()
{
    date_default_timezone_set("Asia/Colombo");
    $currentTime = date('H:i'); // Get the current time in the format 'HH:MM'
    $morningStart = '06:00';
    $afternoonStart = '12:00';
    $eveningStart = '17:00';
    $nightStart = '20:00';

    if ($currentTime >= $morningStart && $currentTime < $afternoonStart) {
        return 'Morning';
    } elseif ($currentTime >= $afternoonStart && $currentTime < $eveningStart) {
        return 'Afternoon';
    } elseif ($currentTime >= $eveningStart && $currentTime < $nightStart) {
        return 'Evening';
    } else {
        return 'Night';
    }
}


function GetSubmissions($link, $CountAnswer, $UserName)
{
    $ArrayResult = array();
    $sql = "SELECT `medicine_id` FROM `hunter_saveanswer` WHERE `index_number` LIKE '$UserName' AND `answer_status` LIKE 'Correct' GROUP BY `index_number`, `medicine_id` HAVING COUNT(*) >= $CountAnswer ORDER BY COUNT(*) DESC";
    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[] = $row["medicine_id"];
        }
    }
    return $ArrayResult;;
}

function GetMedicines($link)
{
    $ArrayResult = array();
    $sql = "SELECT `id`, `category_id`, `product_code`, `medicine_name`, `file_path`, `active_status`, `created_at`, `created_by` FROM `hunter_medicine` WHERE `active_status` LIKE 'Active'";
    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[$row['id']] = $row["id"];
        }
    }
    return $ArrayResult;
}

function GetMedicineByID($link, $medicineId)
{
    $ArrayResult = array();
    $sql = "SELECT `id`, `category_id`, `product_code`, `medicine_name`, `file_path`, `active_status`, `created_at`, `created_by` FROM `hunter_medicine` WHERE `id` LIKE '$medicineId'";
    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[] = $row;
        }
    }
    return $ArrayResult;
}

function GetHunterCourseMedicines($link, $CourseCode)
{
    $ArrayResult = array();
    $sql = "SELECT `id`, `CourseCode`, `MediID`, `status` FROM `hunter_course` WHERE `status` LIKE 'Active' AND `CourseCode` LIKE '$CourseCode'";
    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[$row['MediID']] = $row["MediID"];
        }
    }
    return $ArrayResult;
}

function GetHunterProAttempts($link)
{
    $ArrayResult = 0;
    $sql = "SELECT `id`, `setting`, `value` FROM `settings` WHERE `setting` LIKE 'HunterProAttempt'";
    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult = $row["value"];
        }
    }
    return $ArrayResult;
}



function savedAnswersByUserMedicine($link, $loggedUser, $medicine_id)
{
    $ArrayResult = array();
    $sql = "SELECT * FROM `hunter_saveanswer` WHERE `index_number` LIKE '$loggedUser' AND `medicine_id` LIKE '$medicine_id'";
    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[] = $row;
        }
    }
    return $ArrayResult;
}
