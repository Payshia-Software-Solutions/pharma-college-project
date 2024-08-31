<?php

include __DIR__ . '../../../../include/configuration.php';
// Enable MySQLi error reporting
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

function GetPatientsRecoveries()
{

    global $link;
    $ArrayResult = array();
    $sql = "SELECT * FROM `care_center_recovery`";

    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[$row['id']] = $row;
        }
    }
    return $ArrayResult;
}


function GetPatientsRecoveriesByUser($studentNumber)
{

    global $link;
    $ArrayResult = array();
    $sql = "SELECT * FROM `care_center_recovery` WHERE `student_number` LIKE '$studentNumber'";

    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[$row['id']] = $row;
        }
    }
    return $ArrayResult;
}
