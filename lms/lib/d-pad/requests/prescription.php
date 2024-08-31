<?php
require_once '../../../include/configuration.php';
include '../../../php_handler/function_handler.php';
include '../php_methods/d-pad-methods.php';

$prescriptionID = $_POST['prescriptionID'];
$prescriptionArray = GetPrescriptions()[$prescriptionID];
?>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Indie+Flower&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

    /* .handwrite {
        font-family: 'Indie Flower', cursive;
        font-size: 20 px;
    } */

    .prescription-card {
        background-color: #FFFEFE;
        border: 15px solid #009E60;
        border-radius: 15px !important;
    }

    .prescription-card .mini-text {
        font-size: 10px;
    }

    .pres-method {
        font-size: 20px;
    }

    .rx {
        font-size: 25px;
    }

    .medicine-item {
        font-size: 15px;
    }

    .description-text {
        font-size: 15px;
    }

    .description-card p {
        margin-bottom: 0px !important;
    }

    @media (max-width: 600px) {
        .medicine-item {
            font-size: 10px;
        }

        .description-text {
            font-size: 10px;
        }

        .rx {
            font-size: 18px;
        }

        .pres-method {
            font-size: 14px;
        }
    }
</style>

<div class="card rounded-4 shadow-sm flex-fill mt-3 prescription-card text-start">
    <div class="card-body">
        <div class=" row">
            <div class="col-12 text-center">
                <img src="./assets/images/logo.png" alt="Logo" height="50" class="d-inline-block align-text-top">
                <h3 class="card-title">Ceylon Medi Care</h3>
                <p class="my-0 text-secondary mini-text ">A/75/A, Midigahamulla, Pelmadulla , 70070</p>
                <p class="my-0 text-secondary mini-text ">info@pharmacollege.lk | 0704477555 | www.pharmacollege.lk</p>
                <div class="border-top border-3 mt-2"></div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <p class="pt-2 mb-0 border-bottom">Name : <span class="  "><?= $prescriptionArray['Pres_Name'] ?></span></p>
                <p class="mb-0 border-bottom">Age : <span class=" "><?= $prescriptionArray['Pres_Age'] ?></span></p>
                <p class="border-bottom">Date : <span class=""><?= $prescriptionArray['pres_date'] ?></span></p>
            </div>
            <div class="col-12">
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-6">
                <h1 class="rx mb-0">Rx</h1>
                <?php
                $drugListString = $prescriptionArray["drugs_list"];
                $drugListArray = explode(', ', $drugListString);
                if (!empty($drugListArray)) {
                    foreach ($drugListArray as $selectedItem) {
                ?>
                        <p class="mb-0 medicine-item"><?= $selectedItem ?></p>
                <?php
                    }
                }
                ?>
            </div>
            <div class="col-1">
                <h1 class="text-center" style="font-size: 80px; font-weight:100">/</h1>
            </div>
            <div class="col-4" style=" display: flex;align-items: center;justify-content: center;">
                <h2 class="mt-2 text-center pres-method"><?= $prescriptionArray['Pres_Method'] ?></h2>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-body description-card" style="min-height:100px">
                        <p class="mb-0 description-text"><?= ($prescriptionArray['notes']); ?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="border-top border-3 mt-4"></div>
        <div class="row mt-3">
            <div class="col-6">
                <p class="pt-2 my-0"><span class=""><?= $prescriptionArray['doctor_name'] ?></span></p>
                <p class="mb-0">MBBS</p>
            </div>
            <div class="col-6">
                <p class="pt-2 my-0"><span class="border-bottom"><?= $prescriptionArray['doctor_name'] ?></span></p>
                <p class="mb-0">Signature</p>
            </div>
        </div>
    </div>
</div>