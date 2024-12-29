<?php

include __DIR__ . '../../include/configuration.php';
include __DIR__ . '../../php_handler/sms-API.php';
// Enable MySQLi error reporting
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);


function GetPatients($link)
{

    $ArrayResult = array();
    $sql = "SELECT `id`, `prescription_id`, `prescription_name`, `prescription_status`, `created_at`, `created_by`, `Pres_Name`, `pres_date`, `Pres_Age`, `Pres_Method`, `doctor_name`, `notes`, `patient_description`, `address` FROM `care_patient` ORDER BY id ASC";

    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[$row['prescription_id']] = $row;
        }
    }
    return $ArrayResult;
}


function GetPrescriptionCovers($link, $prescriptionID)
{

    $ArrayResult = array();
    $sql = "SELECT `id`, `pres_code` AS `prescription_id`, `content`, `cover_id`  FROM `care_content` WHERE `pres_code` LIKE '$prescriptionID' ORDER BY `id`";

    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[$row['cover_id']] = $row;
        }
    }
    return $ArrayResult;
}

function formatLabelName($input)
{
    $formattedLabel = ucwords(str_replace('-', ' ', $input));
    return ucwords($formattedLabel);
}

function formatErrorResults($input)
{
    $formattedLabel = ucwords(str_replace('_', ' ', $input));
    return ucwords($formattedLabel);
}


function GetSavedAnswers($link)
{
    $ArrayResult = array();
    $sql = "SELECT `id`, `answer_id`, `pres_id`, `cover_id`, `date`, `name`, `drug_name`, `drug_type`, `drug_qty`, `morning_qty`, `afternoon_qty`, `evening_qty`, `night_qty`, `meal_type`, `using_type`, `at_a_time`, `hour_qty`, `additional_description`, `created_at`, `created_by` FROM `care_answer` ORDER BY `drug_name`";

    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[$row['answer_id']] = $row;
        }
    }
    return $ArrayResult;
}

function GetSavedAnswersByCover($link, $prescriptionID, $coverID)
{
    $ArrayResult = array();
    $sql = "SELECT `id`, `answer_id`, `pres_id`, `cover_id`, `date`, `name`, `drug_name`, `drug_type`, `drug_qty`, `morning_qty`, `afternoon_qty`, `evening_qty`, `night_qty`, `meal_type`, `using_type`, `at_a_time`, `hour_qty`, `additional_description`, `created_at`, `created_by` FROM `care_answer`WHERE `pres_id` LIKE '$prescriptionID' AND `cover_id` LIKE '$coverID'";

    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[] = $row;
        }
    }
    return $ArrayResult;
}



function GetUniqueValues($link, $columnName)
{
    $uniqueValues = array();
    $sql = "SELECT  DISTINCT `$columnName` FROM `care_answer` ORDER BY `$columnName`";

    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $uniqueValues[] = $row;
        }
    }
    return $uniqueValues;
}

function CeylonPharmacySubmittedAnswers($link)
{
    $ArrayResult = array();
    $sql = "SELECT `id`, `answer_id`, `pres_id`, `cover_id`, `date`, `name`, `drug_name`, `drug_type`, `drug_qty`, `morning_qty`, `afternoon_qty`, `evening_qty`, `night_qty`, `meal_type`, `using_type`, `at_a_time`, `hour_qty`, `additional_description`, `created_at`, `created_by`, `answer_status`, `score` FROM `care_answer_submit`";

    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[$row['answer_id']] = $row;
        }
    }
    return $ArrayResult;
}


function CeylonPharmacySubmittedAnswersByUser($link, $loggedUser)
{
    $ArrayResult = array();
    $sql = "SELECT `id`, `answer_id`, `pres_id`, `cover_id`, `date`, `name`, `drug_name`, `drug_type`, `drug_qty`, `morning_qty`, `afternoon_qty`, `evening_qty`, `night_qty`, `meal_type`, `using_type`, `at_a_time`, `hour_qty`, `additional_description`, `created_at`, `created_by`, `answer_status`, `score` FROM `care_answer_submit` WHERE `created_by` LIKE '$loggedUser'";

    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[$row['answer_id']] = $row;
        }
    }
    return $ArrayResult;
}



function CeylonPharmacySubmittedAnswersByCover($link, $loggedUser, $coverID, $prescriptionID, $answer_status)
{
    $ArrayResult = array();
    $sql = "SELECT `id`, `answer_id`, `pres_id`, `cover_id`, `date`, `name`, `drug_name`, `drug_type`, `drug_qty`, `morning_qty`, `afternoon_qty`, `evening_qty`, `night_qty`, `meal_type`, `using_type`, `at_a_time`, `hour_qty`, `additional_description`, `created_at`, `created_by`, `answer_status`, `score` FROM `care_answer_submit` WHERE `created_by` LIKE '$loggedUser' AND `pres_id` LIKE '$prescriptionID' AND `cover_id` LIKE '$coverID' AND `answer_status` LIKE '$answer_status'";

    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[] = $row;
        }
    }
    return $ArrayResult;
}

