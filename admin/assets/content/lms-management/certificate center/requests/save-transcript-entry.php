<?php

require_once('../../../../../include/config.php');
include '../../../../../include/function-update.php';
include '../../../../../include/lms-functions.php';

require __DIR__ . '/../../../../../vendor/autoload.php';

// For use env file data
use Dotenv\Dotenv;
use Symfony\Component\HttpClient\HttpClient;

// Load environment variables
$dotenv = Dotenv::createImmutable(dirname(__DIR__, 5)); // Go up 5 directories
$dotenv->load();

// Initialize HTTP client
$client = HttpClient::create();

// Parameters
$indexNo = $_POST["indexNo"];
$CourseCode = $_POST["CourseCode"];
$TitleIDs = $_POST["TitleIDs"];
$OptionValues = $_POST["OptionValues"];

$UserLevel = $_POST["UserLevel"];
$LoggedUser = $_POST["LoggedUser"];
$error = "";
$today = date("Y-m-d");

// Loop through TitleIDs and OptionValues
for ($i = 0; $i < count($TitleIDs); $i++) {
    $TitleID = $TitleIDs[$i];
    $OptionValue = $OptionValues[$i];

    // Send GET request to check if the record exists
    try {
        $response = $client->request('GET', $_ENV["SERVER_URL"] . "/certificate-user-result/$indexNo/$CourseCode/$TitleID/");

        // Check if the response status is successful
        if ($response->getStatusCode() === 200) {
            // Record exists, get the result
            $record = $response->toArray();  // Convert the response to an associative array

            // Update record if values differ
            if ($record['result'] != $OptionValue || $record['created_by'] != $LoggedUser) {
                // Send PUT request to update the certificate result
                $updateData = [
                    'result' => $OptionValue,
                    'created_by' => $LoggedUser
                ];

                $response = $client->request('PUT', $_ENV["SERVER_URL"] . "/certificate-user-result/$indexNo/$CourseCode/$TitleID/", [
                    'json' => $updateData
                ]);

                if ($response->getStatusCode() === 200) {
                    $error .= "Successfully updated the record for TitleID: $TitleID.<br>";
                } else {
                    $error .= "Error updating the record for TitleID: $TitleID.<br>";
                }
            } else {
                $error .= "No change needed for TitleID: $TitleID<br>";
                continue;
            }
        } else {
            // Record doesn't exist, create a new record
            $createData = [
                'index_number' => $indexNo,
                'course_code' => $CourseCode,
                'title_id' => $TitleID,
                'result' => $OptionValue,
                'created_by' => $LoggedUser
            ];

            $response = $client->request('POST', $_ENV["SERVER_URL"] . '/certificate-user-result/', [
                'json' => $createData
            ]);

            if ($response->getStatusCode() === 201) {
                $error .= "Successfully created a new record for TitleID: $TitleID.<br>";
            } else {
                $error .= "Error creating a new record for TitleID: $TitleID.<br>";
            }
        }
    } catch (Exception $e) {
        $error .= "Error processing request for TitleID: $TitleID. " . $e->getMessage() . "<br>";
    }
}

echo $error;
