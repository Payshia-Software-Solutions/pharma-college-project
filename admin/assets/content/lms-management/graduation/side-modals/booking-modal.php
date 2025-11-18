<?php
require __DIR__ . '/../../../../../vendor/autoload.php';
include '../../../../../include/function-update.php';

// Get User Theme
$userThemeInput = isset($_POST['userTheme']) ? $_POST['userTheme'] : null;
$userTheme = getUserTheme($userThemeInput);


define('PARENT_SEAT_RATE', 500); // example value
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
$packageBooking = $response->toArray();

$response = $client->request('GET', $_ENV['SERVER_URL'] . '/parent-main-course/');
$mainCourses = $response->toArray();

$indexed_courses = [];
foreach ($mainCourses as $course) {
    $indexed_courses[$course['id']] = $course;
}

$response = $client->request('GET', $_ENV["SERVER_URL"] . '/packages/' . $packageBooking['package_id']);
$selectedPackage = $response->toArray();

$course_ids = explode(',', $packageBooking['course_id']);
$dueAmount = $selectedPackage['price'] + ($packageBooking['additional_seats'] * PARENT_SEAT_RATE);

$userInfo = $client->request('GET', $_ENV['SERVER_URL'] . '/get-student-full-info?loggedUser=' . $packageBooking['student_number'])->toArray();
$hashDupplicateStatus = $client->request('GET', $_ENV['SERVER_URL'] . '/convocation-registrations/check-hash?hashValue=' . $packageBooking['hash_value'])->toArray();

try {
    $getPaymentRecords = $client->request('GET', $_ENV['SERVER_URL'] . '/payment-portal-requests/by-reference/' . $packageBooking['student_number'])->toArray();
} catch (\Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface $e) {
    if ($e->getResponse()->getStatusCode() === 404) {
        $getPaymentRecords = [];
    } else {
        throw $e;
    }
}

try {
    $getPaymentTransactionRecords = $client->request('GET', $_ENV['SERVER_URL'] . '/tc-payments?student_number=' . $packageBooking['student_number'] . '&referKey=covocation-payment')->toArray();
} catch (\Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface $e) {
    if ($e->getResponse()->getStatusCode() === 404) {
        $getPaymentTransactionRecords = [];
    } else {
        throw $e;
    }
}

$totalPayments = 0;
foreach ($getPaymentTransactionRecords as $record) {
    $totalPayments += $record['payment_amount'];
}

$balance = $dueAmount - $totalPayments;