function CeylonPharmacySubmittedInstructionsByCover($link, $loggedUser, $coverID, $prescriptionID, $answer_status)
{
    $ArrayResult = array();
    $sql = "SELECT `id`, `LoggedUser`, `PresCode`, `Instruction`, `CoverCode`, `created_at`, `ans_status` FROM `care_ins_answer`  WHERE `LoggedUser` LIKE '$loggedUser' AND `PresCode` LIKE '$prescriptionID' AND `CoverCode` LIKE '$coverID' AND `ans_status` LIKE '$answer_status'";

    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[] = $row;
        }
    }
    return $ArrayResult;
}

function StartTreatments($link, $LoggedUser, $prescriptionID)
{
    $ArrayResult = array();
    $currentTime = date("Y-m-d H:i");
    $sql = "SELECT * FROM `care_start`  WHERE `student_id` LIKE '$LoggedUser' AND `PresCode` LIKE '$prescriptionID'";

    $result = $link->query($sql);
    if ($result->num_rows <= 0) {
        $sql = "INSERT INTO `care_start`(`student_id`, `PresCode`, `time`) VALUES  (?, ?, ?)";

        if ($stmt_sql = mysqli_prepare($link, $sql)) {

            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt_sql, "sss", $param_1, $param_2, $param_3);

            // Set parameters
            $param_1 = $LoggedUser;
            $param_2 = $prescriptionID;
            $param_3 = $currentTime;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt_sql)) {
                $ArrayResult = array('status' => 'success', 'message' => 'Care Center Treatments are Started');
            } else {
                $ArrayResult = array('status' => 'error', 'message' => 'Something went wrong. Please try again later. ' . $link->error);
            }

            // Close statement
            mysqli_stmt_close($stmt_sql);
        } else {
            $ArrayResult = array('status' => 'success', 'message' => 'Care Center Treatments are Already Started');
        }
    }

    return json_encode($ArrayResult);
}

function GetTimer($link, $loggedUser, $prescriptionID)
{
    $sql = "SELECT `time`, `patient_status` FROM `care_start` WHERE `patient_status` IN ('Pending', 'Recovered') AND `student_id` = '$loggedUser' AND `PresCode` = '$prescriptionID' ORDER BY `patient_status` DESC, `time` DESC LIMIT 1";
    $result = $link->query($sql);

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


function GetAllInstructions($link)
{

    $ArrayResult = array();
    $sql = "SELECT `id`, `created_by`, `instruction`, `created_at` FROM `care_instruction_pre`";

    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[$row['id']] = $row;
        }
    }
    return $ArrayResult;
}


function GetCorrectInstructions($link, $prescriptionID, $coverID)
{
    $ArrayResult = array();
    $sql = "SELECT `id`, `pres_code`, `cover_id`, `content`, `created_at` FROM `care_instruction` WHERE `pres_code` LIKE '$prescriptionID' AND `cover_id` LIKE '$coverID'";

    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[$row['id']] = $row;
        }
    }
    return $ArrayResult;
}


function GetDropdownOptions($link, $prescriptionID, $coverID)
{
    // Step 1: Get all available answers
    $allInstructions = GetAllInstructions($link);

    // Step 2: Get the correct answers for the given prescription and cover
    $correctInstructions = GetCorrectInstructions($link, $prescriptionID, $coverID);

    // Step 3: Filter out correct answers from the pool of all instructions
    $remainingInstructions = array_diff_key($allInstructions, $correctInstructions);

    // Step 4: Randomly select 5 additional answers from the remaining instructions
    $additionalInstructions = array_slice($remainingInstructions, 0, 5, true);

    // Step 5: Combine correct answers with the additional answers
    $dropdownOptions = $correctInstructions + $additionalInstructions;

    // Shuffle the combined options to ensure randomness
    shuffle($dropdownOptions);

    return $dropdownOptions;
}


function insertInstructions($link, $LoggedUser, $presCode, $coverId, $instructions)
{
    $currentTime = date("Y-m-d H:i:s");
    $answer_status = "Correct";

    // Prepare the INSERT statement
    $query = "INSERT INTO `care_ins_answer` (`LoggedUser`, `PresCode`, `Instruction`, `CoverCode`, `created_at`, `ans_status`) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($link, $query);

    // Check if the statement preparation was successful
    if ($stmt) {
        // Bind parameters to the prepared statement
        mysqli_stmt_bind_param($stmt, "ssssss", $LoggedUser, $presCode,  $instructionId,  $coverId, $currentTime, $answer_status);

        // Iterate over instructions and execute the statement
        foreach ($instructions as $instructionId) {
            // Set the instruction ID for the current iteration
            mysqli_stmt_execute($stmt);
        }
        $ArrayResult = array('status' => 'success', 'message' => 'Instruction saved Successfully');
        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        $ArrayResult = array('status' => 'error', 'message' => 'Something went wrong. Please try again later. ' . $link->error);
    }

    return json_encode($ArrayResult);
}

function GetSavedAnswersByUser($link, $LoggedUser, $presCode, $coverId)
{
    $ArrayResult = array();
    $sql = "SELECT `id`, `LoggedUser`, `PresCode`, `Instruction`, `CoverCode`, `created_at`, `ans_status` FROM `care_ins_answer` WHERE `PresCode` LIKE '$presCode' AND `CoverCode` LIKE '$coverId' AND `LoggedUser` LIKE '$LoggedUser'";

    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[$row['id']] = $row;
        }
    }
    return $ArrayResult;
}


