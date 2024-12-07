<?php

require '../../vendor/autoload.php';
require '../../php_handler/course_functions.php';
require '../../php_handler/function_handler.php';

use Symfony\Component\HttpClient\HttpClient;

// Create an HTTP client
$client = HttpClient::create();

// For using environment variables (from .env file)
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

// Get the LoggedUser from the POST request
$LoggedUser = $_POST['LoggedUser'];
$certificateId = $_POST['certificateId'];
$CourseCode = $_POST['CourseCode'] ?? null; // CourseCode sent as a query parameter

// echo '<pre>';
// print_r($CourseCode);
// echo '</pre>';

// !Parmer Hunter correct answer count

// Make a GET request to fetch the saved answers by user
$response = $client->request('GET', $_ENV["SERVER_URL"] . '/hunter_saveanswer/' . $LoggedUser);

// Get the response body as an array
$data = $response->toArray();
//print_r($data);

// Check if 'Admin' key exists, and then get the 'correct_count' field as an integer
$correctCount = isset($data[$LoggedUser]['correct_count']) ? (int) $data[$LoggedUser]['correct_count'] : 0;

// echo "correctCount: $correctCount\n";

// !winpharmer game recover count

// Making a GET request to fetch the recovered count from the appropriate route
$response2 = $client->request('GET', $_ENV["SERVER_URL"] . '/certificate-criteria/recovered-patients/', [
    'query' => [
        'CourseCode' => $CourseCode,
        'LoggedUser' => $LoggedUser
    ]
]);

// Get the response body as an array (if it's JSON)
$data = $response2->toArray();

// Extract the recovered count from the response
$recoveredCount = $data['recoveredCount'] ?? 0; // Default to 0 if not found

// !Assignments

$Assignment_01 = 0;
$Assignment_02 = 0;
$Assignment_03 = 0;

// Placeholder for assignment IDs
$Assignment_01_ID = '';
$Assignment_02_ID = '';
$Assignment_03_ID = '';


//* Call the function to get all user enrollments by course
$CourseAssignments = GetAssignments($CourseCode);

// Print the result or use the data as needed
// echo '<pre>';
// print_r('assigments by course code');
// print_r($CourseAssignments);  // This will print the entire result in a readable format
// echo '</pre>';

//* Call the function to get all assigments by user
$userassigments = GetAssignmentSubmissionsByUser($LoggedUser);

// echo '<pre>';
// print_r('assigments submission by user');
// print_r($userassigments);  // This will print the entire result in a readable format
// echo '</pre>';

// Initialize an empty array to store matching assignments
$matchingAssignments = array();

//* Loop through $CourseAssignments and compare with $userassigments
foreach ($CourseAssignments as $courseAssignmentId => $courseAssignment) {
    // Check if the assignment_id exists in $userassigments
    if (isset($userassigments[$courseAssignmentId])) {
        // If a match is found, add the assignment to the $matchingAssignments array
        $matchingAssignments[$courseAssignmentId] = array(
            'course_assignment' => $courseAssignment,  // Details from $CourseAssignments
            'user_assignment'   => $userassigments[$courseAssignmentId]  // Details from $userassigments
        );
    }
}

// echo '<pre>';
// print_r('match assigment by assigment id');
// print_r($matchingAssignments);  // This will print the entire result in a readable format
// echo '</pre>';

//* get assigment grades by assigment id
foreach ($matchingAssignments as $assignmentId => $assignments) {
    // Get the user assignment grade for the specific assignment
    $userGrade = $assignments['user_assignment']['grade'];

    // Switch statement based on the assignment_id
    switch ($assignmentId) {
        case array_values($CourseAssignments)[0]['assignment_id'];
            $Assignment_01 = $userGrade;
            $Assignment_01_ID = $assignmentId;
            break;

        case array_values($CourseAssignments)[1]['assignment_id']:
            $Assignment_02 = $userGrade;
            $Assignment_02_ID = $assignmentId;
            break;

        case array_values($CourseAssignments)[2]['assignment_id']:
            $Assignment_03 = $userGrade;
            $Assignment_03_ID = $assignmentId;
            break;

            // Add more cases for other assignment_ids if needed
        default:
            // Optionally, handle the case if the assignment_id doesn't match any case
            break;
    }
}

// Example: Display the grades dynamically
// echo "Grade for {$Assignment_01_ID}: " . ($Assignment_01 ? $Assignment_01 : 'Not graded yet') . "<br>";
// echo "Grade for {$Assignment_02_ID}: " . ($Assignment_02 ? $Assignment_02 : 'Not graded yet') . "<br>";
// echo "Grade for {$Assignment_03_ID}: " . ($Assignment_03 ? $Assignment_03 : 'Not graded yet') . "<br>";

//! Due Payments

$enrollmentList =  getUserEnrollments($LoggedUser);
$batchList =  GetCourses($link);
$studentBalanceArray = GetStudentBalance($LoggedUser);
$dueBalance = $studentBalanceArray['studentBalance'];

//!certificate title & criteria group id

//certificate Title
$certificateName = $client->request('GET', $_ENV["SERVER_URL"] . '/cc_certificate_list/' . $certificateId);
// Get the response body as an array (if it's JSON)

$data6 = $certificateName->toArray();
//print_r($data6);
$Title = $data6['list_name'] ?? 0;
$CertificateCriteriaaGroupId = $data6['criteria_group_id'];
//print_r($Title);

//! Get certificate Criteria Group

// Fetch the data from the server
$certificateName = $client->request('GET', $_ENV["SERVER_URL"] . '/cc_criteria_group/' . $CertificateCriteriaaGroupId);

