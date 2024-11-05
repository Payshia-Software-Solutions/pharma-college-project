<?php

$status = 'In Delivery';

?>




<div class="row justify-content-center mb-4">
    <div class="col-md-8">
        <?php if ($status == 'In Delivery') : ?>
        <div class="text-center">
            <img src="./lib/certificate-center/assets/images/delivery-scooter.gif" alt="delivery animation"
                width="100px">
        </div>

        <div class="text-center mt-3">
            <h3>In Delivery</h3>
            <h6>We are preparing your certificate</h6>
        </div>

        <?php else : ?>
        <div class="text-center">
            <img src="./lib/certificate-center/assets/images/printer.gif" alt="printing animation" width="100px">
        </div>

        <div class="text-center mt-3">
            <h3>In Printing</h3>
            <h6>We are printing your certificate</h6>
        </div>

        <?php endif ?>

        <div class="row mt-5">
            <div class="col-6 fw-bold mb-2">
                <h5>Certificate Name:</h5>
            </div>
            <div class="col-6 mb-2">
                <h6>Advanced Certificate</h6>
            </div>

            <div class="col-6 fw-bold mb-2">
                <h5>Payment:</h5>
            </div>
            <div class="col-6 mb-2">
                <h6>LKR 5000.00</h6>
            </div>

            <div class="col-6 fw-bold mb-2">
                <h5>Order Date:</h5>
            </div>
            <div class="col-6 mb-2">
                <h6>2024-11-01</h6>
            </div>
        </div>
    </div>
</div>