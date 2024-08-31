<!DOCTYPE html>
<html lang="en">

<?php
// Initialize the session
session_start();

// Database Connection & Other Configuration
require_once './include/configuration.php';
$PageName = "Registration";
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
        <div id="root"></div>
        <!-- End of Page Content -->

        <!-- Footer -->
        <?php include './include/footer.php' ?>
        <!-- End of Footer -->

        <!-- Credits -->
        <?php include './include/credits.php' ?>
        <!-- End of Credits -->
    </div>

    <!-- Common scripts -->
    <?php include './include/common-scripts.php' ?>
    <!-- End of Common scripts -->

    <!-- Custom Scripts -->
    <script src="./lib/register/assets/js/register-1.0.0.js"></script>
    <!-- End of Custom Scripts -->
</body>

</html>