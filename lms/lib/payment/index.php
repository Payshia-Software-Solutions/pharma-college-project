<?php
require_once '../../include/configuration.php';
include '../../php_handler/function_handler.php';
include '../../php_handler/course_functions.php';

// Include Classes
include_once './classes/Database.php';
include_once './classes/StudentPayment.php';
include_once './classes/Students.php';
// Create a new Database object with the path to the configuration file
$config_file = '../../include/env.txt';
$database = new Database($config_file);
$db = $database->getConnection();

if (isset($_POST['LoggedUser'])) {
    $loggedUser = $_POST['LoggedUser'];
} else {
    echo "Request Cannot be completed";
    exit;
}


$enrollmentList =  getUserEnrollments($loggedUser);
$batchList =  GetCourses($link);

$Students = new Students($database);
$studentId = $Students->GetStudentIdByUserName($loggedUser);
$studentPayments = new StudentPayment($database);
$studentPaymentRecords = $studentPayments->fetchByStudentId($studentId);

$studentBalanceArray = GetStudentBalance($loggedUser);
$dueBalance = $studentBalanceArray['studentBalance'];
?>
<div class="row mt-2 mb-5">
    <div class="col-12 mt-3">
        <div class="card shadow mt-5 border-0">
            <div class="card-body">
                <div class="quiz-img-box sha">
                    <img src="./lib/payment/assets/images/money.gif" class="quiz-img shadow rounded-4">
                </div>
                <h1 class="card-title text-center mt-2 fw-bold bg-light p-3 rounded-5 mb-0">Payment Portal</h1>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-8">
        <div class="card border-0 shadow-lg rounded-4">
            <div class="card-body">

                <div class="text-center">
                    <div class="p-2 fw-bold">Due Balance</div>
                    <h1 class="fw-bold">Rs. <?= number_format($dueBalance, 2) ?></h1>
                </div>

                <div class="border-bottom my-3"></div>
                <div class="row">
                    <div class="col-12 text-end">
                        <button onclick="openSlipUpload()" type="button" class="btn btn-primary"><i
                                class="fa-solid fa-upload"></i> Upload
                            Slip</button>
                        <button type="button" class="btn btn-dark"><i class="fa-solid fa-credit-card"></i> Pay
                            Now</button>
                    </div>
                </div>

            </div>
        </div>

        <div class="border-bottom my-4"></div>
        <h4 class="fw-bold border-bottom pb-2 mb-3">Your Enrollments</h4>
        <div class="row g-3">
            <?php if (!empty($enrollmentList)) : ?>
            <?php foreach ($enrollmentList as $selectedArray) :

                    $batchCode =  $selectedArray['course_code'];
                    $coursePaymentTotal = $studentPayments->fetchByCourseIdTotal($batchCode, $studentId);
                    $courseInfo = $batchList[$batchCode];

                    $courseFee = $courseInfo['course_fee'];
                    $registration_fee = $courseInfo['registration_fee'];
                    $coursePayments = $coursePaymentTotal['payments'];
                    $courseDiscounts = $coursePaymentTotal['discounts'];
                    $courseDueAmount = ($courseFee + $registration_fee) - ($coursePayments + $courseDiscounts);

                ?>
            <div class="col-12">
                <div class="card shadow border-0 rounded-3">
                    <div class="card-body">
                        <div class="row g-2">
                            <div class="col-6 col-12">
                                <span
                                    class="badge text-light mb-2 bg-primary"><?= $selectedArray['course_code'] ?></span>
                                <h5 class="mb-0 border-bottom pb-2">
                                    <?= $batchList[$selectedArray['course_code']]['course_name'] ?></h5>
                            </div>
                            <div class="col-12 col-lg-4 text-center text-md-start d-flex">
                                <div class="card bg-light border-0 flex-fill">
                                    <div class="card-body">
                                        <p class="mb-0">Course & Registration Fee </p>
                                        <h5 class="fw-bold mb-0"><?= number_format($courseFee, 2) ?> +
                                            <?= number_format($registration_fee, 2) ?> </h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-lg-3 text-center text-md-start d-flex">
                                <div class="card bg-light border-0 flex-fill">
                                    <div class="card-body">
                                        <p class="mb-0">Payments</p>
                                        <h5 class="fw-bold mb-0"><?= number_format($coursePayments, 2) ?></h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-lg-2 text-center text-md-start d-flex">
                                <div class="card bg-light border-0 flex-fill">
                                    <div class="card-body">
                                        <p class="mb-0">Discounts</p>
                                        <h5 class="fw-bold mb-0"><?= number_format($courseDiscounts, 2) ?></h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-3 text-center text-md-start d-flex">
                                <div class="card bg-light border-0 flex-fill">
                                    <div class="card-body">
                                        <p class="mb-0">Due Amount</p>
                                        <h2 class="fw-bold mb-0 due-balance"><?= number_format($courseDueAmount, 2) ?>
                                        </h2>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
            <?php endforeach ?>
            <?php endif ?>
        </div>
    </div>
    <div class="col-md-4">
        <h4 class="fw-bold border-bottom pb-2 mb-3">Payment History</h4>
        <div class="row g-2">
            <?php foreach ($studentPaymentRecords as $selectedArray) :

                $dateTime = new DateTime($selectedArray['created_at']);
                $formattedDate = $dateTime->format('Y-m-d H:i');
                $batchName = $selectedArray['course_code'];

            ?>
            <div class="col-12">
                <div class="card shadow border-0 rounded-4">
                    <div class="card-body">
                        <div class="row g-2">
                            <div class="col-8">
                                <p class="mb-0 text-muted fw-bold">Paid Amount</p>
                                <h3 class="mb-0">Rs. <?= number_format($selectedArray['paid_amount'], 2) ?></h3>
                            </div>
                            <div class="col-4 text-end">
                                <p class="mb-0 text-muted fw-bold">Discount</p>
                                <h5 class="mb-0">Rs. <?= number_format($selectedArray['discount_amount'], 2) ?></h5>
                            </div>
                            <div class="col-6">
                                <p class="mb-0 text-muted">Receipt No</p>
                                <p class="mb-0"><?= $selectedArray['receipt_number'] ?></p>
                            </div>
                            <div class="col-6 text-end">
                                <p class="mb-0 text-muted">Payment Type</p>
                                <p class="mb-0"><?= $selectedArray['payment_type'] ?></p>
                            </div>

                            <div class="col-6">
                                <p class="mb-0 text-muted">Course</p>
                                <p class="mb-0"><?= $batchName ?></p>
                            </div>

                            <div class="col-6 text-end">
                                <p class="mb-0 text-muted">Date</p>
                                <p class="mb-0"><?= $formattedDate ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach ?>
        </div>
    </div>
