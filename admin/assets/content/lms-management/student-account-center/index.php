<?php
// Include required files
require_once('../../../../include/config.php');
include '../../../../include/function-update.php';
include '../../../../include/lms-functions.php';
require __DIR__ . '/../../../../vendor/autoload.php';

// For use env file data
use Dotenv\Dotenv;
use Symfony\Component\HttpClient\HttpClient;

// Load environment variables
$dotenv = Dotenv::createImmutable(dirname(__DIR__, 4)); // Go up 5 directories
$dotenv->load();

// Initialize HTTP client
$client = HttpClient::create();

// Fetch logged-in user data (if needed)
$LoggedUser = $_POST['LoggedUser'];
$UserLevel = $_POST['UserLevel'];


// Fetch certificate order data from API
$response = $client->request('GET', $_ENV["SERVER_URL"] . '/user_full_details/');

//var_dump($response);
$students = $response->toArray();
$selectedUsername = 'Admin';


?>

<div class="row g-3">
    <div class="col-md-12">
        <div class="">
            <div class="">
                <div class="col-12">
                    <h5 class="table-title mb-5">Student Account Center</h5>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-8 col-md-5">
        <form method="POST" action="" id="username-form">
            <div class="row">
                <div class="col-10 col-md-7 col-lg-6">
                    <select class="form-select" name="username" id="username" required autocomplete="off">
                        <option value="">Select Student</option>
                        <?php
                        if (!empty($students)) {
                            foreach ($students as $SelectedArray) {
                        ?>
                                <option value="<?= $SelectedArray['username'] ?>"><?= $SelectedArray['username'] ?> - <?= $SelectedArray['first_name'] ?> - <?= $SelectedArray['last_name'] ?></option>
                        <?php
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="col-4 col-md-5">
                    <button type="button" onclick="OpenStudentDetails(LoggedUser)" class="btn btn-dark">Get Student Details</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div id="student-details">
</div>

<script>
    $(document).ready(function() {
        $('#username').select2({
            width: 'resolve'
        });
    });
</script>