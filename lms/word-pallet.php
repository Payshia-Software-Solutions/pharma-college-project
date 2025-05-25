<!DOCTYPE html>
<html lang="en">

<?php
// Database Connection & Other Configuration
require_once './include/configuration.php';
$PageName = "Word Pallet";
$pageId = 25;

include './include/site-data.php';
?>

<head>
    <!-- Meta Description -->
    <?php include './include/meta-description.php' ?>
    <!-- End of  Meta Description -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ti-icons@0.1.2/css/themify-icons.min.css">
    <title><?= $PageName ?> | <?= $SiteTitle ?></title>
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --success-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --warning-gradient: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
            --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            --hover-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .game-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: var(--card-shadow);
            border: 1px solid rgba(255, 255, 255, 0.2);
            overflow: hidden;
            margin-bottom: 50px;
        }

        .header-section {
            background: var(--primary-gradient);
            color: white;
            padding: 2rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .header-section::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            animation: rotate 20s linear infinite;
        }

        @keyframes rotate {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .game-logo {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            animation: bounce 2s ease-in-out infinite;
        }

        @keyframes bounce {

            0%,
            20%,
            50%,
            80%,
            100% {
                transform: translateY(0);
            }

            40% {
                transform: translateY(-10px);
            }

            60% {
                transform: translateY(-5px);
            }
        }

        .game-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin: 0;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            position: relative;
            z-index: 1;
        }

        .content-section {
            padding: 2rem;
        }

        .image-container {
            position: relative;
            overflow: hidden;
            border-radius: 20px;
            box-shadow: var(--card-shadow);
            transition: transform 0.3s ease;
        }

        .image-container:hover {
            transform: scale(1.02);
        }

        .word-image {
            width: 100%;
            height: 65vh;
            object-fit: cover;
            transition: transform 0.3s ease;
        }


        .image-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(transparent, rgba(0, 0, 0, 0.7));
            color: white;
            padding: 1.5rem;
            transform: translateY(100%);
            transition: transform 0.3s ease;
        }

        .image-container:hover .image-overlay {
            transform: translateY(0);
        }

        .question-section {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: var(--card-shadow);
            margin-bottom: 2rem;
        }

        .section-title {
            color: #333;
            font-weight: 600;
            margin-bottom: 1.5rem;
            text-align: center;
            font-size: 1.2rem;
        }

        .tip-card {
            background: var(--warning-gradient);
            border: none;
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: var(--card-shadow);
            color: white;
            position: relative;
            overflow: hidden;
        }

        .tip-card::before {
            content: '💡';
            font-size: 2rem;
            position: absolute;
            top: 15px;
            right: 15px;
            opacity: 0.3;
        }

        .tip-title {
            font-weight: 700;
            margin-bottom: 0.5rem;
            font-size: 1.25rem;
        }

        .answer-card {
            background: white;
            border: 2px solid #e9ecef;
            border-radius: 15px;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            margin-bottom: 1rem;
        }

        .answer-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: var(--success-gradient);
            transition: left 0.3s ease;
            z-index: 0;
        }

        .answer-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: var(--hover-shadow);
            border-color: #667eea;
        }

        .answer-card:hover::before {
            left: 0;
        }

        .answer-card:hover .card-body {
            color: white;
        }

        .answer-card.selected {
            background: var(--success-gradient) !important;
            border-color: #4facfe !important;
            transform: translateY(-5px) scale(1.02);
            box-shadow: var(--hover-shadow);
        }

        .answer-card.selected .card-body {
            color: white !important;
        }

        .answer-card.selected::before {
            left: 0;
        }

        .answer-card .card-body {
            position: relative;
            z-index: 1;
            padding: 1.5rem;
            transition: color 0.3s ease;
        }

        .answer-text {
            font-size: 1.1rem;
            font-weight: 500;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .answer-icon {
            opacity: 0;
            transform: translateX(20px);
            transition: all 0.3s ease;
        }

        .answer-card:hover .answer-icon,
        .answer-card.selected .answer-icon {
            opacity: 1;
            transform: translateX(0);
        }

        .next-button {
            background: var(--primary-gradient);
            border: none;
            border-radius: 15px;
            padding: 1rem 2rem;
            font-size: 1.2rem;
            font-weight: 600;
            color: white;
            box-shadow: var(--card-shadow);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .next-button::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .next-button:hover::before {
            width: 300px;
            height: 300px;
        }

        .next-button:hover {
            transform: translateY(-3px);
            box-shadow: var(--hover-shadow);
        }

        .next-button:disabled {
            opacity: 0.7;
            cursor: not-allowed;
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

        .floating-element {
            position: absolute;
            font-size: 2rem;
            opacity: 0.1;
            animation: float 6s ease-in-out infinite;
        }

        .floating-element:nth-child(1) {
            top: 10%;
            left: 10%;
            animation-delay: 0s;
        }

        .floating-element:nth-child(2) {
            top: 20%;
            right: 10%;
            animation-delay: 1s;
        }

        .floating-element:nth-child(3) {
            bottom: 20%;
            left: 20%;
            animation-delay: 2s;
        }

        .floating-element:nth-child(4) {
            bottom: 10%;
            right: 20%;
            animation-delay: 3s;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(180deg);
            }
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-5px);
            }

            75% {
                transform: translateX(5px);
            }
        }

        .shake {
            animation: shake 0.5s ease-in-out;
        }

        @media (max-width: 768px) {
            .game-title {
                font-size: 2rem;
            }

            .content-section {
                padding: 1rem;
            }

            .word-image {
                height: 250px;
            }

            .question-section {
                padding: 1.5rem;
            }
        }

        /* Loading spinner */
        .spinner {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>

    <!-- Common CSS -->
    <?php include './include/common-css.php' ?>
    <!-- End of Common CSS -->
</head>

<body>
    <!-- Pre Loader Content -->
    <?php include './include/pre-loader.php' ?>
    <!-- End of  Pre Loader Content -->
    <div class="">

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
    <script src="./lib/word-pallet/assets/word-pallet-1.0.0.js"></script>
    <!-- End of Custom Scripts -->
</body>

</html>