?>
<div class="loading-popup-content-right <?= htmlspecialchars($userTheme) ?>">
    <div class="row">
        <div class="col-6">
            <h3 class="mb-0">Booking Info</h3>
        </div>

        <div class="col-6 text-end">
            <button class="btn btn-warning btn-sm" onclick="OpenBooking('<?= $referenceNumber ?>')" type="button"><i
                    class="fa solid fa-refresh"></i> Reload</button>
            <button class="btn btn-light btn-sm" onclick="ClosePopUPRight(0)" type="button"><i
                    class="fa solid fa-xmark"></i> Cancel</button>
        </div>

        <div class="col-12">
            <div class="border-bottom border-5 my-2"></div>
        </div>
    </div>



    <div class="row">
        <div class="col-md-8">
            <div class="row g-2">
                <div class="col-3">
                    <div class="card">
                        <div class="card-body">
                            <p class="mb-0">Ref #</p>
                            <h5><?= $packageBooking['reference_number'] ?></h5>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card">
                        <div class="card-body">
                            <p class="mb-0">Student Number</p>
                            <h5><?= $packageBooking['student_number'] ?></h5>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <p class="mb-0">Courses</p>
                            <?php
                            foreach ($course_ids as $id) {
                                $id = trim($id); // remove spaces
                                if (isset($indexed_courses[$id])) {
                            ?>
                            <h5><?= $indexed_courses[$id]['course_name']; ?></h5>
                            <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card">
                        <div class="card-body">
                            <p class="mb-0">Payment Status</p>
                            <h5><?= $packageBooking['registration_status'] ?></h5>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card">
                        <div class="card-body">
                            <p class="mb-0">Course Balance</p>
                            <h5><?= number_format($userInfo['studentBalance']['studentBalance'], 2) ?></h5>
                        </div>
                    </div>
                </div>

                <div class="col-3">
                    <div class="card">
                        <div class="card-body">
                            <p class="mb-0">Additional Seats</p>
                            <h5><?= $packageBooking['additional_seats'] ?></h5>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card">
                        <div class="card-body">
                            <p class="mb-0">Payble Amount</p>
                            <h5><?= number_format($dueAmount, 2) ?></h5>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <p class="mb-0">Package</p>
                            <h5><?= $selectedPackage['package_name'] ?></h5>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-3 g-2">
                <?php if (!empty($getPaymentRecords)) : ?>
                <?php foreach ($getPaymentRecords as $index => $record) : ?>
                <?php
                        $uniqueId = $record['unique_number'] ?? ('record_' . $index);
                        try {
                            $checkHashInfo = $client->request('GET', $_ENV['SERVER_URL'] . '/payment-portal-requests/check-hash?hashValue=' . $record['hash_value'])->toArray();
                        } catch (\Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface $e) {
                            $checkHashInfo = [];
                        }
                        ?>
                <div class="col-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <?php
                                    $filePath = $record['slip_path'];
                                    $fullUrl = "https://content-provider.pharmacollege.lk" . $filePath;
                                    $fileExtension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

                                    if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                                        // Show image
                                        echo '<img class="w-100" src="' . $fullUrl . '" alt="Payment Sip">';
                                    } elseif ($fileExtension === 'pdf') {
                                        // Show link to PDF
                                        echo '<a href="' . $fullUrl . '" target="_blank" class="btn btn-primary">View PDF Receipt</a>';
                                    } else {
                                        // Optional: Handle unsupported file types
                                        echo '<p>Unsupported file type.</p>';
                                    }
                                    ?>

                            <?php if (!empty($checkHashInfo)) : ?>
                            <div class="mt-3">
                                <h6>Duplicate Payments (<?= count($checkHashInfo) ?>)</h6>
                                <ul class="list-group">
                                    <?php foreach ($checkHashInfo as $dup) : ?>
                                    <li class="list-group-item">
                                        <strong>Reference:</strong> <?= htmlspecialchars($dup['payment_reference']) ?>
                                        <br>
                                        <strong>Amount:</strong> <?= htmlspecialchars($dup['paid_amount']) ?> <br>
                                        <strong> <a target="_blank" class="btn btn-dark btn-sm text-light"
                                                href="https://content-provider.pharmacollege.lk<?= $dup['slip_path'] ?>">Download
                                                Slip</a></strong>
                                    </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <?php else : ?>
                            <p class="mt-3 text-muted">No duplicate payments found.</p>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php else : ?>
                <div class="col-12">
                    <div class="card mt-2">
                        <div class="card-body">
                            <p class="text-center mb-0">No payment requests found.</p>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>


            <div class="row my-2 g-2">
                <div class="col-12">
                    <h5 class="table-title">Enrollments</h5>
                </div>
                <?php foreach ($userInfo['studentEnrollments'] as $enrollment) { ?>
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <p class="mb-0"><?= $enrollment['course_code'] ?> | <?= $enrollment['batch_name'] ?></p>

                            <div class="row g-2">
                                <?php
                                    $totalAssingmentMarks = 0;
                                    $courseAssignments = $enrollment['assignment_grades']['assignments'];
                                    foreach ($courseAssignments as $assignment) {
                                        $assignmentGrade = $assignment['grade'];
                                        $totalAssingmentMarks += $assignmentGrade;
                                    ?>
                                <div class="col-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <p class="mb-0"><?= $assignment['assignment_name'] ?></p>
                                            <h5><?= number_format($assignmentGrade, 2) ?>
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                    }

                                    $avgMarks = (count($courseAssignments) != 0) ? $totalAssingmentMarks / count($courseAssignments) : 0;
                                    ?>
                                <div class="col-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <p class="mb-0">Average</p>
                                            <h5><?= number_format($avgMarks, 2) ?>
                                            </h5>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <?php
                }
                ?>


            </div>

            <?php if (count($hashDupplicateStatus) > 1) : ?>
            <div class="row g-2">
                <div class="col-12">
                    <h5 class="table-title">Slip Dupplicate Status</h5>
                </div>
                <?php foreach ($hashDupplicateStatus as $hashRecord) {
                    ?>
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <p><?= $hashRecord['registration_id'] ?> | <?= $hashRecord['student_number'] ?></p>
                            <p>
                                <a target="_blank"
                                    href="https://content-provider.pharmacollege.lk<?= $hashRecord['image_path'] ?>">Download
                                    Slip</a>
                            </p>
                        </div>
                    </div>

                </div>
                <?php
                    }
                    ?>

            </div>
            <?php endif ?>
        </div>

        <div class="col-md-4">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4>Payment Details</h4>
                            <p class="mb-0">Total Due Amount: <strong><?= number_format($dueAmount, 2) ?></strong></p>
                            <p class="mb-0">Total Payments: <strong><?= number_format($totalPayments, 2) ?></strong></p>
                            <p class="mb-0">Balance: <strong><?= number_format($balance, 2) ?></strong></p>

                            <?php if ($balance > 0) : ?>
                            <p class="text-danger mb-0">Payment is pending.</p>
                            <label for="paid_amount" class="mb-2">Payment Amount</label>
                            <input type="text" class="form-control text-center" placeholder="Payment Amount"
                                name="paid_amount" id="paid_amount">

                            <button onclick="UpdateConvocationPayment('<?= $referenceNumber ?>')"
                                class="w-100 btn btn-dark mt-2"
                                type="button"><?= strtolower($packageBooking['registration_status']) === 'paid' ? 'Add Payment' : 'Approve & Update Payment' ?>
                            </button>
                            <?php else : ?>
                            <p class="text-success mb-0">Payment is complete.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <?php if (count($getPaymentTransactionRecords) > 0) : ?>
                <div class="col-12">
                    <h5 class="table-title">Payment Transactions</h5>
                </div>
                <?php foreach ($getPaymentTransactionRecords as $record) : ?>
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <p class="mb-0"><?= $record['reference'] ?></p>
                            <p class="mb-0"><?= $record['transaction_id'] ?>
                            <p class="mb-0"><?= $record['payment_amount'] ?></p>
                            <p class="mb-0"><?= $record['rec_time'] ?></p>

                            <button class="btn btn-danger btn-sm" type="button"
                                onclick="InactivePayment('<?= $record['id'] ?>', '<?= $referenceNumber ?>')">Inactive</button>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php else : ?>
                <div class="col-12">
                    <div class="card mt-2">
                        <div class="card-body">
                            <p class="text-center mb-0">No payment transactions found.</p>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>




            <div class="row mb-2 mt-2">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4>Main Payment</h4>
                            <?php
                            $filePath = $packageBooking['image_path'];
                            $fullUrl = "https://content-provider.pharmacollege.lk" . $filePath;
                            $fileExtension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

                            if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                                // Show image
                                echo '<img class="w-100" src="' . $fullUrl . '" alt="Payment Sip">';
                            } elseif ($fileExtension === 'pdf') {
                                // Show link to PDF
                                echo '<a href="' . $fullUrl . '" target="_blank" class="btn btn-primary">View PDF Receipt</a>';
                            } else {
                                // Optional: Handle unsupported file types
                                echo '<p>Unsupported file type.</p>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>




        </div>
    </div>
</div>