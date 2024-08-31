<?php
include __DIR__ . '../../include/configuration.php';
// Enable MySQLi error reporting
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);


function GetPrescriptions()
{
    global $link;
    $ArrayResult = array();
    $sql = "SELECT `id`, `prescription_id`, `prescription_name`, `prescription_status`, `created_at`, `created_by`, `Pres_Name`, `pres_date`, `Pres_Age`, `Pres_Method`, `doctor_name`, `notes` FROM `prescription`";

    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[$row['prescription_id']] = $row;
        }
    }
    return $ArrayResult;
}



function GetPrescriptionCoversHunter($link, $prescriptionID)
{

    $ArrayResult = array();
    $sql = "SELECT `id`, `pres_code` AS `prescription_id`, `cover_id`, `content` FROM `prescription_content` WHERE `pres_code` LIKE '$prescriptionID' ORDER BY `id`";

    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[$row['cover_id']] = $row;
        }
    }
    return $ArrayResult;
}


function HunterSubmittedAnswersByCover($link, $loggedUser, $coverID, $prescriptionID, $answer_status)
{
    $ArrayResult = array();
    $sql = "SELECT `id`, `answer_id`, `pres_id`, `cover_id`, `date`, `name`, `drug_name`, `drug_type`, `drug_qty`, `morning_qty`, `afternoon_qty`, `evening_qty`, `night_qty`, `meal_type`, `using_type`, `at_a_time`, `hour_qty`, `additional_description`, `created_at`, `created_by`, `answer_status`, `score` FROM `prescription_answer_submission`  WHERE `created_by` LIKE '$loggedUser' AND `pres_id` LIKE '$prescriptionID' AND `cover_id` LIKE '$coverID' AND `answer_status` LIKE '$answer_status'";

    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[] = $row;
        }
    }
    return $ArrayResult;
}


function HunterGetSavedAnswersByCover($link, $prescriptionID, $coverID)
{
    $ArrayResult = array();
    $sql = "SELECT `id`, `answer_id`, `pres_id`, `cover_id`, `date`, `name`, `drug_name`, `drug_type`, `drug_qty`, `morning_qty`, `afternoon_qty`, `evening_qty`, `night_qty`, `meal_type`, `using_type`, `at_a_time`, `hour_qty`, `additional_description`, `created_at`, `created_by` FROM `prescription_answer` WHERE `pres_id` LIKE '$prescriptionID' AND `cover_id` LIKE '$coverID'";

    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[] = $row;
        }
    }
    return $ArrayResult;
}



function HunterMedicines()
{
    global $link;

    $sql = "SELECT * FROM `hunter_medicine` WHERE `active_status` NOT LIKE 'Deleted'";
    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[$row['id']] = $row;
        }
    }
    return $ArrayResult;
}

function HunterSavedAnswers()
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
            GROUP BY 
                `index_number`";

    $result = $link->query($sql);
    $ArrayResult = array(); // Initialize the array
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[$row['index_number']] = $row;
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