function insertInstructionsSetup($link, $presCode, $coverId, $instructions)
{
    ClearSetupInstructions($link, $presCode, $coverId);
    $currentTime = date("Y-m-d H:i:s");
    $query = "INSERT INTO `care_instruction` (`pres_code`, `cover_id`, `content`, `created_at`) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($link, $query);

    // Check if the statement preparation was successful
    if ($stmt) {
        // Bind parameters to the prepared statement
        mysqli_stmt_bind_param($stmt, "ssss", $presCode, $coverId,  $instructionId, $currentTime);

        // Iterate over instructions and execute the statement
        foreach ($instructions as $instructionId) {
            // Set the instruction ID for the current iteration
            mysqli_stmt_execute($stmt);
        }
        $ArrayResult = array('status' => 'success', 'message' => 'Instruction saved Successfully');
        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        $ArrayResult = array('status' => 'error', 'message' => 'Something went wrong. Please try again later. ' . $link->error);
    }

    return json_encode($ArrayResult);
}


function ClearSetupInstructions($link, $presCode, $coverId)
{
    $sql = "DELETE FROM `care_instruction` WHERE `pres_code` LIKE ? AND `cover_id` LIKE ?";
    if ($stmt_sql = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt_sql, "ss", $presCode, $coverId);
        if (mysqli_stmt_execute($stmt_sql)) {
            $error = array('status' => 'success', 'message' => 'Instructions Cleared successfully');
        } else {
            $error = array('status' => 'error', 'message' => 'Something went wrong. Please try again later. ' . $link->error);
        }
        mysqli_stmt_close($stmt_sql);
    } else {
        $error = array('status' => 'error', 'message' => 'Something went wrong. Please try again later. ' . $link->error);
    }
    return json_encode($error);
}


function saveOrUpdateAnswer($link, $presID, $coverID, $name, $drugName, $drugType, $drugQty, $morningQty, $afternoonQty, $eveningQty, $nightQty, $mealType, $usingType, $atATime, $hourQty, $additionalDescription, $createdBy, $date)
{
    $ArrayResult = array();
    $currentTime = date('Y-m-d H:i:s'); // Current date and time
    $answer_id = GenerateAnswerID($link);
    // Check if a record already exists for the given pres_id and cover_id
    $checkStmt = $link->prepare("SELECT id FROM care_answer WHERE pres_id=? AND cover_id=?");
    $checkStmt->bind_param("ss", $presID, $coverID);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        $sql = "UPDATE care_answer SET `answer_id` = ?, `name`=?, drug_name=?, drug_type=?, drug_qty=?, morning_qty=?, afternoon_qty=?, evening_qty=?, night_qty=?, meal_type=?, using_type=?, at_a_time=?, hour_qty=?, additional_description=?, created_at=?, created_by=?,  `date` = ? WHERE pres_id=? AND cover_id=?";

        if ($stmt_sql = mysqli_prepare($link, $sql)) {

            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt_sql, "sssssssssssssssssss", $answer_id, $name, $drugName, $drugType, $drugQty, $morningQty, $afternoonQty, $eveningQty, $nightQty, $mealType, $usingType, $atATime, $hourQty, $additionalDescription, $currentTime, $createdBy, $date, $presID, $coverID);


            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt_sql)) {
                $ArrayResult = array('status' => 'success', 'message' => 'Envelope updated successfully');
            } else {
                $ArrayResult = array('status' => 'error', 'message' => 'Something went wrong. Please try again later. ' . $link->error);
            }

            // Close statement
            mysqli_stmt_close($stmt_sql);
        } else {
            $ArrayResult = array('status' => 'error', 'message' => 'Something went wrong. Please try again later. ' . $link->error);
        }
    } else {

        $sql = "INSERT INTO care_answer (`answer_id`, pres_id, cover_id, `date`, `name`, drug_name, drug_type, drug_qty, morning_qty, afternoon_qty, evening_qty, night_qty, meal_type, using_type, at_a_time, hour_qty, additional_description, created_at, created_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        if ($stmt_sql = mysqli_prepare($link, $sql)) {

            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt_sql, "sssssssssssssssssss", $answer_id, $presID, $coverID, $date, $name, $drugName, $drugType, $drugQty, $morningQty, $afternoonQty, $eveningQty, $nightQty, $mealType, $usingType, $atATime, $hourQty, $additionalDescription, $currentTime, $createdBy);


            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt_sql)) {
                $ArrayResult = array('status' => 'success', 'message' => 'Care Center Treatments are Started');
            } else {
                $ArrayResult = array('status' => 'error', 'message' => 'Something went wrong. Please try again later. ' . $link->error);
            }

            // Close statement
            mysqli_stmt_close($stmt_sql);
        } else {
            $ArrayResult = array('status' => 'error', 'message' => 'Something went wrong. Please try again later. ' . $link->error);
        }
    }

    // Convert the array to JSON and echo it
    return json_encode($ArrayResult);
}




