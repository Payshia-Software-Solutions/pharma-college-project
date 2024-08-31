<?php
require_once '../../include/configuration.php';
include '../../php_handler/function_handler.php';

$loggedUser = $_POST['LoggedUser'];
$UserLevel = $_POST['UserLevel'];
$userAnswer = 0;
// $UserLevel = "Student";
$prescriptionID = $_POST['prescriptionID'];
$patient =  GetPatients($link)[$prescriptionID];

$userAnswer = GetUserPaymentAnswer($link, $loggedUser, $prescriptionID, 'Answer Correct');
$AnswerPaymentValue = "";
if ($UserLevel != "Student") {
    $AnswerPaymentValue =  GetPaymentValue($link, $prescriptionID);
} else {
    $AnswerPaymentValue = $userAnswer;
}
?>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Indie+Flower&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

    .handwrite {
        font-family: 'Indie Flower', cursive;
        font-size: 20 px;
    }

    .prescription-card {
        background-color: #FFFEFE;
        border: 15px solid #009E60;
        border-radius: 0px !important;
    }

    .prescription-card .mini-text {
        font-size: 10px;
    }

    .envelope-button-set {
        position: fixed;
        bottom: 88px;
        left: 0;
    }

    #root {
        padding-bottom: 20px;
    }

    input {
        box-shadow: none !important;
    }
</style>

<div class="row">
    <div class="col-12 text-end mt-3">
        <button class="btn btn-success btn-sm rounded-3" onclick="GetPatient('<?= $prescriptionID ?>')"><i class="fa-solid fa-arrow-left player-icon"></i> Back</button>
        <button class="btn btn-dark btn-sm rounded-3" onclick="OpenPayment('<?= $prescriptionID ?>')"><i class="fa-solid fa-rotate-right player-icon"></i> Reload</button>
        <button class="btn btn-warning btn-sm rounded-3" onclick="OpenIndex()"><i class="fa-solid fa-home player-icon"></i> Home</button>
    </div>
    <div class="col-12">
        <h4 class="section-topic mb-0">Task 3</h4>
        <p class="my-0 border-bottom pb-2 mini-text">Take Payment</p>
    </div>

    <div class="col-12 col-md-4 mb-2 d-none d-md-block" id="prescription"></div>

    <div class="col-12 col-md-8 mb-2 mt-3">
        <div class=" card border-0 shadow-sm">
            <div class="card-body">
                <div class="row">
                    <div class="col-4 offset-4">
                        <p class="text-center text-secondary border-bottom pb-2">POS Provider</p>
                        <a href="https://pos.payshia.com/login?guestMode=1" target="_blank"><img src="./lib/ceylon-pharmacy/assets/images/payshia-mini-logo.png" class="w-100 clickable"></a>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-8 mb-2">
                        <label>Payment Amount</label>
                        <input <?= ($userAnswer != 0 && $UserLevel == "Student") ? 'readonly' : '' ?> type="number" onclick="this.select()" value="<?= $AnswerPaymentValue ?>" name="payment-value" id="payment-value" class="form-control p-3" placeholder="Enter Payment Amount">
                    </div>

                    <div class="col-md-4  mb-2">
                        <label>Action</label>
                        <button type="button" onclick="FinishPatient('<?= $prescriptionID ?>')" class="btn p-3  btn-dark w-100"><i class="fa-solid fa-floppy-disk player-icon"></i> Finish</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="envelope-button-set d-md-none">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="btn-group w-100" role="group" aria-label="Basic example">
                        <button type="button" onclick="ViewPrescription('<?= $prescriptionID ?>')" class="btn btn-dark w-100" style="border-radius: 15px 0 0 15px"><i class="fa-solid fa-file-prescription player-icon"></i> Prescription</button>
                        <button type="button" onclick="FinishPatient('<?= $prescriptionID ?>')" class="btn btn-success  w-100" style="border-radius: 0 15px 15px 0"><i class="fa-solid fa-floppy-disk player-icon"></i> Finish</button>
                    </div>
                </div>
            </div>
        </div>


    </div>

</div>