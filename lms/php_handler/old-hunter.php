<?php
include __DIR__ . '../../include/configuration.php';
// Enable MySQLi error reporting
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

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
