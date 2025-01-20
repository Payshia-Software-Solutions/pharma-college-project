<?php
// Include required files
require_once('../../../../include/config.php');
include '../../../../include/function-update.php';
include '../../../../include/lms-functions.php';
require __DIR__ . '/../../../../vendor/autoload.php';

use Dotenv\Dotenv;
use Symfony\Component\HttpClient\HttpClient;

// Load environment variables
$dotenv = Dotenv::createImmutable(dirname(__DIR__, 4));
$dotenv->load();

// Initialize HTTP client
$client = HttpClient::create();

$userThemeInput = isset($_POST['userTheme']) ? $_POST['userTheme'] : null;
$userTheme = getUserTheme($userThemeInput);

// Retrieve selected username from POST data
$selectedUsername = $_POST['selectedUsername'] ?? null;

if (!$selectedUsername) {
    echo '<div class="alert alert-danger">No username selected.</div>';
    exit;
}

$student = $client->request('GET', $_ENV["SERVER_URL"] . '/users/username/' . $selectedUsername);
$details = $student->toArray();
?>

<div class="loading-popup-content-right <?= htmlspecialchars($userTheme) ?>">
    <div class="text-end">
        <button class="btn btn-dark" onclick="ClosePopUPRight(1)" type="button">
            <i class="fa solid fa-xmark"></i> Close
        </button>
    </div>
    <div class="index-content">
        <div class="card-body">
            <div class="col-12 mb-5">
                <h5 class="table-title">Password Reset</h5>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <h6 class="text-secondary">Name</h6>
                </div>
                <div class="col-md-8">
                    <h6>: <?= $details['fname'] ?> <?= $details['lname'] ?></h6>
                </div>

                <div class="col-md-4">
                    <h6 class="text-secondary">Username</h6>
                </div>
                <div class="col-md-8">
                    <h6>: <?= $details['username'] ?></h6>
                </div>

                <div class="col-md-4">
                    <h6 class="text-secondary">Phone No</h6>
                </div>
                <div class="col-md-8">
                    <h6>: <?= $details['phone'] ?></h6>
                </div>

                <div class="col-md-4">
                    <h6 class="text-secondary">Email</h6>
                </div>
                <div class="col-md-8">
                    <h6>: <?= $details['email'] ?></h6>
                </div>
            </div>



            <hr>
            <form method="post" id="password-form">
                <input type="hidden" id="id" name="id" value="<?= htmlspecialchars($details['id']) ?>">
                <input type="hidden" id="username" value="<? $selectedUsername ?>">

                <div class="col-md-6 mb-2">
                    <h6 class="password-label">New Password</h6>
                    <input type="password" class="form-control" id="newPassword" name="new_password" required minlength="8">
                </div>

                <div class="col-md-6 mb-2">
                    <h6 class="retype-password-label">Retype Password</h6>
                    <input type="password" class="form-control" id="retypePassword" name="retype_password" required minlength="8">
                </div>

                <div class="text-end">
                    <button type="button" class="btn btn-dark" onclick="SubmitPasswordUpdateForm()">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>