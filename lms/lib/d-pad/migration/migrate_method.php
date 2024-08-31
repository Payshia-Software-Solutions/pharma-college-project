<?php
require_once '../../../include/configuration.php';
include '../../../php_handler/function_handler.php';
include '../php_methods/d-pad-methods.php';

function getPrescriptionContent()
{
    global $link;

    // Fetch data from prescription_content
    $query = "SELECT `id`, `pres_code`, `cover_id`, `content` FROM `prescription_content`";
    $result = $link->query($query);

    if (!$result) {
        die("Error fetching data: " . $link->error);
    }

    $prescriptionContent = [];

    // Fetch all rows from the result
    while ($row = $result->fetch_assoc()) {
        $prescriptionContent[$row['pres_code']][] = $row['content'];
    }

    return $prescriptionContent;
}

function updatePrescriptionDrugsList($prescriptionId, $drugsList)
{
    global $link;

    // Update prescription table with the concatenated drugs_list
    $updateQuery = "UPDATE `prescription` SET `drugs_list` = '$drugsList' WHERE `prescription_id` = '$prescriptionId'";
    $updateResult = $link->query($updateQuery);

    if ($updateResult) {
        return ['status' => 'success', 'message' => 'Prescription updated successfully'];
    } else {
        return ['status' => 'error', 'message' => 'Error updating prescription: ' . $link->error];
    }
}

// Example usage
$contentData = getPrescriptionContent();


// Process the data and update prescriptions
foreach ($contentData as $presCode => $contents) {
    $drugsList = implode(', ', $contents);
    echo $presCode;
    echo "<br>";
    echo $drugsList;
    echo "<br>";

    // Reverse the drugsList
    $reversedDrugsList = implode(', ', array_reverse(explode(', ', $drugsList)));

    echo $reversedDrugsList;
    echo "<br>";

    $prescriptionId = $presCode; // Use the actual prescription code as the ID

    // Update prescription using the function
    $updateResult = updatePrescriptionDrugsList($prescriptionId, $reversedDrugsList);

    // Display success or error message
    if ($updateResult['status'] === 'success') {
        echo "Success: " . $updateResult['message'] . "\n";
        echo "<br>";
    } else {
        echo "Error: " . $updateResult['message'] . "\n";
        echo "<br>";
    }
}
