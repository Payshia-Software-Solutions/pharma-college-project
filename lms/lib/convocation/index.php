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

// Registration status control
$registrationsClosed = false; // Set to false to reopen registrations

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
        <div class="status-badge <?= $registrationsClosed ? 'status-closed' : '' ?>">
            <i class="fas fa-graduation-cap me-2"></i>
            <?= $registrationsClosed ? 'Registrations Closed' : 'Ready to Graduate' ?>
        </div>
    </div>

    <?php if ($registrationsClosed): ?>
        <!-- Registration Closed Notice -->
        <div class="alert alert-warning text-center mb-4"
            style="background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%); border: 2px solid #f39c12; border-radius: 15px; padding: 20px; box-shadow: 0 4px 15px rgba(243, 156, 18, 0.2);">
            <div class="d-flex align-items-center justify-content-center mb-2">
                <div class="text-center">
                    <i class="fas fa-exclamation-triangle me-3" style="font-size: 2rem; color: #e67e22;"></i>
                </div>
                <h3 class="mb-0" style="color: #d35400; font-weight: bold;">Registration Closed</h3>
            </div>
            <p class="mb-0" style="color: #8b4513; font-size: 1.1rem; font-weight: 500;">
                The convocation registration period has ended. New applications are no longer being accepted at this time.
            </p>
        </div>
    <?php endif; ?>

    <!-- Action Cards -->
    <div class="action-cards">
        <!-- Apply Convocation Card -->
        <div class="action-card apply-card <?= $registrationsClosed ? 'disabled-card' : '' ?>">
            <div class="card-icon <?= $registrationsClosed ? 'disabled-icon' : '' ?>">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <h3 class="card-title">Apply for Convocation</h3>
            <p class="card-description">
                Complete your graduation journey by applying for the official convocation ceremony.
                Submit your application and join the celebration of your academic achievement.
            </p>

            <?php if ($registrationsClosed): ?>
                <button class="action-btn btn-disabled" disabled>
                    <i class="fas fa-lock me-2"></i>
                    Registration Closed
                </button>
            <?php elseif (empty($convocationRecord)): ?>
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
                    <?= $registrationsClosed ?
                        'Complete your pending payments for your existing convocation application.' :
                        'Manage your payments and view your due balance. Complete any pending payments to proceed with your applications.' ?>
                </p>
                <a href="https://portal.pharmacollege.lk/payment/internal-payment" class="action-btn btn-pay">
                    <i class="fas fa-credit-card me-2"></i>
                    Pay Now
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
    /* Additional CSS for disabled state and closed registration styling */
    .disabled-card {
        opacity: 0.6;
        pointer-events: none;
        position: relative;
    }

    .disabled-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(108, 117, 125, 0.1);
        border-radius: inherit;
        z-index: 1;
    }

    .disabled-icon {
        color: #6c757d !important;
    }

    .btn-disabled {
        background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 8px;
        font-weight: 600;
        cursor: not-allowed;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        transition: none;
        opacity: 0.7;
    }

    .btn-disabled:hover {
        transform: none;
        box-shadow: none;
    }

    .status-closed {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        color: white;
    }

    /* Existing button styles for reference */
    .action-btn {
        display: inline-flex;
        align-items: center;
        padding: 12px 24px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }

    .btn-apply {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: white;
    }

    .btn-apply:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
        color: white;
        text-decoration: none;
    }

    .btn-pay {
        background: linear-gradient(135deg, #007bff 0%, #6610f2 100%);
        color: white;
    }

    .btn-pay:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
        color: white;
        text-decoration: none;
    }
</style>