// Convert the response to an array
$data6 = $certificateName->toArray();
//print_r($data6);

// Extract criteria_group JSON string
$cdata = $data6['criteria_group'] ?? null;

// Ensure the criteria_group is valid and decoded correctly
$criteraList = null; // Default to null in case of failure
if ($cdata) {
    // Decode the JSON string into an associative array
    $criteraList = json_decode($cdata, true);
}

// If $criteraList is not an array, provide an empty array
if (!is_array($criteraList)) {
    $criteraList = [];
}

// print_r($criteraList);

// Initialize an array to store results
$criteriaWithListNames = [];

// Iterate through the criteria list
foreach ($criteraList as $id) {
    // Ensure $id is valid
    if ($id) {
        // Fetch the list_name and moq from the /cc_criteria_list/{id}/ API endpoint
        $response = $client->request('GET', $_ENV["SERVER_URL"] . '/cc_criteria_list/' . $id);
        $listData = $response->toArray();

        // Debugging output to check the response data
        // var_dump($listData);

        // Extract list_name and moq
        $listName = $listData['list_name'] ?? 'Unknown';
        $moq = $listData['moq'] ?? 0;

        // Save the extracted data into the results array
        $criteriaWithListNames[] = [
            'id' => $id,
            'list_name' => $listName,
            'moq' => $moq,
        ];
    }
}

?>

<div class="card border-0 shadow-lg rounded-4">
    <div class="card-body">
        <div class="row">
            <div class="text-center p-10">
                <h3 class="p-2 fw-bold"><?= htmlspecialchars($Title, ENT_QUOTES, 'UTF-8') ?> Criteria</h3>
            </div>



            <?php if (!empty($criteraList)): ?>
                <?php
                $eligibility = true; // Assume eligibility is true
                $index = 0; // Initialize index for progress tracking

                //!check order button
                $correctCount = 1000;
                $recoveredCount = 50;
                $Assignment_01 = 50;
                $Assignment_02 = 50;
                $Assignment_03 = 50;
                $dueBalance = 0;
                ?>

                <!-- Loop through criteria and render cards -->
                <?php foreach ($criteriaWithListNames as $criteria): ?>
                    <?php
                    $listName = $criteria['list_name'] ?? 'Unknown Criteria';
                    $moq = $criteria['moq'] ?? 0;
                    $title = $criteria['title'] ?? 'Unknown';
                    $id = $criteria['id'] ?? 0;

                    // Determine the current progress based on title
                    switch ($id) {
                        case 1:
                            $currentBar = $correctCount ?? 0;
                            break;
                        case 2:
                            $currentBar = $recoveredCount ?? 0;
                            break;
                        case 3:
                            $currentBar = $Assignment_01 ?? 0;
                            break;
                        case 4:
                            $currentBar = $Assignment_02 ?? 0;
                            break;
                        case 5:
                            $currentBar = $Assignment_03 ?? 0;
                            break;
                        case 6:
                            $dueBalance = $dueBalance ?? 0;
                            if ($dueBalance === 0) {
                                $dueBalance = 1; // Set due balance to 1
                                $moq = 1; // Ensure MOQ is also 1
                            }
                            $currentBar = $dueBalance;
                            break;
                        case 7:
                            $currentBar = $incorrectCount ?? 0;
                            break;
                        default:
                            $currentBar = 0;
                            break;
                    }

                    // Calculate the progress bar width
                    $barWidth = (isset($moq) && is_numeric($moq) && $moq > 0)
                        ? min(($currentBar / $moq) * 100, 100)
                        : 0;

                    // Update eligibility if any progress is below 100%
                    if ($barWidth < 100) {
                        $eligibility = false;
                    }
                    ?>

                    <!-- Render individual criteria card -->
                    <div class="col-md-3 d-flex mt-2">
                        <div class="card rounded-3 knowledge-card flex-fill shadow">
                            <div class="card-body">
                                <h5 class="p-1 text-center"><?= htmlspecialchars($listName, ENT_QUOTES, 'UTF-8') ?></h5>
                                <p class="text-center">You must pass: <?= htmlspecialchars($moq, ENT_QUOTES, 'UTF-8') ?></p>
                                <p class="text-center">Progress: <?= htmlspecialchars($currentBar, ENT_QUOTES, 'UTF-8') ?></p>

                                <div class="progress"
                                    role="progressbar"
                                    aria-label="Progress for <?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?>"
                                    aria-valuenow="<?= htmlspecialchars($barWidth, ENT_QUOTES, 'UTF-8') ?>"
                                    aria-valuemin="0"
                                    aria-valuemax="100">
                                    <div class="progress-bar" style="width: <?= htmlspecialchars($barWidth, ENT_QUOTES, 'UTF-8') ?>%;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No criteria available</p>
            <?php endif; ?>

            <!-- Conditional button or message based on eligibility -->
            <div class="row mt-4">
                <div class="col-12">
                    <?php if ($eligibility): ?>
                        <!-- Button enabled if eligibility is true -->
                        <button class="btn btn-success w-100 btn-lg" id="order-button"
                            onclick="OpenCertificateForm('<?= htmlspecialchars($LoggedUser, ENT_QUOTES, 'UTF-8') ?>', '<?= htmlspecialchars($certificateId, ENT_QUOTES, 'UTF-8') ?>')">
                            <i class="fa fa-shopping-cart"></i> Go to Form
                        </button>
                    <?php else: ?>
                        <!-- Message displayed if eligibility is false -->
                        <div class="alert alert-danger w-100">
                            <p class="text-center">You are not eligible to place an order at this moment.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>