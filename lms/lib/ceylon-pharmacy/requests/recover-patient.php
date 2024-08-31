<?php
require_once '../../../include/configuration.php';
include '../../../php_handler/function_handler.php';
include '../methods/functions.php';

$prescriptionID = $_POST['prescriptionID'];
$LoggedUser = $_POST['LoggedUser'];

$sql = "DELETE FROM `care_start` WHERE `PresCode` LIKE '$prescriptionID' AND `student_id` LIKE '$LoggedUser'";
if ($link->query($sql) === TRUE) {
    $error = "Deleted Attempt";
    $error = array('status' => 'success', 'message' => 'Patient Recovered');
} else {
    $error = array('status' => 'error', 'message' => "Error deleting record: " . $link->error);
}

// Function to insert data into the care_center_recovery table
function insertCareCenterRecovery($student_number, $patient_id)
{
    global $link;
    // Prepare the SQL statement
    $stmt = $link->prepare("INSERT INTO care_center_recovery (student_number, patient_id, created_at) VALUES (?, ?, ?)");

    // Get the current timestamp
    $created_at = date('Y-m-d H:i:s');

    // Bind parameters
    $stmt->bind_param("sss", $student_number, $patient_id, $created_at);

    // Execute the statement
    if ($stmt->execute()) {
        $error = array('status' => 'success', 'message' => 'New record created successfully');
    } else {
        $error = array('status' => 'success', 'message' => "Error: " . $stmt->error);
    }

    // Close the statement and connection
    $stmt->close();
    $link->close();

    return $error;
}

$record_entry = insertCareCenterRecovery($LoggedUser, $prescriptionID);
echo json_encode($error);
