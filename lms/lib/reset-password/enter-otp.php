<?php
$studentNumber = $_POST['studentNumber'];
$phoneNumber = $_POST['phoneNumber'];
?>

<style>
    body {
        height: 100vh;
        margin: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    h3 {
        font-weight: 600;
    }

    input {
        padding: 12px !important;
        box-shadow: none !important;
    }

    .text-label {
        font-weight: 500;
    }
</style>

<div class="row">
    <div class="col-12 col-md-6 offset-md-3">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <div class="card-body">
                <div class="row mb-2 mt-4">
                    <div class="col-12 text-center">
                        <img src="https://lms.pharmacollege.lk/images/logo-new.png" class="w-25 pb-2 border-bottom mb-2 border-2" alt="logo" class="logo">
                        <h3 class="text-center ">Enter OTP</h3>
                    </div>
                </div>
                <form action="" method="post">
                    <div class="row mb-3">
                        <div class="col-12">
                            <input type="text" pattern="\d{6}" inputmode="numeric" class="form-control text-center" required name="otpNumber" id="otpNumber" placeholder="Enter OTP">
                        </div>
                    </div>

                    <input type="hidden" name="studentNumber" id="studentNumber" value="<?= $studentNumber ?>">
                    <input type="hidden" name="phoneNumber" id="phoneNumber" value="<?= $phoneNumber ?>">

                    <div class="row mb-2 mt-4">
                        <div class="col-12 text-center">
                            <button type="button" onclick="validateOTP()" class="btn btn-dark">Go to Change Password</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>