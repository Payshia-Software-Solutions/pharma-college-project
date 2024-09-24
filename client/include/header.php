<?php
$sql = "SELECT `id`, `key`, `value`, `link`, `cover_img`, `updated_by` FROM `web_content`";
$result = $link->query($sql);
$web_content = array(); // initialize an empty array
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $key = $row["key"];
        $web_content[$key] = $row; // add key-value pair to array
    }
}


$baseUrl = 'https://admin.pharmacollege.lk/';
$baseUrl = 'http://localhost/payshia-erp/';
$Courses = GetParentCourses($link);
?>

<!-- META ============================================= -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="keywords" content="" />
<meta name="author" content="I" />
<meta name="robots" content="" />

<!-- DESCRIPTION -->
<meta name="description" content="<?= $web_content['site_title'] ?> : <?= $web_content['sub_title'] ?>" />

<!-- OG -->
<meta property="og:title" content="<?= $web_content['site_title'] ?> : <?= $web_content['sub_title'] ?>" />
<meta property="og:description" content="<?= $web_content['site_title'] ?> : <?= $web_content['sub_title'] ?>" />
<meta name="format-detection" content="telephone=no">

<!-- FAVICONS ICON ============================================= -->
<link rel="icon" href="assets/images/favicon/favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon/apple-touch-icon.png" />


<!-- PAGE TITLE HERE ============================================= -->
<title><?= $PageName ?> | <?= $web_content['site_title']['value'] ?> - <?= $web_content['sub_title']['value'] ?></title>

<!-- MOBILE SPECIFIC ============================================= -->
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- All PLUGINS CSS ============================================= -->
<link rel="stylesheet" type="text/css" href="assets/css/assets.css">

<!-- TYPOGRAPHY ============================================= -->
<link rel="stylesheet" type="text/css" href="assets/css/typography.css">

<!-- SHORTCODES ============================================= -->
<link rel="stylesheet" type="text/css" href="assets/css/shortcodes/shortcodes.css">

<!-- STYLESHEETS ============================================= -->
<link rel="stylesheet" type="text/css" href="assets/css/style-1.0.css">
<link class="skin" rel="stylesheet" type="text/css" href="assets/css/color/color-1.css">
<link rel="stylesheet" type="text/css" href="assets/css/scroll-bar.css">

<!-- REVOLUTION SLIDER CSS ============================================= -->

<link rel="stylesheet" type="text/css" href="assets/vendors/revolution/css/layers.css">
<link rel="stylesheet" type="text/css" href="assets/vendors/revolution/css/settings.css">
<link rel="stylesheet" type="text/css" href="assets/vendors/revolution/css/navigation.css">
<link rel="stylesheet" type="text/css" href="./node_modules/sweetalert2/dist/sweetalert2.min.css">
<!-- REVOLUTION SLIDER END -->