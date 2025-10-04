<!-- Preloader -->
<div id="inner-preloader-content" class="preloader-content">
    <div class=" text-center">
        <div class="card-body p-5 my-5">
            <img src="./assets/images/loader.svg" alt="">
            <p class="mb-0">Please Wait...</p>
        </div>
    </div>
</div>

<div id="component-preloader-content" class="preloader-content">
    <div class=" text-center">
        <div class="card-body p-5 my-5">
            <img src="./assets/images/inner-loader.svg" alt="">
        </div>
    </div>
</div>

<div class="loading-popup" id="loading-popup">
    <div class="loading-popup-content" id="loading-popup-content">
        <div class="row mb-4">
            <div class="col-4 offset-4 text-center">
                <img src="./assets/images/logo.png" style="height: 40px">
            </div>
            <div class="col-4 text-end mb-2">
                <button class="btn btn-sm btn-light x-button" onclick="ClosePopUP()"><i class="fa-solid fa-xmark"></i></button>
            </div>
        </div>
        <div id="pop-content"></div>
    </div>
</div>



<style>
    /* Floating Button Styles */
    .floating-button {
        position: fixed;
        bottom: 12px;
        right: 20px;
        background-color: #007bff;
        color: #fff;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        cursor: pointer;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        z-index: 1000;
    }

    /* Due Balance Notification Styles */
    .due-balance-notification {
        display: none;
        position: fixed;
        top: 20px;
        right: 20px;
        background-color: #fff;
        border-left: 4px solid #dc3545;
        padding: 15px;
        border-radius: 4px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        z-index: 1001;
        min-width: 300px;
    }

    .due-balance-notification .close-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        cursor: pointer;
        color: #6c757d;
    }

    .due-balance-notification h4 {
        margin: 0 0 10px 0;
        color: #dc3545;
    }

    .due-balance-notification p {
        margin: 0;
        color: #495057;
    }
</style>
<div onclick="redirectToURL('live-chat')" class="floating-button" id="chatButton">
    <i class="fas fa-comment-alt"></i>
</div>

<!-- Due Balance Notification -->
<div class="due-balance-notification" id="dueBalanceNotification">
    <span class="close-btn" onclick="closeDueBalanceNotification()">
        <i class="fa-solid fa-xmark"></i>
    </span>
    <h4><i class="fas fa-exclamation-circle"></i> Payment Reminder</h4>
    <p>You have a pending balance payment. Please complete your payment to continue accessing all features.</p>
    <button class="btn btn-danger btn-sm mt-2" onclick="redirectToURL('https://portal.pharmacollege.lk/payment/internal-payment')">Upload slip</button>
</div>

<script>
    let dueBalanceTimer;
    let isNotificationVisible = false;

    function showDueBalanceNotification() {
        if (!isNotificationVisible) {
            const notification = document.getElementById('dueBalanceNotification');
            notification.style.display = 'block';
            isNotificationVisible = true;
        }
    }

    function closeDueBalanceNotification() {
        const notification = document.getElementById('dueBalanceNotification');
        notification.style.display = 'none';
        isNotificationVisible = false;

        // Restart the timer when notification is closed
        clearTimeout(dueBalanceTimer);
        dueBalanceTimer = setTimeout(showDueBalanceNotification, 30000);
    }

    // Start the notification cycle
    document.addEventListener('DOMContentLoaded', function() {
        // Check if there is a due balance (you need to implement this check)
        fetch('check-due-balance.php')
            .then(response => response.json())
            .then(data => {
                if (data.hasDueBalance) {
                    dueBalanceTimer = setTimeout(showDueBalanceNotification, 30000);
                }
            })
            .catch(error => console.error('Error checking due balance:', error));
    });
</script>