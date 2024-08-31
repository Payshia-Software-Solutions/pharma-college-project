<?php
require_once '../../../include/configuration.php';
include '../../../php_handler/function_handler.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $LoggedUser = $_POST['LoggedUser'];
    $UserLevel = $_POST['UserLevel'];

    $prescriptionID = $_POST['prescriptionID'];
    $coverID = $_POST['coverID'];
    $envelopeDate = $_POST['envelope-date'];
    $envelopeName = $_POST['envelope-name'];
    $envelopeDrugName = $_POST['envelope-drug-name'];
    $envelopeDrugType = $_POST['envelope-dosage-form'];
    $envelopeDrugQuantity = $_POST['envelope-drug-quantity'];
    $envelopeMorningQuantity = $_POST['envelope-morning-quantity'];
    $envelopeAfternoonQuantity = $_POST['envelope-afternoon-quantity'];
    $envelopeEveningQuantity = $_POST['envelope-evening-quantity'];
    $envelopeNightQuantity = $_POST['envelope-night-quantity'];
    $envelopeMealType = $_POST['envelope-meal-type'];
    $envelopeUsingFrequency = $_POST['envelope-using-frequency'];
    $envelopeAtATime = $_POST['envelope-at-a-time'];
    $envelopeUsingFrequencyHour = $_POST['envelope-using-frequency-hour'];
    $envelopeAdditionalDescription = $_POST['envelope-additional-instruction'];

    // Create an array to store the validation results
    $validationResults = array();

    // Define the fields and their corresponding values
    $fields = array(
        'date' => $envelopeDate,
        'name' => $envelopeName,
        'drug_name' => $envelopeDrugName,
        'drug_type' => $envelopeDrugType,
        'drug_qty' => $envelopeDrugQuantity,
        'morning_qty' => $envelopeMorningQuantity,
        'afternoon_qty' => $envelopeAfternoonQuantity,
        'evening_qty' => $envelopeEveningQuantity,
        'night_qty' => $envelopeNightQuantity,
        'meal_type' => $envelopeMealType,
        'using_type' => $envelopeUsingFrequency,
        'at_a_time' => $envelopeAtATime,
        'hour_qty' => $envelopeUsingFrequencyHour,
        'additional_description' => $envelopeAdditionalDescription
    );

    // Initialize an array to track incorrect fields
    $incorrectFields = array();

    foreach ($fields as $field => $value) {
        $sql = "SELECT * FROM care_answer WHERE $field = '$value' AND `pres_id` LIKE '$prescriptionID' AND `cover_id` LIKE '$coverID'";
        $result = mysqli_query($link, $sql);

        if (mysqli_num_rows($result) === 0) {
            // The value for this field is incorrect
            $incorrectFields[] = $field;
        }
    }


    if (empty($incorrectFields)) {
        $answer_status = "Correct";
        $score = 10;
    } else {
        $score = -1;
        $answer_status = "In-Correct";
    }


    if ($UserLevel == "Student") {

        $sql = "SELECT `answer_id` FROM `care_answer_submit` WHERE `cover_id` = '$coverID' AND `pres_id` = '$prescriptionID' AND `answer_status` = 'Correct' AND `created_by` = '$LoggedUser'";

        $result = $link->query($sql);

        if ($result->num_rows > 0) {
            $error = array('status' => 'error', 'message' => 'Already Saved Correct Attempt');
        } else {
            // Prepare a SQL statement to get the count and generate the new code
            $sql = "SELECT COUNT(answer_id) as count FROM care_answer_submit";
            $result = $link->query($sql);

            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $previous_code = $row["count"];
                $NewAnswerSubmitCode = "UA" . ($previous_code + 1);
            } else {
                // Handle the case where the count couldn't be retrieved
                $NewAnswerSubmitCode = "UA1"; // Default value or error handling
            }


            $sql = "INSERT INTO `care_answer_submit`(`answer_id`, `pres_id`, `cover_id`, `date`, `name`, `drug_name`, `drug_type`, `drug_qty`, `morning_qty`, `afternoon_qty`, `evening_qty`, `night_qty`, `meal_type`, `using_type`, `at_a_time`, `hour_qty`, `additional_description`, `created_by`, `answer_status`, `score`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt_sql = mysqli_prepare($link, $sql);
            mysqli_stmt_bind_param($stmt_sql, "ssssssssssssssssssss", $NewAnswerSubmitCode, $prescriptionID, $coverID, $envelopeDate, $envelopeName, $envelopeDrugName, $envelopeDrugType, $envelopeDrugQuantity, $envelopeMorningQuantity, $envelopeAfternoonQuantity, $envelopeEveningQuantity, $envelopeNightQuantity, $envelopeMealType, $envelopeUsingFrequency, $envelopeAtATime, $envelopeUsingFrequencyHour, $envelopeAdditionalDescription, $LoggedUser, $answer_status, $score);

            if (mysqli_stmt_execute($stmt_sql)) {
                $error = array('status' => 'success', 'message' => 'Answer Saved', 'incorrect_values' => $incorrectFields, 'answer_status' => $answer_status);
            } else {
                $error = array('status' => 'error', 'message' => 'Something went wrong. Please try again later. ' . $link->error, 'incorrect_values' => $incorrectFields, 'answer_status' => $answer_status);
            }

            mysqli_stmt_close($stmt_sql);
        }
    } else {
        $error = array('status' => 'error', 'message' => 'Access Denied', 'incorrect_values' => $incorrectFields, 'answer_status' => $answer_status);
    }
} else {
    $error = array('status' => 'error', 'message' => 'Invalid Method');
}

// Close the database connection
mysqli_close($link);
// Convert the error array to JSON for AJAX or other response handling
echo json_encode($error);