function GenerateAnswerID($link)
{
    $ArrayResult = 0;
    $sql = "SELECT COUNT(`id`) AS `entry_count` FROM `care_answer`";

    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult = $row['entry_count'];
        }
    }
    $answer_id =  $ArrayResult + 1;
    return "ANS" . $answer_id;
}




function SaveAnswerAdmin($link, $answer_type, $answer, $ansID)
{
    $currentTime = date("Y-m-d H:i:s");
    if ($ansID == 0) {
        $query = "INSERT INTO `care_saved_answers` (`answer_type`, `answer`) VALUES (?, ?)";
    } else {
        $query = "UPDATE `care_saved_answers` SET `answer_type` = ?, `answer` = ? WHERE `id` LIKE '$ansID'";
    }

    $stmt = mysqli_prepare($link, $query);

    // Check if the statement preparation was successful
    if ($stmt) {
        // Bind parameters to the prepared statement
        mysqli_stmt_bind_param($stmt, "ss", $answer_type, $answer);

        // Set the instruction ID for the current iteration
        mysqli_stmt_execute($stmt);
        $ArrayResult = array('status' => 'success', 'message' => 'Answer saved Successfully');
        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        $ArrayResult = array('status' => 'error', 'message' => 'Something went wrong. Please try again later. ' . $link->error);
    }

    return json_encode($ArrayResult);
}


function GetAnswerListAdmin($link)
{

    $ArrayResult = array();
    $sql = " SELECT `id`, `answer_type`, `answer` FROM `care_saved_answers`";

    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[$row['id']] = $row;
        }
    }
    return $ArrayResult;
}


function GetPaymentValue($link, $prescriptionID)
{
    $value = 0;
    $sql = "SELECT `PresCode`, `value` FROM `care_payment` WHERE `PresCode` LIKE '$prescriptionID'";
    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $value = $row["value"];
        }
    }

    return $value;
}


function FinishTreatments($link, $loggedUser, $prescriptionID)
{

    $ArrayResult = array();
    $sql = "UPDATE `care_start` SET `patient_status` = ? WHERE `student_id` LIKE '$loggedUser' AND `PresCode` LIKE '$prescriptionID'";
    if ($stmt_sql = mysqli_prepare($link, $sql)) {

        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt_sql, "s", $param_1);

        // Set parameters
        $param_1 = "Recovered";

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt_sql)) {
            $ArrayResult = array('status' => 'success', 'message' => 'Care Center Treatments are Ended');
        } else {
            $ArrayResult = array('status' => 'error', 'message' => 'Something went wrong. Please try again later. ' . $link->error);
        }

        // Close statement
        mysqli_stmt_close($stmt_sql);
    } else {
        $ArrayResult = array('status' => 'error', 'message' => 'Something went wrong. Please try again later. ' . $link->error);
    }

    return json_encode($ArrayResult);
}


function SetPaymentValue($link, $prescriptionID, $paymentValue)
{

    $checkStmt = $link->prepare("SELECT `id` FROM `care_payment` WHERE `PresCode` = ?");
    $checkStmt->bind_param("s", $prescriptionID);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows <= 0) {
        $query = "INSERT INTO `care_payment` (`value`, `PresCode`) VALUES (?, ?)";
    } else {
        $query = "UPDATE `care_payment` SET `value` = ? WHERE `PresCode` LIKE ?";
    }

    $stmt = mysqli_prepare($link, $query);

    // Check if the statement preparation was successful
    if ($stmt) {
        // Bind parameters to the prepared statement
        mysqli_stmt_bind_param($stmt, "ss", $paymentValue, $prescriptionID);

        // Set the instruction ID for the current iteration
        mysqli_stmt_execute($stmt);
        $ArrayResult = array('status' => 'success', 'message' => 'Payment saved Successfully');
        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        $ArrayResult = array('status' => 'error', 'message' => 'Something went wrong. Please try again later. ' . $link->error);
    }

    return json_encode($ArrayResult);
}


function GetUserPaymentAnswer($link, $loggedUser, $prescriptionID, $answerStatus)
{
    $value = 0;
    $sql = "SELECT `id`, `student_id`, `PresCode`, `answer`, `created_at`, `ans_status` FROM `care_payment_answer` WHERE `student_id` LIKE '$loggedUser' AND `PresCode` LIKE '$prescriptionID' AND `ans_status` LIKE '$answerStatus'";
    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $value = $row["answer"];
        }
    }

    return $value;
}


function CheckCoursePatientAvailability($link, $CourseCode, $prescriptionID)
{
    $value = false;
    $sql = "SELECT `id`, `CourseCode`, `prescription_id`, `status` FROM `care_center_course` WHERE `CourseCode` LIKE '$CourseCode' AND `prescription_id` LIKE '$prescriptionID' AND `status` LIKE 'Active'";
    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        $value = true;
    }

    return $value;
}


function GetCoursePatients($link, $CourseCode)
{
    $ArrayResult = array();
    $sql = "SELECT `id`, `CourseCode`, `prescription_id`, `status` FROM `care_center_course` WHERE `CourseCode` LIKE '$CourseCode' AND `status` LIKE 'Active'";

    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[$row['id']] = $row;
        }
    }
    return $ArrayResult;
}

