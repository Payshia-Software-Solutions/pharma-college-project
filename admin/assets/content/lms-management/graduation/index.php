<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include '../../../../include/function-update.php';
include '../../../../include/lms-functions.php';
require __DIR__ . '/../../../../vendor/autoload.php';
define('PARENT_SEAT_RATE', 500); // example value

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

// Get Main Courses
$response = $client->request('GET', $_ENV['SERVER_URL'] . '/parent-main-course');
$mainCourses = $response->toArray();

$indexed_courses = [];
foreach ($mainCourses as $course) {
    $indexed_courses[$course['id']] = $course;
}

// Get Packages
$response = $client->request('GET', $_ENV['SERVER_URL'] . '/packages');
$packages = $response->toArray();
$indexed_packages = [];
foreach ($packages as $package) {
    $indexed_packages[$package['package_id']] = $package;
}

// Get Courier Orders
$response = $client->request('GET', $_ENV['SERVER_URL'] . '/certificate-orders');
$courierOrders = $response->toArray();

// Get Courier Orders
$response = $client->request('GET', $_ENV['SERVER_URL'] . '/assignmentsByCourse');
$allAssignments = $response->toArray();


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

    <div class="col-md-6 col-lg-3 d-flex">
        <div class="card item-card flex-fill">
            <div class="overlay-box">
                <i class="fa-solid fa-chart-line icon-card"></i>
            </div>
            <div class="card-body">
                <p>By Courier</p>
                <h1><?= count($courierOrders) ?></h1>
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-12 text-end">
        <button class="btn btn-dark btn-sm" type="button" onclick="OpenCourierList()">Curirer List</button>
        <button class="btn btn-dark btn-sm" type="button" onclick="OpenDownloadFile()">Download Convocation
            List</button>
    </div>
</div>

<div id="page-table">
    <div class="row g-2 mb-5">
        <div class="col-md-10">
            <h5 class="table-title">Graduation Center</h5>

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="graduation-table">
                            <thead>
                                <tr>
                                    <th scope="col">Reference #</th>
                                    <th scope="col">Action</th>
                                    <th scope="col">Ceremony number</th>
                                    <th scope="col">Student Number</th>
                                    <th scope="col">Session</th>
                                    <th scope="col">Courses</th>
                                    <th scope="col">Pacakge</th>
                                    <th scope="col">Additional Seats</th>
                                    <th scope="col">Package Amount</th>
                                    <th scope="col">Paid</th>
                                    <th scope="col">Slip</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Registration Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Initialize an array to store seen hash values
                                $seenHashes = [];

                                foreach ($packageBookings as $booking) {
                                    // Get the hash value from the current booking
                                    $hashValue = $booking['hash_value'];
                                    $studentnumber = trim($booking['student_number']);

                                    $duplicate_error_message = "";
                                    // Check if this hash value is already in the seen array
                                    if (in_array($hashValue, $seenHashes)) {
                                        $duplicate_error_message = "Duplicate";
                                    } else {
                                        // Add the hash value to the seen array
                                        $seenHashes[] = $hashValue;
                                    }
                                    $status = $booking['registration_status'];
                                    $badgeClass = '';
                                    $dueAmount = $indexed_packages[$booking['package_id']]['price'] + ($booking['additional_seats'] * PARENT_SEAT_RATE);

                                    if ($booking['registration_status'] === "paid" && $booking['payment_amount'] < $dueAmount) {
                                        $status = "Partially Paid";
                                    }

                                    // Determine the badge class based on the registration status
                                    switch ($status) {
                                        case 'Pending':
                                            $badgeClass = 'badge bg-warning text-dark'; // Yellow/Orange badge
                                            break;
                                        case 'Partially Paid':
                                            $badgeClass = 'badge bg-warning'; // Green badge
                                            break;
                                        case 'paid':
                                            $badgeClass = 'badge bg-secondary'; // Green badge
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

                                    $course_ids = explode(',', $booking['course_id']);
                                    $orderedParentIds = array_map('trim', explode(',', $booking['course_id']));

                                ?>
                                    <tr>
                                        <td><?= $booking['reference_number'] ?>

                                        </td>
                                        <td>
                                            <button type="button"
                                                onclick="OpenBooking('<?= $booking['reference_number'] ?>')"
                                                class="btn btn-dark btn-sm mb-2">View</button>

                                            <button type="button" onclick="SendCeremonyNumber('<?= $booking['reference_number'] ?>')" class="btn btn-dark btn-sm">Send</button>
                                        </td>
                                        <td><?= $booking['ceremony_number'] ?></td>
                                        <td><?= $booking['student_number'] ?></td>
                                        <td>
                                            <select name="session"
                                                onchange="changeBookingSession(<?= $booking['reference_number'] ?>, this.value)">
                                                <option value="1" <?= $booking['session'] == 1 ? 'selected' : '' ?>>1
                                                </option>
                                                <option value="2" <?= $booking['session'] == 2 ? 'selected' : '' ?>>2
                                                </option>
                                            </select>

                                        </td>
                                        <td><?php
                                            foreach ($course_ids as $id) {
                                                $id = trim($id); // remove spaces
                                                if (isset($indexed_courses[$id])) {
                                            ?>
                                                    <p><?= $indexed_courses[$id]['course_name']; ?></p>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <select name="package"
                                                onchange="changePackage(<?= $booking['reference_number'] ?>, this.value)">
                                                <?php foreach ($graduationPackages as $package): ?>
                                                    <option value="<?= $package['package_id'] ?>"
                                                        <?= $booking['package_id'] == $package['package_id'] ? 'selected' : '' ?>>
                                                        <?= htmlspecialchars($package['package_name']) ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </td>
                                        <td>
                                            <select name="additional_seats"
                                                onchange="changeAdditionalSeats(<?= $booking['reference_number'] ?>, this.value)">
                                                <?php for ($i = 0; $i <= 8; $i++): ?>
                                                    <option value="<?= $i ?>" <?= $booking['additional_seats'] == $i ? 'selected' : '' ?>><?= $i ?></option>
                                                <?php endfor; ?>
                                            </select>
                                        </td>

                                        <td><?= number_format($dueAmount, 2) ?></td>
                                        <td><?= $booking['payment_amount'] ?></td>
                                        <td>
                                            <a style="color: white !important;" class="btn btn-dark btn-sm"
                                                href="http://content-provider.pharmacollege.lk<?= $booking['image_path'] ?>"
                                                download target="_blank">
                                                <i class="fa fa-download" aria-hidden="true"></i>

                                            </a>
                                        </td>

                                        <td> <?php if (!empty($duplicate_error_message)): ?>
                                                <div class="badge bg-danger" role="alert">
                                                    <?= $duplicate_error_message ?>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php

                                            ?>
                                            <span class="badge <?= $badgeClass ?>"><?= ucfirst($status) ?></span>
                                        </td>
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
        <div class="col-md-2">
            <h5 class="table-title">Quick Links</h5>
            <div class="card">
                <div class="card-body">
                    <ul class="mb-0">
                        <li><a href="#" onclick="OpenPackageModal()">Packages</a></li>
                        <li><a href="#" onclick="OpenCertificateGeneratePage()">Certificate</a></li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    $('#graduation-table').dataTable({
        dom: 'Bfrtip',
        pageLength: 50,
        buttons: [
            'pdf'
            // 'colvis'
        ],
        order: [
            [0, 'asc']
        ]
    })
</script>