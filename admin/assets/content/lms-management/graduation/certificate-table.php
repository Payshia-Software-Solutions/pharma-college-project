<?php
require __DIR__ . '/../../../../vendor/autoload.php';
define('PARENT_SEAT_RATE', 500);

// For use env file data & HTTP client
use Dotenv\Dotenv;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

$dotenv = Dotenv::createImmutable(dirname(__DIR__, 4))->load();
$client = HttpClient::create();

$LoggedUser = $_POST['LoggedUser'];
$UserLevel = $_POST['UserLevel'];

if (strtolower($UserLevel) != 'admin') die('Access denied');

$courseCode = isset($_POST['courseCode']) ? $_POST['courseCode'] : null;
$showSession = isset($_POST['showSession']) ? $_POST['showSession'] : null;

$packageBookings = [];
$packageBookingsByCourse = [];
$packageBookingsBySession = [];

if (isset($courseCode) && isset($showSession)) {
    $packageBookings = $client->request(
        'GET',
        $_ENV['SERVER_URL'] . '/convocation-registrations?courseCode=' . $courseCode . '&viewSession=' . $showSession
    )->toArray();
}

if (isset($courseCode)) {
    $packageBookings = $client->request(
        'GET',
        $_ENV['SERVER_URL'] . '/convocation-registrations?courseCode=' . $courseCode
    )->toArray();
}

if (isset($showSession)) {
    $packageBookings = $client->request(
        'GET',
        $_ENV['SERVER_URL'] . '/convocation-registrations?viewSession=' . $showSession
    )->toArray();
}



?>

<div class="card">
    <div class="card-body">
        <h6 class="table-title m-0 mb-2">Course - <?= $courseCode ?> | Session - <?= $showSession ?></h4>
            <div class="table-responsive">
                <table class="table table-striped table-hover" id="certificate-table">
                    <thead>
                        <tr>
                            <th scope="col">Reference #</th>
                            <th scope="col">Student Number</th>
                            <th scope="col">Session</th>
                            <th scope="col">Course</th>
                            <th scope="col">Paid</th>
                            <th scope="col">Grade</th>
                            <th scope="col">Registration Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <?php
                    /* 1️⃣ Fire every request — store (studentId => ResponseInterface) */
                    $requests = [];
                    foreach ($packageBookings as $booking) {
                        $studentId = $booking['student_number'];

                        $requests[$studentId] = $client->request(
                            'GET',
                            $_ENV['SERVER_URL'] .
                                '/submissions/average-grade?studentId=' . $studentId .
                                '&courseCode=' . $courseCode,
                            [
                                // user_data lets us recover the studentId inside the stream loop
                                'user_data' => $studentId,
                            ]
                        );
                    }

                    /* 2️⃣ Collect the results as soon as each finishes */
                    $gradesMap = []; // [studentId => average_grade]
                    foreach ($client->stream($requests) as $response => $chunk) {
                        if (!$chunk->isLast()) {
                            // skip until the body is fully received
                            continue;
                        }

                        $studentId = $response->getInfo('user_data'); // the key we set above
                        try {
                            $data = $response->toArray(false); // don’t throw on invalid JSON
                            if (is_array($data) && isset($data['average_grade'])) {
                                $gradesMap[$studentId] = $data['average_grade'];
                            }
                        } catch (TransportExceptionInterface | DecodingExceptionInterface $e) {
                            // ignore; student will fall back to 'N/A'
                        }
                    }
                    ?>

                    <tbody>
                        <?php foreach ($packageBookings as $booking): ?>
                            <?php
                            $studentId = $booking['student_number'];
                            $avg       = $gradesMap[$studentId] ?? 'N/A';
                            ?>
                            <tr>
                                <td><?= $booking['registration_id'] ?></td>
                                <td><?= $studentId ?></td>
                                <td><?= $booking['session'] ?></td>
                                <td><?= $booking['course_id'] ?></td>
                                <td><?= $booking['payment_amount'] ?></td>
                                <th scope="col"><?= $avg ?></th>
                                <td><?= $booking['registration_status'] ?></td>
                                <td>
                                    <button
                                        class="btn btn-dark btn-sm"
                                        type="button"
                                        onclick="OpenCertificateModel('<?= $booking['registration_id'] ?>')">
                                        View
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
    </div>
</div>

<script>
    $('#certificate-table').dataTable({
        dom: 'Bfrtip',
        pageLength: 50,
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print',
            // 'colvis'
        ],
        order: [
            [4, 'dsc']
        ]
    })
</script>