function GetRecoveredPatientsByCourse($link, $CourseCode, $loggedUser)
{
    $ArrayResult = 0;
    $sql = "SELECT `id`, `CourseCode`, `prescription_id`, `status` FROM `care_center_course` WHERE `CourseCode` LIKE '$CourseCode' AND `status` LIKE 'Active'";

    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $prescription_id = $row['prescription_id'];
            $patient_status = GetTimer($link, $loggedUser, $prescription_id)['patient_status'];

            if ($patient_status == "Recovered") {
                $ArrayResult += 1;
            }
        }
    }
    return $ArrayResult;
}




function GetCompanyDetails($link)
{
    $ArrayResult = array();
    $sql = "SELECT `id`, `company_name`, `company_address`, `company_address2`, `company_city`, `company_postalcode`, `company_email`, `company_telephone`, `company_telephone2`, `job_position` , `owner_name` FROM `company`";
    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[$row['id']] = $row;
        }
    }

    return $ArrayResult;
}


function GetUserDetails($link, $UserName)
{
    $ArrayResult = array();
    $sql = "SELECT * FROM `user_full_details` WHERE `username` LIKE '$UserName'";
    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[$row['username']] = $row;
        }
    }

    return $ArrayResult[$UserName];
}



function GetDeliverySetting($link, $CourseCode)
{
    $ArrayResult = array();
    $sql = "SELECT * FROM `delivery_setting` WHERE `course_id` LIKE '$CourseCode'";
    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[$row['id']] = $row;
        }
    }

    return $ArrayResult;
}


function GetCourses($link)
{
    $ArrayResult = array();
    $sql = "SELECT * FROM `course`";
    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[$row['course_code']] = $row;
        }
    }

    return $ArrayResult;
}


function SaveDelivery($link, $course_id, $delivery_title, $is_active, $icon, $value, $selectedId)
{
    $error = array();
    if ($selectedId == 0) {
        $sql = "INSERT INTO `delivery_setting` (`course_id`, `delivery_title`, `is_active`, `icon`, `value`) VALUES (?, ?, ?, ?, ?)";
    } else {
        $sql = "UPDATE `delivery_setting` SET `course_id` = ?, `delivery_title` = ?, `is_active` = ?, `icon` = ?, `value` = ? WHERE `id` LIKE '$selectedId'";
    }

    if ($stmt_sql = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt_sql, "sssss",  $course_id, $delivery_title, $is_active, $icon, $value);
        if (mysqli_stmt_execute($stmt_sql)) {
            $error = array('status' => 'success', 'message' => 'Delivery Item saved successfully');
        } else {
            $error = array('status' => 'error', 'message' => 'Something went wrong. Please try again later. ' . $link->error);
        }
        mysqli_stmt_close($stmt_sql);
    } else {
        $error = array('status' => 'error', 'message' => 'Something went wrong. Please try again later. ' . $link->error);
    }

    return json_encode($error);
}


function PlaceOrder($link, $delivery_id, $tracking_number, $index_number, $order_date, $current_status, $value, $payment_method, $course_code, $fullName, $street_address, $city, $district, $phone_1, $phone_2)
{
    $error = array();
    $sql = "INSERT INTO `delivery_orders` (`delivery_id`, `tracking_number`, `index_number`, `order_date`,  `current_status`, `value`, `payment_method`, `course_code`,  `full_name`, `street_address`, `city`, `district`, `phone_1`, `phone_2`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    if ($stmt_sql = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt_sql, "ssssssssssssss",  $delivery_id, $tracking_number, $index_number, $order_date,  $current_status, $value, $payment_method, $course_code, $fullName, $street_address, $city, $district, $phone_1, $phone_2);
        if (mysqli_stmt_execute($stmt_sql)) {
            $error = array('status' => 'success', 'message' => 'Order Placed successfully');

            $deliveryItem = GetDeliverySetting($link, $course_code)[$delivery_id]['delivery_title'];
            $messageText = 'Dear ' . $index_number . ',

Your Order has been Placed Successfully!

Product - ' . $deliveryItem . ' 

Thank you!
Ceylon Pharma College
www.pharmacollege.lk';
            SentSMS($phone_1, 'Pharma C.', $messageText);
        } else {
            $error = array('status' => 'error', 'message' => 'Something went wrong. Please try again later. ' . $link->error);
        }
        mysqli_stmt_close($stmt_sql);
    } else {
        $error = array('status' => 'error', 'message' => 'Something went wrong. Please try again later. ' . $link->error);
    }

    return json_encode($error);
}

function GetDeliveryOrders($link, $delivery_id, $index_number)
{
    $ArrayResult = array();
    $sql = "SELECT * FROM `delivery_orders` WHERE `delivery_id` LIKE '$delivery_id' AND `index_number` LIKE '$index_number' && `current_status` != 0";
    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[] = $row;
        }
    }

    return $ArrayResult;
}

function GetDeliveryOrdersByUserAndBatch($link, $index_number, $CourseCode)
{
    $ArrayResult = array();
    $ArrayResult = array();
    $sql = "SELECT * FROM `delivery_orders` WHERE `index_number` LIKE '$index_number' AND `course_code` LIKE '$CourseCode'";
    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[$row['id']] = $row;
        }
    }

    return $ArrayResult;
}

