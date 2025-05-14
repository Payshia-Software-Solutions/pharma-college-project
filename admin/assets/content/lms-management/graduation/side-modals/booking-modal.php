<?php
require __DIR__ . '/../../../../../vendor/autoload.php';
include '../../../../../include/function-update.php';

// Get User Theme
$userThemeInput = isset($_POST['userTheme']) ? $_POST['userTheme'] : null;
$userTheme = getUserTheme($userThemeInput);

// For use env file data
use Dotenv\Dotenv;
use Symfony\Component\HttpClient\HttpClient;

// Load environment variables
$dotenv = Dotenv::createImmutable(dirname(__DIR__, 5));
$dotenv->load();

// Initialize HTTP client
$client = HttpClient::create();

$referenceNumber = $_POST['referenceNumber'];

// Fetch certificate order data from API
$response = $client->request('GET', $_ENV['SERVER_URL'] . '/convocation-registrations/' . $referenceNumber);
$packageBookings = $response->toArray();
?>
<div class="loading-popup-content-right <?= htmlspecialchars($userTheme) ?>">
    <div class="row">
        <div class="col-6">
            <h3 class="mb-0">Booking Info</h3>
        </div>

        <div class="col-6 text-end">
            <button class="btn btn-light btn-sm" onclick="ClosePopUPRight(0)" type="button"><i
                    class="fa solid fa-xmark"></i> Cancel</button>

        </div>

        <div class="col-12">
            <div class="border-bottom border-5 my-2"></div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <?php
            var_dump($packageBookings);
            ?>
        </div>
    </div>
</div>