<?php
require __DIR__ . '/../../../../../vendor/autoload.php';

use Dotenv\Dotenv;
use Symfony\Component\HttpClient\HttpClient;

define('PARENT_SEAT_RATE', 500);

$dotenv = Dotenv::createImmutable(dirname(__DIR__, 5))->load();
$client = HttpClient::create();

$referenceId = $_POST['referenceId'];
$bookingInfo = $client->request('GET', $_ENV['SERVER_URL'] . '/convocation-registrations/' . $referenceId)->toArray();
$studentInfo = $client->request('GET', $_ENV['SERVER_URL'] . '/get-student-full-info?loggedUser=' . $bookingInfo['student_number'])->toArray();
$studentBalanceInfo = $client->request('GET', $_ENV['SERVER_URL'] . '/get-student-balance?loggedUser=' . $bookingInfo['student_number'])->toArray();
$packageInfo = $client->request('GET', $_ENV["SERVER_URL"] . '/packages/' . $bookingInfo['package_id'])->toArray();
$dueAmount = $packageInfo['price'] + ($bookingInfo['additional_seats'] * PARENT_SEAT_RATE);
$courseBalance = $studentBalanceInfo['studentBalance'];
$convocationBalance = $dueAmount - $bookingInfo['payment_amount'];

function formatNameForCertificate($fullName, $maxLength = 30)
{
    // Normalize spaces and dots
    $fullName = preg_replace('/\s+/', ' ', $fullName); // Remove extra spaces
    $fullName = preg_replace('/(?<=\w)\.(?=\w)/', '. ', $fullName); // Add space after dots if missing (e.g. H.Virajini => H. Virajini)
    $fullName = trim($fullName);

    // Capitalize words properly
    $fullName = ucwords(strtolower($fullName));

    // If within character limit, return as-is
    if (strlen($fullName) <= $maxLength) {
        return $fullName;
    }

    // Break into words
    $words = explode(' ', $fullName);
    $numWords = count($words);

    if ($numWords < 3) {
        return substr($fullName, 0, $maxLength); // fallback for short names
    }

    // Last two full words (first name + surname)
    $lastTwo = array_slice($words, -2);
    $lastTwoStr = implode(' ', $lastTwo);

    // Initials from earlier words
    $initials = '';
    for ($i = 0; $i < $numWords - 2; $i++) {
        $word = $words[$i];
        // If word ends with a dot, keep it as-is (already an initial)
        if (preg_match('/^[a-zA-Z]\.$/', $word)) {
            $initials .= $word;
        } else {
            $initials .= strtoupper(substr($word, 0, 1)) . '.';
        }
    }

    $final = $initials . ' ' . $lastTwoStr;

    // Still too long? Truncate first of last two names
    if (strlen($final) > $maxLength) {
        $firstOfLastTwo = $lastTwo[0];
        $secondOfLastTwo = $lastTwo[1];
        $allowedLengthForFirst = $maxLength - strlen($initials) - strlen($secondOfLastTwo) - 2;
        $firstOfLastTwo = substr($firstOfLastTwo, 0, $allowedLengthForFirst);
        $final = $initials . ' ' . $firstOfLastTwo . ' ' . $secondOfLastTwo;
    }

    return $final;
}
?>

<div class="loading-popup-content">
    <div class="row">
        <div class="col-12 w-100 text-end">
            <button class="btn btn-sm btn-dark" onclick="ClosePopUP()"><i class="fa-regular fa-circle-xmark"></i></button>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <h5 class="text-center mb-2 border-bottom pb-2">Certificate Generation</h5>
            <div class="row">
                <div class="col-3">
                    <div>Reference #</div>
                    <strong><?= $bookingInfo['reference_number'] ?></strong>
                </div>

                <div class="col-3">
                    <div>Student Number</div>
                    <strong><?= $bookingInfo['student_number'] ?></strong>
                </div>

                <div class="col-4">
                    <div>Name on Certificate</div>
                    <strong><?= $studentInfo['studentInfo']['name_on_certificate'] ?></strong>
                </div>
            </div>


            <div class="row mt-2">
                <div class="col-3">
                    <div>Course Balance</div>
                    <strong><?= number_format($courseBalance, 2) ?></strong>
                </div>

                <div class="col-3">
                    <div>Convocation Balance</div>
                    <strong><?= number_format($convocationBalance, 2) ?></strong>
                </div>

                <div class="col-6">
                    <div>Print Name</div>
                    <strong><?= formatNameForCertificate($studentInfo['studentInfo']['name_on_certificate']) ?></strong>
                </div>
            </div>


            <?php if (floatval($courseBalance) == 0 && floatval($convocationBalance) == 0): ?>
                <div class="alert alert-success mt-2">
                    ✅ Eligible to generate certificate
                </div>
            <?php else: ?>
                <div class="alert alert-warning mt-2">
                    ⚠️ Payments are available to get
                </div>
            <?php endif; ?>

            <div class="row">
                <div class="col-8">
                    <label for="name-on-certificate">Name on Certificate</label>
                    <input type="text" name="name-on-certificate" id="name-on-certificate" class="form-control form-control-sm" value="<?= formatNameForCertificate($studentInfo['studentInfo']['name_on_certificate']) ?>" />
                </div>
                <div class="col-4">
                    <label for="ceromany_mnumber">Ceromany Number</label>
                    <input type="text" name="ceromony_number" id="ceromony_number" class="form-control form-control-sm" value="" />
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-12 text-end">
                    <button class="btn btn-dark" type="button" onclick="GenerateCertificate()">Generate Certificate</button>
                </div>
            </div>


        </div>
    </div>
</div>