function GetOrder($link, $tracking_number)
{
    $ArrayResult = array();
    $sql = "SELECT * FROM `delivery_orders` WHERE `tracking_number` LIKE '$tracking_number'";
    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[$row['tracking_number']] = $row;
        }
    }

    return $ArrayResult[$tracking_number];
}

function GetDeliveryOrdersByUser($link, $index_number)
{
    $ArrayResult = array();
    $sql = "SELECT * FROM `delivery_orders` WHERE `index_number` LIKE '$index_number'";
    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[$row['id']] = $row;
        }
    }

    return $ArrayResult;
}

function getUserEnrollments($userName)
{
    $ArrayResult = array();
    global $link;
    $studentId = GetLmsStudentsByUserName($userName)['student_id'];
    $sql = "SELECT `id`, `course_code`, `student_id`, `enrollment_key`, `created_at` FROM `student_course` WHERE `student_id` LIKE '$studentId' ORDER BY `id` DESC";
    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[] = $row;
        }
    }
    return $ArrayResult;
}

function GetLmsStudentsByUserName($userName)
{
    $ArrayResult = array();
    global $link;

    $sql = "SELECT `id`, `student_id`, `username`, `civil_status`, `first_name`, `last_name`, `gender`, `address_line_1`, `address_line_2`, `city`, `district`, `postal_code`, `telephone_1`, `telephone_2`, `nic`, `e_mail`, `birth_day`, `updated_by`, `updated_at`, `full_name`, `name_with_initials`, `name_on_certificate` FROM `user_full_details` WHERE `username` LIKE '$userName'  ORDER BY `id` DESC";
    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[$row['username']] = $row;
        }
    }
    return $ArrayResult[$userName];
}

function GetLmsStudent()
{
    $ArrayResult = array();
    global $link;

    $sql = "SELECT `id`, `status_id`, `userid`, `fname`, `lname`, `batch_id`, `username`, `phone`, `email`, `password`, `userlevel`, `status`, `created_by`, `created_at`, `batch_lock` FROM `users` ORDER BY `id` DESC";
    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[$row['username']] = $row;
        }
    }
    return $ArrayResult;
}


function SaveDefaultValues($LoggedUser, $changeValue, $changeTitle)
{
    $error = array();
    global $link;

    $sql_inner = "SELECT `id` FROM `default_values` WHERE `index_number` LIKE '$LoggedUser' AND `title` LIKE 'Course'";
    $result_inner = $link->query($sql_inner);
    if ($result_inner->num_rows > 0) {
        $sql = "UPDATE `default_values` SET `index_number` = ?, `title` = ?, `value`= ? WHERE `index_number` LIKE '$LoggedUser' AND `title` LIKE '$changeTitle'";
    } else {
        $sql = "INSERT INTO `default_values`(`index_number`, `title`, `value`) VALUES (?, ?, ?)";
    }

    if ($stmt_sql = mysqli_prepare($link, $sql)) {

        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt_sql, "sss", $LoggedUser, $changeTitle, $changeValue);

        if (mysqli_stmt_execute($stmt_sql)) {
            $error = array('status' => 'success', 'message' => 'Default values updated successfully');
        } else {
            $error = array('status' => 'error', 'message' => 'Something went wrong. Please try again later. ' . $link->error);
        }
        mysqli_stmt_close($stmt_sql);
    } else {
        $error = array('status' => 'error', 'message' => 'Something went wrong. Please try again later. ' . $link->error);
    }

    return json_encode($error);
}



function GetDefaultCourseValue($sessionUser)
{
    global $link;
    $EnrolledCourseCode = "";
    // Get Default Course
    $sql = "SELECT `id`, `index_number`, `title`, `value` FROM `default_values` WHERE `index_number` LIKE '$sessionUser' AND `title` LIKE 'Course'";
    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $title = $row["title"];
            $EnrolledCourseCode = $row["value"];
        }
    }

    return  $EnrolledCourseCode;
}

function getTokenDetails($studentNumber, $email)
{
    global $link;
    $ArrayResult = array();

    // Get Default Course
    $sql = "SELECT `id`, `email`, `token`, `is_active`, `date_time`, `student_number`, `otp` FROM `reset_token` WHERE `student_number` LIKE '$studentNumber' AND `email` LIKE '$email' AND `is_active` LIKE  1";
    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[] = $row;
        }
    }

    return $ArrayResult;
}


