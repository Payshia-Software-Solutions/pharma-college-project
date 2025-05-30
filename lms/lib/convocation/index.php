<?php
require_once '../../include/configuration.php';
include '../../php_handler/function_handler.php';
require '../../vendor/autoload.php';
define('PARENT_SEAT_RATE', 500);

use Symfony\Component\HttpClient\HttpClient;
use Dotenv\Dotenv;

$client = HttpClient::create();
$dotenv = Dotenv::createImmutable(__DIR__ . '/../../')->load();

$UserLevel = $_POST['UserLevel'];
$loggedUser = $_POST['LoggedUser'];
// $loggedUser = "PA19134";
$packageDueAmount = 0;

try {
    $convocationRecord = $client->request('GET', $_ENV["SERVER_URL"] . '/convocation-registrations/check-duplicate/' . $loggedUser)->toArray()[0];
    $graduationPackage = $client->request('GET', $_ENV["SERVER_URL"] . '/packages/' . $convocationRecord['package_id'])->toArray();
    $packageDueAmount = $graduationPackage['price'] + ($convocationRecord['additional_seats'] * PARENT_SEAT_RATE) - $convocationRecord['payment_amount'];
} catch (\Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface $e) {
    if ($e->getCode() === 404) {
        $convocationRecord = [];
    } else {
        throw $e;
    }
}
?>

<!-- Floating Background Elements -->
<div class="floating-elements">
    <div class="floating-shape"></div>
    <div class="floating-shape"></div>
    <div class="floating-shape"></div>
</div>

<div class="main-container py-4">
    <!-- Header Section -->
    <div class="header-card">
        <div class="logo-container">
            <img src="./lib/certificate-center/assets/images/certificate.gif" class="game-logo" alt="Convocation Logo">
        </div>
        <h1 class="game-title">Convocation</h1>
        <p class="subtitle">Pharma Archivers</p>
        <div class="status-badge">
            <i class="fas fa-graduation-cap me-2"></i>
            Ready to Graduate
        </div>
    </div>

    <!-- Action Cards -->
    <div class="action-cards">
        <!-- Apply Convocation Card -->
        <div class="action-card apply-card">
            <div class="card-icon">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <h3 class="card-title">Apply for Convocation</h3>
            <p class="card-description">
                Complete your graduation journey by applying for the official convocation ceremony.
                Submit your application and join the celebration of your academic achievement.
            </p>

            <?php if (empty($convocationRecord)): ?>
                <a href="https://portal.pharmacollege.lk/graduation?studentNumber=<?= $loggedUser ?>"
                    class="action-btn btn-apply">
                    <i class="fas fa-paper-plane me-2"></i>
                    Apply Now
                </a>
            <?php else: ?>
                <span class="bg-warning badge">Already Applied</span>
            <?php endif; ?>
        </div>

        <?php if (!empty($convocationRecord)): ?>
            <!-- Balance & Payment Card -->
            <div class="action-card payment-card">
                <div class="card-icon">
                    <i class="fas fa-wallet"></i>
                </div>
                <h3 class="card-title">Due Balance</h3>
                <div class="balance-amount">
                    LKR <?= number_format($packageDueAmount) ?>
                </div>
                <p class="card-description">
                    Manage your payments and view your due balance.
                    Complete any pending payments to proceed with your applications.
                </p>
                <a href="https://portal.pharmacollege.lk/payment/internal-payment" class="action-btn btn-pay">
                    <i class="fas fa-credit-card me-2"></i>
                    Pay Now
                </a>
            </div>

        <?php endif; ?>
    </div>
</div>