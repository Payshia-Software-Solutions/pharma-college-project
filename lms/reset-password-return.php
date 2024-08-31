<!DOCTYPE html>
<html lang="en">

<?php
// Initialize the session
session_start();

// Database Connection & Other Configuration
require_once './include/configuration.php';
$PageName = "Set Password";

$token = $_GET['token'];
$phoneNumber = $_GET['phoneNumber'];
$studentNumber = $_GET['studentNumber'];
?>

<head>
    <!-- Meta Description -->
    <?php include './include/meta-description.php' ?>
    <!-- End of  Meta Description -->

    <title><?= $PageName ?> | <?= $SiteTitle ?></title>

    <!-- Common CSS -->
    <?php include './include/common-css.php' ?>
    <!-- End of Common CSS -->
</head>

<body>
    <div class="container">
        <!-- Page Content -->
        <div id="root">
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
                    <div class="card border-0 shadow-lg rounded-4 p-4">
                        <div class="card-body">
                            <div class="row mb-2 mt-4">
                                <div class="col-12 text-center">
                                    <img src="https://lms.pharmacollege.lk/images/logo-new.png" class="w-25 pb-2 border-bottom mb-2 border-2" alt="logo" class="logo">
                                    <h3 class="text-center ">Set New Password</h3>
                                </div>
                            </div>
                            <div class="alert alert-warning">
                                <p class="mb-0">Student Number : <b><?= $studentNumber ?></b></p>
                                <p class="mb-0">Phone Number : <b><?= $phoneNumber ?></b></p>
                            </div>
                            <form id="reset-form" action="" method="post">
                                <input type="hidden" name="studentNumber" id="studentNumber" value="<?= $studentNumber ?>">
                                <input type="hidden" name="phoneNumber" id="phoneNumber" value="<?= $phoneNumber ?>">

                                <div class="row mb-3">
                                    <div class="col-12">
                                        <p class="mb-0 text-label">New Password</p>
                                        <input type="password" class="form-control" required name="password" id="password" placeholder="Enter Password">
                                        <span id="password-error" class="text-danger"></span>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-12">
                                        <p class="mb-0 text-label">Confirm Password</p>
                                        <input type="password" class="form-control" required name="cPassword" id="cPassword" placeholder="Re-enter Password">
                                        <span id="cPassword-error" class="text-danger"></span>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-12 text-end text-secondary">
                                        Already Have an account? <a href="./login" class="forgot-password-link">Login</a>
                                    </div>
                                </div>

                                <div class="row mb-2 mt-4">
                                    <div class="col-12 text-center">
                                        <button type="button" onclick="ResetPassword()" class="btn btn-dark">Set New Password</button>
                                    </div>
                                </div>
                            </form>

                        </div>


                        <!-- Credits -->
                        <?php include './include/credits.php' ?>
                        <!-- End of Credits -->
                    </div>
                </div>
            </div>
        </div>
        <!-- End of Page Content -->

        <!-- Footer -->
        <?php include './include/footer.php' ?>
        <!-- End of Footer -->

    </div>

    <!-- Common scripts -->
    <?php include './include/common-scripts.php' ?>
    <!-- End of Common scripts -->

    <!-- Custom Scripts -->
    <script src="./lib/reset-password/assets/js/set-password-1.0.0.js"></script>
    <!-- End of Custom Scripts -->
</body>

</html>