function timeAgo($timestamp)
{
    $currentTimestamp = time();
    $timeDifference = $currentTimestamp - $timestamp;

    $minute = 60;
    $hour = 60 * $minute;
    $day = 24 * $hour;
    $week = 7 * $day;
    $month = 30 * $day;
    $year = 365 * $day;

    if ($timeDifference < $minute) {
        $timeAgo = ($timeDifference == 1) ? "1 second ago" : $timeDifference . " seconds ago";
    } elseif ($timeDifference < $hour) {
        $minutes = floor($timeDifference / $minute);
        $timeAgo = ($minutes == 1) ? "1 minute ago" : $minutes . " minutes ago";
    } elseif ($timeDifference < $day) {
        $hours = floor($timeDifference / $hour);
        $timeAgo = ($hours == 1) ? "1 hour ago" : $hours . " hours ago";
    } elseif ($timeDifference < $week) {
        $days = floor($timeDifference / $day);
        $timeAgo = ($days == 1) ? "1 day ago" : $days . " days ago";
    } elseif ($timeDifference < $month) {
        $weeks = floor($timeDifference / $week);
        $timeAgo = ($weeks == 1) ? "1 week ago" : $weeks . " weeks ago";
    } elseif ($timeDifference < $year) {
        $months = floor($timeDifference / $month);
        $timeAgo = ($months == 1) ? "1 month ago" : $months . " months ago";
    } else {
        $years = floor($timeDifference / $year);
        $timeAgo = ($years == 1) ? "1 year ago" : $years . " years ago";
    }

    return $timeAgo;
}


function SaveResetToken($email, $token, $is_active, $student_number, $otp)
{
    global $link;
    $error = "";
    $CurrentTime = date("Y-m-d H:i:s");

    $updatePreTokens = UpdateOTP($student_number, $email, 0);
    $is_active = 1;

    $sql = "INSERT INTO `reset_token`(`email`, `token`, `is_active`, `date_time`, `student_number`, `otp`)  VALUES (?, ?, ?, ?, ?, ?)";
    if ($stmt_sql = mysqli_prepare($link, $sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt_sql, "ssssss", $param_1, $param_2, $param_3, $param_4, $param_5, $param_6);

        // Set parameters
        $param_1 = $email;
        $param_2 = $token;
        $param_3 = $is_active;
        $param_4 = $CurrentTime;
        $param_5 = $student_number;
        $param_6 = $otp;

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt_sql)) {
            $error = array('status' => 'success', 'message' => 'Reset Password link sent successfully');
        } else {
            $error = array('status' => 'error', 'message' => 'Something went wrong. Please try again later. ' . $link->error);
        }

        // Close statement
        mysqli_stmt_close($stmt_sql);
    } else {
        $error = array('status' => 'error', 'message' => 'Something went wrong. Please try again later. ' . $link->error);
    }

    return json_encode($error);
}

function generateOTP()
{
    // Generate a random 6-digit number
    $otp = rand(100000, 999999);

    return $otp;
}


function UpdateOTP($studentNumber, $email, $is_active)
{
    global $link;

    $sql = "UPDATE `reset_token` SET `is_active` = ? WHERE `student_number` LIKE '$studentNumber' AND `email` LIKE '$email' AND `is_active` LIKE  1";

    if ($stmt_sql = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt_sql, "s",  $is_active);
        if (mysqli_stmt_execute($stmt_sql)) {
            $error = array('status' => 'success', 'message' => 'Updated Previous Tokens');
        } else {
            $error = array('status' => 'error', 'message' => 'Something went wrong. Please try again later. ' . $link->error);
        }
        mysqli_stmt_close($stmt_sql);
    } else {
        $error = array('status' => 'error', 'message' => 'Something went wrong. Please try again later. ' . $link->error);
    }

    return json_encode($error);
}


function formatPhoneNumber($phoneNumber)
{
    // Check if the length of the phone number is 9
    if (strlen($phoneNumber) == 9) {
        // If yes, add '0' at the beginning
        $formattedNumber = '0' . $phoneNumber;
    } else {
        // If no, use the normal phone number
        $formattedNumber = $phoneNumber;
    }

    return $formattedNumber;
}


// Dpad

function GenerateDpadAnswerID($link)
{
    $ArrayResult = 0;
    $sql = "SELECT COUNT(`id`) AS `entry_count` FROM `prescription_answer`";

    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult = $row['entry_count'];
        }
    }
    $answer_id =  $ArrayResult + 1;
    return "ANS" . $answer_id;
}


