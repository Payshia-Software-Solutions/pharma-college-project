<?php

include __DIR__ . '../../../../include/configuration.php'; // Database Configuration

// Enable MySQLi error reporting
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

function GetSource($sourceType)
{

    if ($sourceType == "racks") {
        $sql = "SELECT `id`, `name`, `is_active`, `created_by`, `created_at` FROM `hp_racks`";
    } else if ($sourceType == 'dosageForm') {
        $sql = "SELECT `id`, `name`, `is_active`, `created_by`, `created_at` FROM `hp_dosage_forms`";
    } else if ($sourceType == 'drugCategory') {
        $sql = "SELECT `id`, `name`, `is_active`, `created_by`, `created_at` FROM `hp_categories`";
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

function GetProMedicine()
{
    global $link;

    $ArrayResult = array();
    $sql = "SELECT `id`, `medicine_name`, `image_url`, `dosage_form_id`, `category_id`, `drug_type_id`, `rack_id`, `is_active`, `created_by`, `created_at` FROM `hp_medicines`";
    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[$row['id']] = $row;
        }
    }
    return $ArrayResult;
}

function GetProMedicineByID($link, $medicineId)
{
    $ArrayResult = array();
    $sql = "SELECT `id`, `medicine_name`, `image_url`, `dosage_form_id`, `category_id`, `drug_type_id`, `rack_id`, `is_active`, `created_by`, `created_at` FROM `hp_medicines`  WHERE `id` LIKE '$medicineId'";
    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[] = $row;
        }
    }
    return $ArrayResult;
}

function savedAnswers($link)
{
    $ArrayResult = array();
    $sql = "SELECT `id`, `index_number`, `category_id`, `medicine_id`, `rack_id`, `dosage_id`, `drug_type`, `answer_status`, `created_at`, `score`, `score_type`, `attempts` FROM `hp_save_answer`";
    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[] = $row;
        }
    }
    return $ArrayResult;
}

function savedAnswersByUser($link, $loggedUser)
{
    $ArrayResult = array();
    $sql = "SELECT `id`, `index_number`, `category_id`, `medicine_id`, `rack_id`, `dosage_id`, `drug_type`, `answer_status`, `created_at`, `score`, `score_type`, `attempts` FROM `hp_save_answer` WHERE `index_number` LIKE '$loggedUser'";
    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[] = $row;
        }
    }
    return $ArrayResult;
}


function savedAnswersByUserMedicine($link, $loggedUser, $medicine_id)
{
    $ArrayResult = array();
    $sql = "SELECT `id`, `index_number`, `category_id`, `medicine_id`, `rack_id`, `dosage_id`, `drug_type`, `answer_status`, `created_at`, `score`, `score_type`, `attempts` FROM `hp_save_answer` WHERE `index_number` LIKE '$loggedUser' AND `medicine_id` LIKE '$medicine_id'";
    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[] = $row;
        }
    }
    return $ArrayResult;
}

function savedCorrectAnswersByUserMedicine($link, $loggedUser, $medicine_id)
{
    $ArrayResult = array();
    $sql = "SELECT `id`, `index_number`, `category_id`, `medicine_id`, `rack_id`, `dosage_id`, `drug_type`, `answer_status`, `created_at`, `score`, `score_type`, `attempts` FROM `hp_save_answer` WHERE `index_number` LIKE '$loggedUser' AND `medicine_id` LIKE '$medicine_id' AND answer_status LIKE 'Correct'";
    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[] = $row;
        }
    }
    return $ArrayResult;
}




