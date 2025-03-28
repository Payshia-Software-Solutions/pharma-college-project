<?php
require '../../vendor/autoload.php';

use Symfony\Component\HttpClient\HttpClient;

$client = HttpClient::create();

//for use env file data
use Dotenv\Dotenv;

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
$response = $client->request('GET', $_ENV["SERVER_URL"] . "/delivery_orders?indexNumber={$loggedUser}&receivedStatus=false");

// Get the response body as an array (if it's JSON)
$notReceivedOrders = $response->toArray();
include './components/hi-user.php';
include './components/image-slider.php';
include './components/payment-status.php';
include './components/default-course.php';
include './components/banner.php'; ?>


<div class="row mt-4">
    <div class="col-12">
        <div class="alert alert-warning">
            <p class="mb-0">Please click the "Received" button if you have received your order. This will help us update
                the status of your order promptly. Thank you!<br>ඔබගේ ඇනවුම ලබා ගත්තා නම් "Received" බටනය ඔබා එය තත්වය
                යාවත්කාලීන කිරීමේදි අපට උදව් කරන්න. ස්තූතියි!</p>
        </div>
        <?php
            if (!empty($notReceivedOrders)) {
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