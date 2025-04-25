<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include '../../../../include/function-update.php';
require __DIR__ . '/../../../../vendor/autoload.php';

// For use env file data
use Dotenv\Dotenv;
use Symfony\Component\HttpClient\HttpClient;

// Load environment variables
$dotenv = Dotenv::createImmutable(dirname(__DIR__, 4));
$dotenv->load();

// Initialize HTTP client
$client = HttpClient::create();

// Fetch logged-in user data (if needed)
$LoggedUser = $_POST['LoggedUser'];
$UserLevel = $_POST['UserLevel'];

// Fetch certificate order data from API
$response = $client->request('GET', $_ENV["SERVER_URL"] . '/packages/');
$graduationPackages = $response->toArray();

$response = $client->request('GET', $_ENV['SERVER_URL'] . '/convocation-registrations');
$packageBookings = $response->toArray();
?>

<div class="row mt-5">
    <div class="col-md-6 col-lg-3 d-flex">
        <div class="card item-card flex-fill">
            <div class="overlay-box">
                <i class="fa-solid fa-chart-line icon-card"></i>
            </div>
            <div class="card-body">
                <p>Packages</p>
                <h1><?= count($graduationPackages) ?></h1>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3 d-flex">
        <div class="card item-card flex-fill">
            <div class="overlay-box">
                <i class="fa-solid fa-chart-line icon-card"></i>
            </div>
            <div class="card-body">
                <p>Bookings</p>
                <h1><?= count($packageBookings) ?></h1>
            </div>
        </div>
    </div>
</div>

<div class="row g-2">
    <div class="col-md-8">
        <h5 class="table-title">Graduation Center</h5>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="graduation-table">
                        <thead>
                            <tr>
                                <th scope="col">Reference #</th>
                                <th scope="col">Student Number</th>
                                <th scope="col">Courses</th>
                                <th scope="col">Pacakge</th>
                                <th scope="col">Payments</th>
                                <th scope="col">Status</th>
                                <th scope="col">Registration Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Initialize an array to store seen hash values
                            $seenHashes = [];

                            foreach ($packageBookings as $booking) {
                                // Get the hash value from the current booking
                                $hashValue = $booking['hash_value'];

                                // Check if this hash value is already in the seen array
                                if (in_array($hashValue, $seenHashes)) {
                                    echo "<tr><td colspan='7' class='text-danger'>Duplicate image detected for student {$booking['student_number']}</td></tr>";
                                    continue; // Skip to the next booking
                                } else {
                                    // Add the hash value to the seen array
                                    $seenHashes[] = $hashValue;
                                }

                                $status = $booking['registration_status'];
                                $badgeClass = '';

                                // Determine the badge class based on the registration status
                                switch ($status) {
                                    case 'Pending':
                                        $badgeClass = 'badge bg-warning text-dark'; // Yellow/Orange badge
                                        break;
                                    case 'Confirmed':
                                        $badgeClass = 'badge bg-success'; // Green badge
                                        break;
                                    case 'Canceled':
                                        $badgeClass = 'badge bg-danger'; // Red badge
                                        break;
                                    case 'Completed':
                                        $badgeClass = 'badge bg-primary'; // Blue badge
                                        break;
                                    case 'On Hold':
                                        $badgeClass = 'badge bg-secondary'; // Grey badge
                                        break;
                                    default:
                                        $badgeClass = 'badge bg-info'; // Light blue badge for unknown status
                                        break;
                                }
                            ?>
                                <tr>
                                    <td><?= $booking['reference_number'] ?></td>
                                    <td><?= $booking['student_number'] ?></td>
                                    <td><?= $booking['course_id'] ?></td>
                                    <td><?= $booking['package_id'] ?></td>
                                    <td><?= $booking['payment_amount'] ?></td>
                                    <td></td>
                                    <td>
                                        <?php

                                        ?>
                                        <span class="badge <?= $badgeClass ?>"><?= ucfirst($status) ?></span>
                                    </td>
                                    <td><button class="btn btn-dark btn-sm">View</button></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <h5 class="table-title">Quick Links</h5>
        <div class="card">
            <div class="card-body">
                <ul class="mb-0">
                    <li><a href="#" onclick="OpenPackageModal()">Packages</a></li>
                </ul>
            </div>
        </div>
    </div>

</div>

<script>
    $('#graduation-table').dataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf'
            // 'colvis'
        ],
        order: [
            [0, 'asc']
        ]
    })
</script>