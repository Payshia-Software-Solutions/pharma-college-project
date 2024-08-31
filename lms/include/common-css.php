<link href="./vendor/twbs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="./node_modules/dropify/dist/css/dropify.min.css" rel="stylesheet">

<link href="./assets/css/styles-1.0.0.css" rel="stylesheet">
<link href="./assets/css/select2.css" rel="stylesheet">

<!-- Add Icons -->
<link href='./vendor/font-awesome/css/all.min.css' rel='stylesheet'>
<link href="./node_modules/bootstrap-icons/font/bootstrap-icons.min.css" rel="stylesheet">

<script src="./node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
<link rel="stylesheet" href="./node_modules/sweetalert2/dist/sweetalert2.min.css">


<link rel="apple-touch-icon" sizes="180x180" href="./assets/images/favicon/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="./assets/images/favicon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="./assets/images/favicon/favicon-16x16.png">
<!-- <link rel="manifest" href="./assets/images/favicon/site.webmanifest"> -->

<script src="./node_modules/tinymce/tinymce.min.js" referrerpolicy="origin"></script>
<link href='./vendor/select2/dist/css/select2.min.css' rel='stylesheet'>
<!-- Bootstrap Form Wizard CSS -->

<!-- include summernote css/js -->
<link href="./vendor/summernote/summernote-lite.min.css" rel="stylesheet">

<link rel="manifest" href="./manifest.webmanifest">

<style>
    #button-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        /* Semi-transparent black */
        z-index: 999;
        /* Below the button */
    }

    #install-button {
        display: none;
        /* Initially hidden */
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        z-index: 1000;
        /* Ensure it overlays all other content */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        /* Optional: Add a shadow for better visibility */
    }
</style>