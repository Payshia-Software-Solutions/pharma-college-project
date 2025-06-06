<!DOCTYPE html>
<html lang="en">

<?php
// Database Connection & Other Configuration
require_once './include/configuration.php';
$PageName = "Convocation";
$pageId = 25;

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


    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --accent-color: #e74c3c;
            --success-color: #27ae60;
            --light-bg: #f8f9fa;
            --dark-bg: #34495e;
            --text-primary: #2c3e50;
            --text-secondary: #7f8c8d;
            --gradient-bg: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            --hover-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .main-container {
            margin: 0 auto;
            padding: 0 15px;
        }

        .header-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 40px;
            text-align: center;
            margin-bottom: 30px;
            box-shadow: var(--card-shadow);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .logo-container {
            position: relative;
            display: inline-block;
            margin-bottom: 20px;
        }

        .logo-container::before {
            content: '';
            position: absolute;
            top: -10px;
            left: -10px;
            right: -10px;
            bottom: -10px;
            background: linear-gradient(45deg, var(--secondary-color), var(--accent-color));
            border-radius: 50%;
            z-index: -1;
            animation: rotate 10s linear infinite;
        }

        @keyframes rotate {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .game-logo {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            border: 4px solid white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .game-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-color);
            margin: 20px 0 10px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        }

        .subtitle {
            font-size: 1.1rem;
            color: var(--text-secondary);
            font-weight: 500;
            letter-spacing: 1px;
        }

        .action-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-top: 30px;
        }

        .action-card {
            background: white;
            border-radius: 20px;
            padding: 40px 30px;
            text-align: center;
            box-shadow: var(--card-shadow);
            transition: all 0.3s ease;
            border: 1px solid rgba(0, 0, 0, 0.05);
            position: relative;
            overflow: hidden;
        }

        .action-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s;
        }

        .action-card:hover::before {
            left: 100%;
        }

        .action-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--hover-shadow);
        }

        .card-icon {
            font-size: 3rem;
            margin-bottom: 20px;
            background: linear-gradient(45deg, var(--secondary-color), var(--accent-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .apply-card .card-icon {
            background: linear-gradient(45deg, var(--success-color), #2ecc71);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 5px;
        }

        .card-description {
            color: var(--text-secondary);
            margin-bottom: 25px;
            line-height: 1.6;
        }

        .balance-amount {
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--success-color);
            margin: 0;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
        }

        .balance-label {
            font-size: 0.9rem;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 5px;
        }

        .action-btn {
            padding: 15px 30px;
            font-size: 1.1rem;
            font-weight: 600;
            border: none;
            border-radius: 50px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            position: relative;
            overflow: hidden;
            min-width: 160px;
        }

        .btn-apply {
            background: linear-gradient(45deg, var(--success-color), #2ecc71);
            color: white;
            box-shadow: 0 5px 15px rgba(39, 174, 96, 0.3);
        }

        .btn-apply:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(39, 174, 96, 0.4);
            color: white;
        }

        .btn-pay {
            background: linear-gradient(45deg, var(--secondary-color), #5dade2);
            color: white;
            box-shadow: 0 5px 15px rgba(52, 152, 219, 0.3);
        }

        .btn-pay:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(52, 152, 219, 0.4);
            color: white;
        }

        .status-badge {
            display: inline-block;
            padding: 8px 16px;
            background: linear-gradient(45deg, #2ecc71, #27ae60);
            color: white;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-top: 10px;
            box-shadow: 0 3px 10px rgba(46, 204, 113, 0.3);
        }

        .floating-elements {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: -1;
        }

        .floating-shape {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 20s infinite linear;
        }

        .floating-shape:nth-child(1) {
            width: 60px;
            height: 60px;
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }

        .floating-shape:nth-child(2) {
            width: 40px;
            height: 40px;
            top: 60%;
            right: 15%;
            animation-delay: -5s;
        }

        .floating-shape:nth-child(3) {
            width: 80px;
            height: 80px;
            bottom: 20%;
            left: 20%;
            animation-delay: -10s;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            33% {
                transform: translateY(-20px) rotate(120deg);
            }

            66% {
                transform: translateY(20px) rotate(240deg);
            }
        }

        @media (max-width: 768px) {
            .header-card {
                padding: 30px 20px;
            }

            .game-title {
                font-size: 2rem;
            }

            .action-card {
                padding: 30px 20px;
            }

            .balance-amount {
                font-size: 1.8rem;
            }
        }
    </style>
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
        <?php include './include/credits.php' ?>
        <!-- End of Credits -->
    </div>

    <!-- Common scripts -->
    <?php include './include/common-scripts.php' ?>
    <!-- End of Common scripts -->

    <!-- Custom Scripts -->
    <script src="./lib/convocation/assets/js/convocation-1.0.0.js"></script>
    <!-- End of Custom Scripts -->
</body>

</html>