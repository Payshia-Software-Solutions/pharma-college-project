<?php
if ($studentBalance != 0) {
?>
    <div class="row">
        <div class="col-12">
            <div class="alert alert-warning border-2 shadow-sm" id="paymentAlert">
                You have to Pay <b>LKR <?= number_format($studentBalance, 2) ?></b>
            </div>
        </div>
    </div>
<?php
}
