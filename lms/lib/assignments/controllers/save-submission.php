<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../../../include/configuration.php';
include '../../../php_handler/function_handler.php';

// Include Classes
include_once '../Classes/Database.php';
include_once '../Classes/Assignments.php';
include_once '../Classes/AssignmentSubmissions.php';

$config_file = '../../../include/env.txt';
$database = new Database($config_file);
$db = $database->getConnection();

$userLevel = $_POST['UserLevel'];
$loggedUser = $_POST['LoggedUser'];
$CourseCode = $_POST['CourseCode'];
$assignmentId = $_POST['assignmentId'];
$submissionTag = $_POST['submissionTag'];

$assignments = new Assignments($database);
$submissions = new AssignmentSubmissions($database);

$fileList = []; // Array to store file names

// Check if files were uploaded
if (isset($_FILES['files'])) {
    $files = $_FILES['files'];

    // Loop through each file
    for ($i = 0; $i < count($files['name']); $i++) {
        // Get the file details
        $fileName = $files['name'][$i];
        $fileTmpName = $files['tmp_name'][$i];
        $fileSize = $files['size'][$i];
        $fileError = $files['error'][$i];
        $fileType = $files['type'][$i];

        // Check if there were any errors with the file
        if ($fileError === 0) {
            // Set a unique name for the file to avoid overwriting
            $fileNewName = uniqid('', true) . "-" . $fileName;

            // Set the upload destination
            $uploadDir = "../../../uploads/assignment-submissions/$assignmentId/$loggedUser/";

            // Create the directory if it does not exist
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $fileDestination = $uploadDir . $fileNewName;

            // Move the file to the destination
            if (move_uploaded_file($fileTmpName, $fileDestination)) {
                $fileList[] = $fileNewName; // Add the new file name to the list

                $image_result = array('status' => 'success', 'message' => "File $fileName uploaded successfully.");
            } else {
                $image_result = array('status' => 'success', 'message' => "Error uploading $fileName.");
            }
        } else {
            $image_result = array('status' => 'error', 'message' => "Error with file $fileName: $fileError.");
        }
    }

        // Convert the file list to a comma-separated string
        $fileListString = implode(',', $fileList);


        // Update an employee
        $updateData = [
            'assignment_id' => $assignmentId,
            'course_code' => $CourseCode,
            'created_by' => $loggedUser,
            'created_at' =>  date("Y-m-d H:i:s"),
            'is_active' =>  1,
            'updated_at' =>  date("Y-m-d H:i:s"),
            'file_list' =>  $fileListString, // Store the file list as a comma-separated string
            'grade' => 0,
            'grade_status' => 0,
            'submissionTag' => $submissionTag
        ];

        if ($submissions->add($updateData)) {
            $error = array('status' => 'success', 'message' => 'Submission saved successfully.');
        } else {
            $error = array('status' => 'error', 'message' => 'Failed to Insert Assignment.' . $assignments->getLastError());
        }
} else {
    $error = array('status' => 'error', 'message' => "No files uploaded.");
}


echo json_encode($error);
// echo json_encode($image_result);