function saveOrUpdateAnswerDPad($link, $presID, $coverID, $name, $drugName, $drugType, $drugQty, $morningQty, $afternoonQty, $eveningQty, $nightQty, $mealType, $usingType, $atATime, $hourQty, $additionalDescription, $createdBy, $date)
{
    $ArrayResult = array();
    $currentTime = date('Y-m-d H:i:s'); // Current date and time
    $answer_id = GenerateDpadAnswerID($link);
    // Check if a record already exists for the given pres_id and cover_id
    $checkStmt = $link->prepare("SELECT id FROM prescription_answer WHERE pres_id= ? AND cover_id= ?");
    $checkStmt->bind_param("ss", $presID, $coverID);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        $sql = "UPDATE prescription_answer SET `answer_id` = ?, `name`=?, drug_name=?, drug_type=?, drug_qty=?, morning_qty=?, afternoon_qty=?, evening_qty=?, night_qty=?, meal_type=?, using_type=?, at_a_time=?, hour_qty=?, additional_description=?, created_at=?, created_by=?,  `date` = ? WHERE pres_id=? AND cover_id=?";

        if ($stmt_sql = mysqli_prepare($link, $sql)) {

            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt_sql, "sssssssssssssssssss", $answer_id, $name, $drugName, $drugType, $drugQty, $morningQty, $afternoonQty, $eveningQty, $nightQty, $mealType, $usingType, $atATime, $hourQty, $additionalDescription, $currentTime, $createdBy, $date, $presID, $coverID);


            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt_sql)) {
                $ArrayResult = array('status' => 'success', 'message' => 'Envelope updated successfully');
            } else {
                $ArrayResult = array('status' => 'error', 'message' => 'Something went wrong. Please try again later. ' . $link->error);
            }

            // Close statement
            mysqli_stmt_close($stmt_sql);
        } else {
            $ArrayResult = array('status' => 'error', 'message' => 'Something went wrong. Please try again later. ' . $link->error);
        }
    } else {

        $sql = "INSERT INTO prescription_answer (`answer_id`, pres_id, cover_id, `date`, `name`, drug_name, drug_type, drug_qty, morning_qty, afternoon_qty, evening_qty, night_qty, meal_type, using_type, at_a_time, hour_qty, additional_description, created_at, created_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        if ($stmt_sql = mysqli_prepare($link, $sql)) {

            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt_sql, "sssssssssssssssssss", $answer_id, $presID, $coverID, $date, $name, $drugName, $drugType, $drugQty, $morningQty, $afternoonQty, $eveningQty, $nightQty, $mealType, $usingType, $atATime, $hourQty, $additionalDescription, $currentTime, $createdBy);


            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt_sql)) {
                $ArrayResult = array('status' => 'success', 'message' => 'Envelope Saved successfully');
            } else {
                $ArrayResult = array('status' => 'error', 'message' => 'Something went wrong. Please try again later. ' . $link->error);
            }

            // Close statement
            mysqli_stmt_close($stmt_sql);
        } else {
            $ArrayResult = array('status' => 'error', 'message' => 'Something went wrong. Please try again later. ' . $link->error);
        }
    }

    // Convert the array to JSON and echo it
    return json_encode($ArrayResult);
}



function GetCities($link)
{

    $ArrayResult = array();
    $sql = "SELECT `id`, `district_id`, `name_en`, `name_si`, `name_ta`, `sub_name_en`, `sub_name_si`, `sub_name_ta`, `postcode`, `latitude`, `longitude` FROM `cities` ORDER BY `name_en`";

    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[$row['id']] = $row;
        }
    }
    return $ArrayResult;
}

function getDistricts($link)
{
    $sql = "SELECT `id`, `province_id`, `name_en`, `name_si`, `name_ta` FROM `districts`";
    $ArrayResult = array();
    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[$row['id']] = $row;
        }
    }
    return $ArrayResult;
}

function saveProfileEditRequest($username, $civil_status, $first_name, $last_name, $gender, $address_line_1, $address_line_2, $city, $district, $postal_code, $telephone_1, $telephone_2, $nic, $e_mail, $birth_day, $full_name, $name_with_initials, $name_on_certificate)
{
    global $link;
    $error = "";
    $CurrentTime = date("Y-m-d H:i:s");
    $sql = "SELECT * FROM `edit_profile_temp` WHERE `active_status` LIKE 'Pending' AND `username` LIKE '$username'";
    $result = $link->query($sql);
    if ($result->num_rows <= 0) {


        $sql = "INSERT INTO `edit_profile_temp`(`username`, `civil_status`, `first_name`, `last_name`, `gender`, `address_line_1`, `address_line_2`, `city`, `district`, `postal_code`, `telephone_1`, `telephone_2`, `nic`, `e_mail`, `birth_day`, `full_name`, `name_with_initials`, `name_on_certificate` ) VALUES  (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        if ($stmt_sql = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt_sql, "ssssssssssssssssss", $username, $civil_status, $first_name, $last_name, $gender, $address_line_1, $address_line_2, $city, $district, $postal_code, $telephone_1, $telephone_2, $nic, $e_mail, $birth_day, $full_name, $name_with_initials, $name_on_certificate);

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt_sql)) {
                $error = array('status' => 'success', 'message' => 'Profile edit request saved successfully');
            } else {
                $error = array('status' => 'error', 'message' => 'Something went wrong. Please try again later. ' . mysqli_error($link));
            }

            // Close statement
            mysqli_stmt_close($stmt_sql);
        } else {
            $error = array('status' => 'error', 'message' => 'Something went wrong. Please try again later. ' . mysqli_error($link));
        }
    } else {
        $error = array('status' => 'error', 'message' => 'Please Wait.. You have Already Submitted & We are not reviewed yet!');
    }

    return $error;
}


function renderTemplate($templateFile, $variables)
{
    extract($variables); // Extracts the variables to a local namespace
    ob_start(); // Start output buffering
    include $templateFile; // Include the template file
    return ob_get_clean(); // Get the contents of the buffer and clean it
}


function limitText($text, $limit)
{
    $text = strip_tags($text); // Remove HTML tags
    if (strlen($text) <= $limit) {
        return $text;
    }
    $text = substr($text, 0, $limit);
    $lastSpace = strrpos($text, ' ');
    if ($lastSpace !== false) {
        $text = substr($text, 0, $lastSpace);
    }
    return $text . '...';
}
