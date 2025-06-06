<?php
require '../../vendor/autoload.php';

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Dotenv\Dotenv;

$client = HttpClient::create();

$dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

require_once '../../include/configuration.php';
include '../../php_handler/function_handler.php';
include '../../php_handler/course_functions.php';
include '../../php_handler/win-pharma-functions.php';
include '../../php_handler/old-hunter.php';
include '../../lib/quiz/php_method/quiz_methods.php';
include '../../lib/d-pad/php_methods/d-pad-methods.php';

// Include Classes
include_once './classes/Database.php';
include_once './classes/Assignments.php';
include_once './classes/AssignmentSubmissions.php';
// Create a new Database object with the path to the configuration file
$config_file = '../../include/env.txt';
$database = new Database($config_file);
$db = $database->getConnection();

$Assignments = new Assignments($database);
$AssignmentSubmissions = new AssignmentSubmissions($database);

$loggedUser = $_POST['LoggedUser'];
$courseCode = $_POST['defaultCourseCode'];

$batchCode = $courseCode;
$winPharmaLevels = GetLevels($link, $batchCode);
$getSubmissionLevelCount = GetSubmissionLevelCount($loggedUser, $batchCode);
$winPharmaLevelCount = count($winPharmaLevels);
if ($winPharmaLevelCount > 0) {
    $winPharmaPercentage = ($getSubmissionLevelCount / $winPharmaLevelCount) * 100;
} else {
    $winPharmaPercentage = 0;
}

// Payments
$studentBalanceArray = GetStudentBalance($loggedUser);
$studentBalance = $studentBalanceArray['studentBalance'];
try {
    // Send GET request to fetch orders
    $response = $client->request('GET', $_ENV["SERVER_URL"] . "/delivery_orders?indexNumber={$loggedUser}&receivedStatus=false");

    // Get the response body as an array (if it's JSON)
    $responseData = $response->toArray();

    // Check for an error in the response and set an empty array if necessary
    if (isset($responseData['error']) && $responseData['error'] === 'No delivery orders found for the given index number') {
        $notReceivedOrders = [];
    } else {
        // Otherwise, assign the result to $notReceivedOrders
        $notReceivedOrders = $responseData;
    }
} catch (\Symfony\Component\HttpClient\Exception\ClientException $e) {
    // Handle 404 or other client-related errors
    if ($e->getCode() === 404) {
        $notReceivedOrders = [];  // Set empty array if 404 error occurs
        // You can log the error if needed
        error_log("API request failed with 404: " . $e->getMessage());
    } else {
        // Handle other types of client errors
        error_log("API request failed: " . $e->getMessage());
        $notReceivedOrders = [];
    }
} catch (\Exception $e) {
    // Handle other unexpected exceptions
    error_log("An unexpected error occurred: " . $e->getMessage());
    $notReceivedOrders = [];
}


$word_pallet_total_words = $word_pallet_correct_count = $word_pallet_incorrect_count = $word_pallet_grade = 0;
try {
    $studentEntries = $client->request('GET', $_ENV["SERVER_URL"] . '/en-word-submissions/student-grades/' . $LoggedUser)->toArray();
} catch (ClientExceptionInterface | TransportExceptionInterface $e) {
    if (method_exists($e, 'getCode') && $e->getCode() !== 404) {
        throw $e;
    }
}

include './components/hi-user.php';
include './components/image-slider.php';
include './components/payment-status.php';
include './components/default-course.php';
include './components/banner.php'; ?>


<div class="row mt-4">
    <div class="col-12">

        <?php
        if (!empty($notReceivedOrders)) {
        ?>
            <div class="alert alert-warning">
                <p class="mb-0">Please click the "Received" button if you have received your order. This will help us update
                    the status of your order promptly. Thank you!<br>ඔබගේ ඇනවුම ලබා ගත්තා නම් "Received" බටනය ඔබා එය තත්වය
                    යාවත්කාලීන කිරීමේදි අපට උදව් කරන්න. ස්තූතියි!</p>
            </div>
            <?php
            foreach ($notReceivedOrders as $selectedArray) {
            ?>

                <div class="col-md-4 pb-3">
                    <div class="card border-0 shadow-sm clickable other-card flex-fill" onclick="">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-3">
                                    <img src="<?= $_ENV['IMG_PATH_BASE'] ?>/lib/delivery/assets/images/<?= $selectedArray['icon'] ?>"
                                        class="w-100">
                                </div>
                                <div class="col-9">
                                    <h4 class="mb-0"><?= $selectedArray['delivery_title'] ?></h4>
                                    <h6 class="text-end mb-0">Tracking # <?= $selectedArray['tracking_number'] ?></h6>

                                    <div class="row mt-2">
                                        <div class="col-12">
                                            <button type="button"
                                                onclick="UpdateOrderReceivedStatus('<?= $selectedArray['id'] ?>', 'Received')"
                                                class="w-100 btn btn-dark">Received</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        <?php
            }
        }
        ?>
    </div>
</div>


<div id="grade_values"></div>
<?php
// include './components/grade-values.php';
include './components/common-modules.php';
?>
<div class="border-bottom my-3"></div>
<?php
include './components/play-modules.php';
?>
<div class="border-bottom my-3"></div>
<?php
include './components/other-modules.php';
?>