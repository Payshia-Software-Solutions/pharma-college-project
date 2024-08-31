<?php
// Include necessary files and configuration
require_once '../../../include/configuration.php';
include '../../../php_handler/function_handler.php';

// Initialize the response array
$response = array();
$new_password_err = $confirm_password_err = null;
// Add validation errors to the response array
$response['status'] = 'error';

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $studentNumber = $_POST['studentNumber'];
    $phoneNumber = $_POST['phoneNumber'];

    // Validate new password
    if (empty(trim($_POST["password"]))) {
        $new_password_err = "Please enter the new password.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $new_password_err = "Password must have at least 6 characters.";
    } else {
        $new_password = trim($_POST["password"]);
    }

    // Validate confirm password
    if (empty(trim($_POST["cPassword"]))) {
        $confirm_password_err = "Please confirm the password.";
    } else {
        $confirm_password = trim($_POST["cPassword"]);
        if (empty($new_password_err) && ($new_password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        }
    }

    // Check input errors before updating the database
    if (empty($new_password_err) && empty($confirm_password_err)) {

        // Prepare an update statement
        $sql = "UPDATE `users` SET `password` = ? WHERE `username` LIKE ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_password, $param_username);

            // Set parameters
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_username = $studentNumber;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                $updatePreTokens = UpdateOTP($studentNumber, $phoneNumber, 0);

                // Add a success message to the response array
                $response['status'] = 'success';
                $response['message'] = 'Password updated successfully!';
            } else {
                // Add an error message to the response array
                $response['status'] = 'error';
                $response['message'] = 'Oops! Something went wrong. Please try again later.' . mysqli_error($link);
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }


    $response['new_password_err'] = $new_password_err;
    $response['confirm_password_err'] = $confirm_password_err;
}

// Encode the response array to JSON and print it
echo json_encode($response);
