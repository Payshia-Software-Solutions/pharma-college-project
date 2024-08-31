<?php
require_once '../../include/configuration.php';
include '../../php_handler/function_handler.php';

$studentArray = GetLmsStudent();
$studentNumber = $_POST['studentNumber'];

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
                        <h3 class="text-center ">Reset Password</h3>
                    </div>
                </div>

                <form action="" method="post">
                    <input type="hidden" name="studentNumber" id="studentNumber" value="<?= $studentNumber ?>">
                    <?php

                    if (isset($studentArray[$studentNumber])) {
                        $studentDetails = $studentArray[$studentNumber];

                    ?>
                        <div class="row mb-3">
                            <div class="col-12">
                                <?php
                                $phone = $studentDetails['phone'];
                                // Check if the phone number is set and has at least 6 characters
                                if ($phone && strlen($phone) >= 6) {
                                    // Extract the last 4 digits of the phone number
                                    $lastFourDigits = substr($phone, -4);

                                    // Calculate the number of asterisks needed
                                    $numAsterisks = strlen($phone) - 4;

                                    // Create a string of asterisks
                                    $asterisks = str_repeat('*', $numAsterisks);

                                    // Concatenate the asterisks with the last 4 digits
                                    $hiddenPhone = $asterisks . $lastFourDigits;
                                }
                                ?>
                                <p class="mb-0 text-label">Enter your Phone number ending <?= $hiddenPhone ?></p>
                                <input type="tel" maxlength="10" class="form-control text-center" required name="phoneNumber" id="phoneNumber" placeholder="Enter Phone Number">


                            </div>
                        </div>
                    <?php
                    } else {
                    ?>
                        <div class="row">
                            <div class="col-12">
                                <div class="alert alert-warning">Invalid Student Number! Please Enter Correct Student Number</div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>


                    <div class="row mb-2 mt-4">
                        <div class="col-12 text-center">
                            <button type="button" onclick="sentResetLink()" class="btn btn-dark">Send Reset Link</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>