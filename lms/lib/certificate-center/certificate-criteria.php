<?php

require '../../vendor/autoload.php';

use Symfony\Component\HttpClient\HttpClient;

// Create an HTTP client
$client = HttpClient::create();

// For using environment variables (from .env file)
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

// !Parmer Hunter correct answer count


// Get the LoggedUser from the POST request
$LoggedUser = $_POST['LoggedUser'];
$CourseCode = $_POST['CourseCode'] ?? null; // CourseCode sent as a query parameter
$certificateId = $_POST['certificateId'];
//print_r($certificateId);


// Make a GET request to fetch the saved answers by user
$response = $client->request('GET', $_ENV["SERVER_URL"] . '/hunter_saveanswer/' . $LoggedUser);

// Get the response body as an array
$data = $response->toArray();
//print_r($data);

// Check if 'Admin' key exists, and then get the 'correct_count' field as an integer
$correctCount = isset($data[$LoggedUser]['correct_count']) ? (int) $data[$LoggedUser]['correct_count'] : 0;

//echo "correctCount: $correctCount\n";

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

//echo "recoveredCount: $recoveredCount\n";

// !Assigments
$assignmentIds = [2, 3, 4];

// Initialize empty arrays to store the assignment bars and grades
$assignmentBars = [];
$assignmentGrades = [];

// Loop through each assignment ID
foreach ($assignmentIds as $assignmentId) {
    // Make the request and get the response for each assignment
    $response3 = $client->request('GET', $_ENV["SERVER_URL"] . '/submissions/assignment/' . $LoggedUser . '/' . $assignmentId);

    // Get the response content (raw JSON)
    $content = $response3->getContent(); // This gets the raw content

    // Decode the JSON content into an array
    $data = json_decode($content, true); // Decode to an associative array

    // Initialize assignment bar and grade
    $assignmentBar = 0;
    $grade = 0;

    // Check if 'grade' exists in the response data
    if ($data && isset($data['grade'])) {
        $grade = floatval($data['grade']); // Convert grade to a float

        // Store the grade in the $assignmentGrades array
        $assignmentGrades["assignment{$assignmentId}_grade"] = $grade;

        // Calculate the assignment bar based on grade
        if ($grade <= 50) {
            $assignmentBar = ($grade / 50) * 100 . '%'; // Calculate the bar for grades <= 50
        } else {
            $assignmentBar = 100 . '%'; // If grade > 50, set bar to 100%
        }
    }

    // Store the calculated assignment bar in the $assignmentBars array
    $assignmentBars["assignment{$assignmentId}_bar"] = $assignmentBar;
}


$assigment2_description =  "You should get at least 50 marks.<br> You got {$assignmentGrades["assignment2_grade"]} marks";
$assigment3_description =  "You should get at least 50 marks.<br> You got {$assignmentGrades["assignment3_grade"]} marks";
$assigment4_description =  "You should get at least 50 marks.<br> You got {$assignmentGrades["assignment4_grade"]} marks";

//echo "recoveredCount: {$assignmentGrades["assignment4_grade"]}\n";

//! Due Payments

//*course_fee 

// Make a GET request to fetch the course_fee by coursecode
$response4 = $client->request('GET', $_ENV["SERVER_URL"] . '/course-fee/' . $CourseCode);

// Get the response body as an array (if it's JSON)
$data4 = $response4->toArray();

// Extract the recovered count from the response
$course_fee = $data4['course_fee'] ?? 0; // Default to 0 if not found

//*paid_amount and discount_amount

// Making a GET request to fetch paid_amount and discount_amount from the appropriate route
$response5 = $client->request('GET', $_ENV["SERVER_URL"] . '/student-payment/' . $LoggedUser);

// Get the response body as an array (assuming it's JSON)
$data5 = $response5->toArray();

// Extract the paid_amount and discount_amount from the response
$paidAmount = $data5['paid_amount'] ?? 0; // Default to 0 if not found
$discountAmount = $data5['discount_amount'] ?? 0; // Default to 0 if not found

