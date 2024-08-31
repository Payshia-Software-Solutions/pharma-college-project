<?php
require_once '../../include/configuration.php';
include '../../php_handler/function_handler.php';

$loggedUser = $_POST['LoggedUser'];
$UserLevel = $_POST['UserLevel'];
$userAnswer = 0;

$prescriptionID = $_POST['prescriptionID'];
if ($prescriptionID != 0) {
    $patient =  GetPatients($link)[$prescriptionID];
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
        bottom: 80px;
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
        <button class="btn btn-warning btn-sm rounded-3" onclick="OpenIndex()"><i class="fa-solid fa-home player-icon"></i> Home</button>
    </div>
    <div class="col-12">
        <h4 class="section-topic mb-0">New Patient</h4>
        <p class="my-0 border-bottom pb-2 mini-text">Patient Details</p>
    </div>

    <div class="col-12 col-md-4 mb-2 d-none d-md-block" id="prescription"></div>
</div>