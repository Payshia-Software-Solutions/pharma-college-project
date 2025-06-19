<?php

require '../../vendor/autoload.php';

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Dotenv\Dotenv;

$client = HttpClient::create();

$dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();
include './components/css.php';

try {
    $ceremonyNumberArray = $client
        ->request('GET', $_ENV['SERVER_URL'] . '/convocation-registrations/get-balances-student-number/' . $loggedUser)
        ->toArray();
} catch (ClientExceptionInterface | TransportExceptionInterface $e) {
    if (method_exists($e, 'getCode') && $e->getCode() !== 404) {
        throw $e;
    }
}
?>
<div class="row">
    <div class="col-12 text-center">
        <div class="ceremony-card">
            <div class="header">
                <div class="ceremony-title">
                    <div class="ceremony-icon">🎓</div>
                    Your Ceremony Number
                </div>
                <div class="ceremony-number">N/A</div>
                <div class="status-badge">
                    <div class="warning-icon">!</div>
                    Processing Pending
                </div>
            </div>

            <div class="payment-details">
                <div class="payment-title">
                    💳 Outstanding Balance Details
                </div>

                <div class="balance-item">
                    <span class="balance-label">Course Fees</span>
                    <span class="balance-amount">Rs. {{COURSE_BALANCE}}</span>
                </div>

                <div class="balance-item">
                    <span class="balance-label">Convocation Fees</span>
                    <span class="balance-amount">Rs. {{CONVOCATION_BALANCE}}</span>
                </div>

                <div class="balance-item">
                    <span class="balance-label">Total Amount Due</span>
                    <span class="balance-amount total-amount">Rs. {{TOTAL_DUE}}</span>
                </div>
            </div>

            <button class="action-button">
                💳 Pay Now to Process Ceremony Number
            </button>

            <p class="help-text">
                Your ceremony number will be generated automatically once all outstanding balances are cleared.
                <br><strong>Need help?</strong> Contact our support team.
            </p>
        </div>
    </div>

</div>

<script>
// Add some interactive feedback
document.querySelector('.action-button').addEventListener('click', function() {
    this.innerHTML = '⏳ Redirecting to Payment...';
    this.style.background = 'linear-gradient(135deg, #28a745, #20c997)';

    // Simulate redirect delay
    setTimeout(() => {
        this.innerHTML = '💳 Pay Now to Process Ceremony Number';
        this.style.background = 'linear-gradient(135deg, #667eea, #764ba2)';
    }, 2000);
});

// Add hover effect to balance items
document.querySelectorAll('.balance-item').forEach(item => {
    item.addEventListener('mouseenter', function() {
        this.style.backgroundColor = '#e9ecef';
        this.style.borderRadius = '8px';
        this.style.margin = '0 -12px';
        this.style.padding = '12px';
    });

    item.addEventListener('mouseleave', function() {
        this.style.backgroundColor = 'transparent';
        this.style.borderRadius = '0';
        this.style.margin = '0';
        this.style.padding = '12px 0';
    });
});
</script>