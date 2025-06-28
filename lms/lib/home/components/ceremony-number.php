<?php

require '../../vendor/autoload.php';

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Dotenv\Dotenv;

$client = HttpClient::create();

$dotenv = Dotenv::createImmutable(__DIR__ . '/../../../');
$dotenv->load();
include './components/css.php';

$ceremonyNumberArray = [];
try {
    $ceremonyNumberArray = $client->request('GET', $_ENV['SERVER_URL'] . '/convocation-registrations/get-ceremony-number/' . $loggedUser)->toArray();
    // $ceremonyNumberArray = $client->request('GET', $_ENV['SERVER_URL'] . '/convocation-registrations/get-ceremony-number/PA19257')->toArray();
} catch (ClientExceptionInterface | TransportExceptionInterface $e) {
    if (method_exists($e, 'getCode') && $e->getCode() !== 404) {
        throw $e;
    }
}
$UserDetails =  GetUserDetails($link, $loggedUser);

?>
<div class="row my-4">
    <div class="col-12 text-center">
        <?php if (!empty($ceremonyNumberArray)) {
            $balances = $ceremonyNumberArray['balances'] ?? [];
            $registrationInfo = $ceremonyNumberArray['registration'] ?? [];
        ?>
        <div class="ceremony-card">
            <div class="header">
                <div class="ceremony-title">
                    <div class="ceremony-icon">🎓</div>
                    Your Ceremony Number
                </div>

                <?php if ($balances['total_due'] <= 0) { ?>
                <div class="ceremony-number"><?= $ceremonyNumberArray['ceremony_number'] ?? 'Not Processed' ?></div>
                <?php } else { ?>

                <div class="ceremony-number">Not Processed</div>
                <div class="status-badge">
                    <div class="warning-icon">!</div>
                    Your Ceremony Number is not processed due to unpaid balances
                </div>
                <?php } ?>

                <div class="ceremony-title">
                    <div class="ceremony-icon">👤</div>
                    Name on Certificate
                </div>
                <div class="ceremony-number"><?= $UserDetails['name_on_certificate'] ?></div>

                <!-- Registration Information Section -->
                <div class="registration-info">
                    <div class="info-title">
                        📋 Registration Details
                    </div>

                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label">Session</div>
                            <div class="info-value"><?= $registrationInfo['session'] ?></div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">Additional Seats</div>
                            <div class="info-value"><?= $registrationInfo['additional_seats'] ?></div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">Reference Number</div>
                            <div class="info-value"><?= $registrationInfo['reference_number'] ?></div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">Payment Amount</div>
                            <div class="info-value">Rs. <?= $registrationInfo['payment_amount'] ?></div>
                        </div>
                    </div>
                </div>


            </div>

            <?php if ($balances['total_due'] > 0) { ?>
            <div class="payment-details">
                <div class="payment-title">
                    💳 Outstanding Balance Details
                </div>

                <div class="balance-item">
                    <span class="balance-label">Course Fees</span>
                    <span class="balance-amount">Rs. <?= number_format($balances['course_balance'] ?? 0, 2) ?></span>
                </div>

                <div class="balance-item">
                    <span class="balance-label">Convocation Fees</span>
                    <span class="balance-amount">Rs.
                        <?= number_format($balances['convocation_balance'] ?? 0, 2) ?></span>
                </div>

                <div class="balance-item">
                    <span class="balance-label">Total Amount Due</span>
                    <span class="balance-amount">Rs.
                        <?= number_format($balances['total_due'] ?? 0, 2) ?></span>
                </div>
            </div>


            <button class="action-button">
                💳 Pay Now to Process Ceremony Number
            </button>

            <?php } ?>

            <p class="help-text">
                Your ceremony number will be generated automatically once all outstanding balances are cleared.
                <br><strong>Need help?</strong> Contact our support team.
            </p>
        </div>
        <?php } ?>
    </div>

</div>

<script>
document.querySelector('.action-button').addEventListener('click', function() {
    this.innerHTML = '⏳ Redirecting to Payment...';
    this.style.background = 'linear-gradient(135deg, #28a745, #20c997)';

    // Simulate redirect delay
    setTimeout(() => {
        window.location.href = 'https://portal.pharmacollege.lk/payment/internal-payment';
    }, 2000);
});
</script>