function SaveAnswerToDatabase($link, $LoggedUser, $MedicineID, $RackID, $DosageID, $AnswerStatus, $Mark, $AttemptCount, $ScoreType, $CategoryID, $DrugGroupID)
{
    $sql = "INSERT INTO `hp_save_answer`(`index_number`, `medicine_id`, `rack_id`, `dosage_id`, `answer_status`, `score`, `attempts`, `score_type`, `category_id`, `drug_type`) VALUES  (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    if ($stmt_sql = mysqli_prepare($link, $sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt_sql, "ssssssssss", $param_1, $param_2, $param_3, $param_4, $param_5, $param_6, $param_7, $param_8, $param_9, $param_10);

        // Set parameters
        $param_1 = $LoggedUser;
        $param_2 = $MedicineID;
        $param_3 = $RackID;
        $param_4 = $DosageID;
        $param_5 = $AnswerStatus;
        $param_6 = $Mark;
        $param_7 = $AttemptCount;
        $param_8 = $ScoreType;
        $param_9 = $CategoryID;
        $param_10 = $DrugGroupID;

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt_sql)) {
            return "Answer Saved";
        } else {
            return "Answer Not Saved";
        }

        // Close statement
        mysqli_stmt_close($stmt_sql);
    } else {
        return "Answer Not Saved";
    }
}

function GetProAllMedicines($link)
{
    $ArrayResult = array();
    $sql = "SELECT `id`, `medicine_name`, `image_url`, `dosage_form_id`, `category_id`, `drug_type_id`, `rack_id`, `is_active`, `created_by`, `created_at` FROM `hp_medicines` WHERE `is_active` LIKE '1'";
    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[$row['id']] = $row;
        }
    }
    return $ArrayResult;
}


function GetProMedicines($link, $CourseCode)
{
    $ArrayResult = array();
    $sql = "SELECT `id`, `CourseCode`, `MediID`, `status` FROM `hp_course_medicine` WHERE `status` LIKE 'Active' AND `CourseCode` LIKE '$CourseCode'";
    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[$row['MediID']] = $row["MediID"];
        }
    }
    return $ArrayResult;
}

function GetProSubmissions($link, $CountAnswer, $UserName)
{
    $ArrayResult = array();
    $sql = "SELECT `medicine_id` FROM `hp_save_answer` WHERE `index_number` LIKE '$UserName' AND `answer_status` LIKE 'Correct' GROUP BY `index_number`, `medicine_id` HAVING COUNT(*) >= $CountAnswer ORDER BY COUNT(*) DESC";
    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[] = $row["medicine_id"];
        }
    }
    return $ArrayResult;
}

function GetAllSubmissionsByMedicine($link, $UserName)
{
    $ArrayResult = array();
    $sql = "SELECT `medicine_id`, count(`medicine_id`) as `attemptCount` FROM `hp_save_answer` WHERE `index_number` LIKE '$UserName' GROUP BY `medicine_id`";
    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[] = $row;
        }
    }
    return $ArrayResult;
}

function GetAllSubmissions($link, $UserName)
{
    $ArrayResult = array();
    $sql = "SELECT * FROM `hp_save_answer` WHERE `index_number` LIKE '$UserName'";
    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[] = $row;
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

function GetHPCorrectAttempts($link, $IndexNumber)
{
    $ArrayResult = array();
    $sql = "SELECT * FROM `hp_save_answer` WHERE `index_number` LIKE '$IndexNumber' AND `answer_status` LIKE 'Correct'";
    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[] = $row;
        }
    }
    return $ArrayResult;
}

function GetAttemptResult($link, $IndexNumber)
{
    $ArrayResult = 0;
    $sql = "SELECT SUM(score) AS `score` FROM `hp_save_answer` WHERE `index_number` LIKE '$IndexNumber'";
    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult = $row["score"];
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


function GetHpAttemptCount($link, $IndexNumber)
{
    $ArrayResult = 0;
    $sql = "SELECT COUNT(score) AS `attempt_count` FROM `hp_save_answer` WHERE `index_number` LIKE '$IndexNumber'";
    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult = $row["attempt_count"];
        }
    }
    return $ArrayResult;
}

function GetGemCoinCounts($link, $IndexNumber)
{
    $ArrayResult = array();
    $sql = "SELECT `score_type`, COUNT(score) AS `attempt_count` FROM `hp_save_answer` WHERE `index_number` LIKE '$IndexNumber' AND `answer_status` LIKE 'Correct' GROUP BY `score_type`";
    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[$row['score_type']] = $row["attempt_count"];
        }
    }
    return $ArrayResult;
}