$paidAndDiscountAmount = $paidAmount + $discountAmount;
$duePayment = $course_fee - $paidAndDiscountAmount;
/*echo "fee: $course_fee\n";
echo "Paid Amount: $paidAmount\n";
echo "Discount Amount: $discountAmount\n";
echo "duePayment Amount: $duePayment\n";
echo "paymentBar: $paymentBar\n";*/

//bar-width
$correctcountBar = ($correctCount / 1000) * 100 . '%';
$recoveredCountBar = ($recoveredCount / 50) * 100 . '%';
$assigment1Bar = $assignmentGrades["assignment2_grade"];
$assigment2Bar = $assignmentGrades["assignment3_grade"];
$assigment3Bar = $assignmentGrades["assignment4_grade"];
$paymentBar = ($paidAndDiscountAmount / $course_fee) * 100 . '%';


//certificate name
$certificateName = $client->request('GET', $_ENV["SERVER_URL"] . '/cc_certificate_list/' . $certificateId);
// Get the response body as an array (if it's JSON)

$data6 = $certificateName->toArray();
//print_r($data6);
$Title = $data6['list_name'] ?? 0;
//print_r($Title);




//!Checking for button
$bar = 100 . '%';

$barWidthArray = [$correctcountBar, $recoveredCountBar, $assigment1Bar, $assigment2Bar, $assigment3Bar, $paymentBar];

// Certificate criteria list
$criteraList = [
    [
        'id' => 1,
        'title' => 'Pharmer Hunter Game',
        'description' => ($correctCount / 1000) * 100 . '%',
        'bar_width' => $bar,
        'moq' => 1000
    ],
    [
        'id' => 2,
        'title' => 'CelonPharmesy game',
        'description' => ($recoveredCount / 50) * 100 . '%',
        'bar_width' => $bar,
        'moq' => 1000
    ],
    [
        'id' => 3,
        'title' => 'Assigment 01',
        'description' => $assigment2_description,
        'bar_width' => $bar,
        'moq' => 1000
    ],
    [
        'id' => 4,
        'title' => 'Assigment 02',
        'description' => $assigment3_description,
        'bar_width' => $bar,
        'moq' => 1000
    ],
    [
        'id' => 5,
        'title' => 'Assigment 03',
        'description' => $assigment4_description,
        'bar_width' => $bar,
        'moq' => 1000
    ],
    [
        'id' => 6,
        'title' => 'Due Payments',
        'description' => 'You should Pay full course fees.',
        'bar_width' => $bar,
        'moq' => 1000
    ],
];

// Logic to determine certificate eligibility (e.g., based on correct answer count)
$certificateEligibility = true;
foreach ($criteraList as $criteria) {
    if ($criteria['bar_width'] !== '100%') {
        $certificateEligibility = false;
        break;
    }
} // Assuming eligibility is based on the correct answer count

?>

<div class="card border-0 shadow-lg rounded-4">
    <div class="card-body">
        <div class="row">

            <div class="text-center p-10">
                <h3 class="p-2 fw-bold"><?= $Title ?> Criteria</h3>
            </div>


            <?php foreach ($criteraList as $index => $criteria) : ?>
                <div class="col-md-3 d-flex mt-2">
                    <div class="card rounded-3 knowledge-card flex-fill shadow">
                        <div class="card-body">
                            <h5 class="p-1 text-center"><?= $criteria['title'] ?></h5>
                            <p class="text-center"><?= $criteria['description'] ?></p>
                            <div
                                class="progress"
                                role="progressbar"
                                aria-label="Basic example"
                                aria-valuenow="100"
                                aria-valuemin="0"
                                aria-valuemax="100">
                                <div class="progress-bar" style="width: <?= $criteria['bar_width'] ?>;"></div>


                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

        </div>
        <div class="row mt-4">
            <div class="col-12">
                <?php if ($certificateEligibility) : ?>
                    <button class="btn btn-success w-100 btn-lg"
                        onclick="OpenCertificateForm('<?= $LoggedUser ?>', '<?= $certificateId ?>')"
                        type="button">
                        <i class="fa fa-shopping-cart"></i> Go to Form
                    </button>
                <?php else : ?>
                    <div class="alert alert-warning mb-0">You are not eligible to order this certificate. Please complete all criteria.</div>
                <?php endif ?>
            </div>



        </div>

    </div>

</div>