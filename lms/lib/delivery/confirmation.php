<?php
require_once '../../include/configuration.php';
include '../../php_handler/function_handler.php';
$UserLevel = $_POST['UserLevel'];
$loggedUser = $_POST['LoggedUser'];
$selectedId = $_POST['selectedId'];
$CourseCode = $_POST['defaultCourseCode'];
$deliverySettings = GetDeliverySetting($link, $CourseCode);
$selectedCourse = GetCourses($link)[$CourseCode];
if ($selectedId != 0) {
    $deliverySettings = GetDeliverySetting($link, $CourseCode)[$selectedId];
    $icon = $deliverySettings['icon'];
    $titleName = $deliverySettings['delivery_title'];
    $selectedCourse = GetCourses($link)[$deliverySettings['course_id']];
    $value = $deliverySettings['value'];
} else {
    $icon = $titleName = "";
    $value = 0;
}

$paymentMethods = array(
    array("id" => 0, "value" => 'PrePaid'),
    array("id" => 1, "value" => 'COD'),
    array("id" => 2, "value" => 'Bank Tansfer')
)


?>
<div class="row">
    <div class="col-md-12">
        <h3 class="mb-3 pb-2 border-bottom">Confirmation</h3>
        <p>Do you need to perform this Order?</p>

        <div class="row">
            <div class="col-md-4">
                <div class="text-center">
                    <img src="./lib/delivery/assets/images/<?= $icon ?>" class="icon" style="width: 100px;">
                    <h4 class="mb-2"><?= $titleName ?></h4>
                    <hr>
                    <h4 class="text-light bg-success text-center p-2 rounded-3 mb-0">LKR <?= number_format($value, 2) ?></h4>
                </div>
            </div>
            <div class="col-md-8 mt-4 mt-md-0">
                <form id="submit-form" method="post">
                    <input type="hidden" name="value" id="value" value="<?= $value ?>" required>
                    <input type="hidden" name="selectedCourseCode" id="selectedCourseCode" value="<?= $CourseCode ?>" required>
                    <input type="hidden" name="payment_method" id="payment_method" value="<?= $paymentMethods[0]['id'] ?>" required>
                    <input type="hidden" name="delivery_id" id="delivery_id" value="<?= $selectedId ?>" required>

                    <h5 class="border-bottom pb-1 mb-2">Fill the Delivery Address</h5>
                    <div class="row">
                        <div class="col-12 col-md-12 mb-3">
                            <label for="fullName" class="text-secondary">Full Name</label>
                            <input type="text" class="form-control" name="fullName" id="fullName" placeholder="Eg: Gamage Thilina Ruwan Kumara Doloswala" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-12 mb-3">
                            <label for="fullName" class="text-secondary">Street Address</label>
                            <input type="text" class="form-control" name="streetAddress" id="streetAddress" placeholder="Eg: 533A3, Hospital Road" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-md-6 mb-3">
                            <label for="fullName" class="text-secondary">City</label>
                            <input type="text" class="form-control" name="city" id="city" placeholder="Eg: Pelmadulla" required>
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <label for="fullName" class="text-secondary">District</label>
                            <input type="text" class="form-control" name="district" id="district" placeholder="Eg: Rathnapura District" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-md-6 mb-3">
                            <label for="fullName" class="text-secondary">Phone Number 1</label>
                            <input type="text" class="form-control" name="phoneNumber1" id="phoneNumber1" placeholder="Eg: 533A3" required>
                        </div>
                        <div class="col-12 col-md-6  mb-3">
                            <label for="fullName" class="text-secondary">Phone Number 2 (Optional)</label>
                            <input type="text" class="form-control" name="phoneNumber2" id="phoneNumber2" placeholder="Eg: Hospital Road">
                        </div>
                    </div>

                </form>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-12 rounded-3 bg-light p-3 text-end">
                <!-- <div class="border-bottom mb-2"></div> -->
                <button type="button" class="btn btn-light" onclick="ClosePopUP()"><i class="fa-solid fa-xmark"></i> Close</button>
                <button type="button" class="btn btn-dark" onclick="PlaceOrder()"><i class="fa-solid fa-cart-shopping"></i> Place Order</button>
            </div>
        </div>

    </div>
</div>