</div>

<!-- Script to add random bubbles -->
<script>
var card = document.getElementById("bubbleCard");
var positionPoints = [
    ['20%', '60%', '60px'],
    ['50%', '0%', '40px'],
    ['-10%', '20%', '100px'],
    ['80%', '65%', '50px'],
    ['75%', '30%', '90px'],
    ['10%', '65%', '15px']
];

for (let i = 0; i < positionPoints.length; i++) {
    xPos = positionPoints[i][0];
    yPos = positionPoints[i][1];
    widthVal = positionPoints[i][2];
    createBubble(card, xPos, yPos, widthVal);
}


var gradeValueInput = document.getElementById('gradeValue');
var overallDpadGrade = parseFloat(gradeValueInput.value);
var counterElement = document.getElementById('counter');

function updateCounter(element, value) {
    // alert(element.textContent)
    element.textContent = value.toFixed(1);
}

function loadCounter(element, targetValue) {
    let currentCounterValue = 0.0;
    const interval = 25; // Adjust the interval as needed
    const step = targetValue / (1000 / interval);

    const counterInterval = setInterval(function() {
        currentCounterValue += step;
        updateCounter(element, currentCounterValue);

        if (currentCounterValue >= targetValue) {
            clearInterval(counterInterval);
            updateCounter(element, targetValue);
        }
    }, interval);
}

// Call the function to start loading the counter for counterElement
loadCounter(counterElement, overallDpadGrade);



var answerCards = document.querySelectorAll('.answer-card');

// Add a click event listener to each '.answer-card' element
answerCards.forEach(function(card) {
    card.addEventListener('click', function() {
        var radioInput = card.querySelector('input[type="radio"]');
        radioInput.checked = !radioInput.checked;
    });
});
</script>