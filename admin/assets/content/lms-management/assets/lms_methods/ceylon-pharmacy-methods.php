<?php

include __DIR__ . '/../../../../../include/config.php'; // Database Configuration

// Enable MySQLi error reporting
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

function GetUserRecoverAnswers()
{
    global $lms_link;

    // Initialize arrays to store results
    $arrayResult = array();

    // Get counts for each user
    $sql = "SELECT 
                student_id,
                SUM(CASE WHEN patient_status LIKE 'Pending' AND time < DATE_SUB(NOW(), INTERVAL 1 HOUR) THEN 1 ELSE 0 END) AS died_count,
                SUM(CASE WHEN patient_status LIKE 'Pending' AND time >= DATE_SUB(NOW(), INTERVAL 1 HOUR) THEN 1 ELSE 0 END) AS pending_count,
                SUM(CASE WHEN patient_status LIKE 'Recovered' THEN 1 ELSE 0 END) AS recovered_count
            FROM 
                care_start
            GROUP BY 
                student_id";

    $result = $lms_link->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Store data for each user
            $arrayResult[$row['student_id']] = array(
                'student_id' => $row['student_id'],
                'died_count' => $row['died_count'],
                'pending_count' => $row['pending_count'],
                'recovered_count' => $row['recovered_count']
            );
        }
    }

    return $arrayResult;
}



function GetCeylonPharmacyPatients()
{
    global $lms_link;
    $arrayResult = array();

    $sql_inner = "SELECT * FROM `care_patient`";
    $result_inner = $lms_link->query($sql_inner);
    if ($result_inner->num_rows > 0) {
        while ($row = $result_inner->fetch_assoc()) {
            $arrayResult[] = $row;
        }
    }

    return $arrayResult;
}

function GetPatients($lms_link)
{

    $ArrayResult = array();
    $sql = "SELECT `id`, `prescription_id`, `prescription_name`, `prescription_status`, `created_at`, `created_by`, `Pres_Name`, `pres_date`, `Pres_Age`, `Pres_Method`, `doctor_name`, `notes`, `patient_description`, `address` FROM `care_patient` ORDER BY id ASC";

    $result = $lms_link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[$row['prescription_id']] = $row;
        }
    }
    return $ArrayResult;
}

function GetPatientsRecoveriesByUser($studentNumber)
{

    global $lms_link;
    $ArrayResult = array();
    $sql = "SELECT * FROM `care_center_recovery` WHERE `student_number` LIKE '$studentNumber'";

    $result = $lms_link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[$row['id']] = $row;
        }
    }
    return $ArrayResult;
}

function GetTimer($lms_link, $loggedUser, $prescriptionID)
{
    $sql = "SELECT `time`, `patient_status` FROM `care_start` WHERE `patient_status` IN ('Pending', 'Recovered') AND `student_id` = '$loggedUser' AND `PresCode` = '$prescriptionID' ORDER BY `patient_status` DESC, `time` DESC LIMIT 1";
    $result = $lms_link->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $patient_status = $row['patient_status'];
        $time = $row["time"];
        $start_time = date('Y-m-d H:i', strtotime($time));
        $end_time = date('Y-m-d H:i', strtotime($time . ' + 1 hours'));

        if (time() > strtotime($end_time) && $patient_status == "Pending") {
            $patient_status = "Died";
        }

        $status = "success";
    } else {
        $status = "error";
        $patient_status = "Not Started";
        $start_time = $end_time = "Not Set";
    }

    return ['status' => $status, 'patient_status' => $patient_status, 'start_time' => $start_time, 'end_time' => $end_time];
}

function CheckCoursePatientAvailability($lms_link, $CourseCode, $prescriptionID)
{
    $value = false;
    $sql = "SELECT `id`, `CourseCode`, `prescription_id`, `status` FROM `care_center_course` WHERE `CourseCode` LIKE '$CourseCode' AND `prescription_id` LIKE '$prescriptionID' AND `status` LIKE 'Active'";
    $result = $lms_link->query($sql);
    if ($result->num_rows > 0) {
        $value = true;
    }

    return $value;
}
