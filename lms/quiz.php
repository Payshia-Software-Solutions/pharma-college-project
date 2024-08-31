<!DOCTYPE html>
<html lang="en">

<?php
// Database Connection & Other Configuration
require_once './include/configuration.php';
$PageName = "Quiz";
$pageId = 27;

include './include/site-data.php';

?>

<head>
    <!-- Meta Description -->
    <?php include './include/meta-description.php' ?>
    <!-- End of  Meta Description -->

    <title><?= $PageName ?> | <?= $SiteTitle ?></title>

    <!-- Common CSS -->
    <?php include './include/common-css.php' ?>
    <!-- End of Common CSS -->

    <link rel="stylesheet" href="./lib/quiz/assets/css/quiz-styles-1.0.css">
</head>

<body>
    <!-- Pre Loader Content -->
    <?php include './include/pre-loader.php' ?>
    <!-- End of  Pre Loader Content -->
    <div class="container">

        <!-- Footer -->
        <?php include './include/nav-menu.php' ?>
        <!-- End of Footer -->
        <!-- 
        bin2hex(random_bytes(32)); // Generates a 256-bit (32-byte) random key -->

        <!-- Page Content -->
        <div id="root"></div>
        <!-- End of Page Content -->


        <!-- Footer -->
        <?php include './include/footer-menu.php' ?>
        <!-- End of Footer -->

        <!-- Footer -->
        <?php include './include/footer.php' ?>
        <!-- End of Footer -->

        <!-- Credits -->
        <?php // include './include/credits.php' 
        ?>
        <!-- End of Credits -->
    </div>

    <!-- Common scripts -->
    <?php include './include/common-scripts.php' ?>
    <!-- End of Common scripts -->

    <!-- Custom Scripts -->
    <script src="./lib/quiz/assets/js/quiz-1.0.0.js"></script>
    <!-- End of Custom Scripts -->
</body>

</html>