<?php
include './php_handler/course_functions.php';
$studentBalanceArray = GetStudentBalance($session);
$studentBalance      = $studentBalanceArray['studentBalance'];
?>
<style>
    .swal-like-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.4);
        z-index: 1999;
        animation: swal2-fade-in .3s;
    }

    .swal-like-modal {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: #fff;
        border-radius: 5px;
        text-align: center;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
        z-index: 2000;
        width: 32em;
        max-width: 100%;
        padding: 1.25em;
        animation: swal2-show .3s;
    }

    .swal-like-modal .swal-icon {
        margin: 20px auto;
        position: relative;
        box-sizing: content-box;
        animation: swal2-animate-error-icon .5s;
    }

    .swal-like-modal .swal-icon i {
        font-size: 65px;
        color: #f27474;
        animation: swal2-animate-error-icon .5s;
    }

    .swal-like-modal .swal-title {
        position: relative;
        padding: 13px 16px;
        font-size: 1.875em;
        font-weight: 600;
        text-align: center;
        color: #595959;
        margin: 0;
    }

    .swal-like-modal .swal-text {
        padding: 0 1.6em;
        margin-bottom: 1.6em;
        font-size: 1.125em;
        font-weight: normal;
        color: #545454;
        line-height: 1.5;
        text-align: center;
    }

    .swal-like-modal .swal-footer {
        margin: 1.25em 0 0;
        padding: 1em 0 0;
        border-top: 1px solid #eee;
    }

    .swal-like-modal .swal-confirm-button {
        background-color: #dc3545;
        color: #fff;
        border: 0;
        border-radius: 0.25em;
        font-size: 1.0625em;
        padding: 12px 30px;
        font-weight: 500;
        cursor: pointer;
        margin: 0 5px;
        transition: background-color .1s;
    }

    .swal-like-modal .swal-confirm-button:hover {
        background-color: #c82333;
    }

    .swal-like-modal .swal-cancel-button {
        background-color: #6c757d;
        color: #fff;
        border: 0;
        border-radius: 0.25em;
        font-size: 1.0625em;
        padding: 12px 30px;
        font-weight: 500;
        cursor: pointer;
        margin: 0 5px;
        transition: background-color .1s;
    }

    .swal-like-modal .swal-cancel-button:hover {
        background-color: #5a6268;
    }

    @keyframes swal2-fade-in {
        0% {
            opacity: 0;
        }

        100% {
            opacity: 1;
        }
    }

    @keyframes swal2-show {
        0% {
            transform: translate(-50%, -50%) scale(0.7);
        }

        45% {
            transform: translate(-50%, -50%) scale(1.05);
        }

        80% {
            transform: translate(-50%, -50%) scale(0.95);
        }

        100% {
            transform: translate(-50%, -50%) scale(1);
        }
    }

    @keyframes swal2-animate-error-icon {
        0% {
            transform: rotateX(100deg);
            opacity: 0;
        }

        100% {
            transform: rotateX(0deg);
            opacity: 1;
        }
    }
</style>


<!-- SweetAlert-like Modal -->
<div class="swal-like-overlay" id="dueBalanceOverlay"></div>
<div class="swal-like-modal" id="dueBalanceNotification">
    <div class="swal-icon">
        <i class="fas fa-exclamation-circle"></i>
    </div>
    <div class="swal-title">Payment Reminder</div>
    <div class="swal-text">
        You have a pending balance payment of <strong style="color: #dc3545">Rs.
            <?php echo number_format($studentBalance, 2); ?></strong><br>
        Please complete your payment to continue accessing all features.
    </div>
    <div class="swal-footer">
        <button class="swal-cancel-button" onclick="closeDueBalanceNotification()">Later</button>
        <button class="swal-confirm-button"
            onclick="redirectToURL('https://portal.pharmacollege.lk/payment/internal-payment')">
            Pay Now
        </button>
    </div>
</div>

<script>
    let dueBalanceTimer;
    let isNotificationVisible = false;

    function showDueBalanceNotification() {
        if (!isNotificationVisible) {
            const overlay = document.getElementById('dueBalanceOverlay');
            const modal = document.getElementById('dueBalanceNotification');

            overlay.style.display = 'block';
            modal.style.display = 'block';
            document.body.style.overflow = 'hidden'; // Prevent background scrolling
            isNotificationVisible = true;

            // Add scale animation class
            setTimeout(() => {
                modal.classList.add('swal2-show');
            }, 10);
        }
    }

    function closeDueBalanceNotification() {
        const overlay = document.getElementById('dueBalanceOverlay');
        const modal = document.getElementById('dueBalanceNotification');

        // Fade out animation
        modal.style.animation = 'swal2-hide .15s forwards';
        overlay.style.animation = 'swal2-fade-out .15s forwards';

        setTimeout(() => {
            overlay.style.display = 'none';
            modal.style.display = 'none';
            document.body.style.overflow = ''; // Restore scrolling
            // Reset animations
            modal.style.animation = '';
            overlay.style.animation = '';
        }, 150);

        isNotificationVisible = false;

        // Restart the timer when notification is closed
        clearTimeout(dueBalanceTimer);
        dueBalanceTimer = setTimeout(showDueBalanceNotification, 10000);
    }

    // Show notification immediately when page loads
    document.addEventListener('DOMContentLoaded', function() {
        const studentBalance = <?php echo $studentBalance; ?>;
        if (studentBalance > 0) {
            showDueBalanceNotification(); // Show immediately
            // Set up the timer for subsequent shows
            dueBalanceTimer = setTimeout(showDueBalanceNotification, 10000);
        }
    });
</script>