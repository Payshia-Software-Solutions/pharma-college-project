<?php

require '../../vendor/autoload.php';
require_once '../../php_handler/function_handler.php'; // Include your function file

use Dotenv\Dotenv;
use Symfony\Component\HttpClient\HttpClient;

use function PHPSTORM_META\type;

// Load environment variables
$dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

// Create the HttpClient
$client = HttpClient::create();

$LoggedUser = $_POST['LoggedUser'];
$certificateId = $_POST['certificateId'];
$CourseCode = $_POST['CourseCode'];
$certificateName = $_POST['certificateName'];

$certificateDataFormResponse = $client->request('GET', $_ENV["SERVER_URL"] . '/cc_certificate_order/' . $certificateId);
$orderData = $certificateDataFormResponse->toArray();

//get full name
$userDataResponse = $client->request('GET', $_ENV["SERVER_URL"] . '/userFullDetails/username/' . $LoggedUser);

// Get the response body as an array
$userData = $userDataResponse->toArray();

$firstName = $userData['first_name'] ?? null;
$lastName = $userData['last_name'] ?? null;
$fullName = trim($firstName . ' ' . $lastName);

// Get city
$cities = GetCities($link);

// Search for a specific city by id
$city_id = $orderData['city_id']; // The city ID you're looking for
$city_name_en = '';

if (isset($cities[$city_id])) {
    // City found, get the 'name_en'
    $city_name_en = $cities[$city_id]['name_en'];
}

$certificateStatus = $orderData['certificate_status']; // Assuming this is either "Printed" or "Pending"
?>

<div class="row g-3">
    <div class="col-12">
        <div class="card shadow border-0 rounded-3">
            <div class="card-body p-5">
                <div class="row g-2">
                    <div class="col-6 col-12">
                        <span class="status-span bg-primary text-light mb-5" style="padding: 5px 10px; border-radius: 5px;"><?= $orderData['id'] ?></span>
                        <span class="status-span mb-5 <?php echo $certificateStatus === 'Printed' ? 'bg-success' : 'bg-danger'; ?>" style="color: white; padding: 5px 10px; border-radius: 5px;">
                            <?php echo $certificateStatus === 'Printed' ? 'Printed' : 'Pending'; ?>
                        </span>
                        <h3 class="mt-3 border-bottom pb-2"><?= $certificateName ?></h3>
                    </div>
                    <div class="col-12 col-lg-3 text-center text-md-start d-flex">
                        <div class="card bg-light border-0 flex-fill">
                            <div class="card-body">
                                <p class="mb-0">Student ID</p>
                                <h4 class="fw-bold mb-0"><?= $orderData['created_by'] ?></h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-9 text-center text-md-start d-flex">
                        <div class="card bg-light border-0 flex-fill">
                            <div class="card-body">
                                <p class="mb-0">Name</p>
                                <h4 class="fw-bold mb-0"><?= htmlspecialchars($fullName) ?></h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-3 text-center text-md-start d-flex">
                        <div class="card bg-light border-0 flex-fill">
                            <div class="card-body">
                                <p class="mb-0">Mobile Number</p>
                                <h5 class="fw-bold mb-0"><?= $orderData['mobile'] ?></h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-3 text-center text-md-start d-flex">
                        <div class="card bg-light border-0 flex-fill">
                            <div class="card-body">
                                <p class="mb-0">Address Line 1</p>
                                <h5 class="fw-bold mb-0 due-balance"><?= $orderData['address_line1'] ?></h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-3 text-center text-md-start d-flex">
                        <div class="card bg-light border-0 flex-fill">
                            <div class="card-body">
                                <p class="mb-0">Address Line 2</p>
                                <h5 class="fw-bold mb-0 due-balance"><?= $orderData['address_line2'] ?></h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-3 text-center text-md-start d-flex">
                        <div class="card bg-light border-0 flex-fill">
                            <div class="card-body">
                                <p class="mb-0">City</p>
                                <h5 class="fw-bold mb-0 due-balance"><?= $city_name_en ?></h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>