<?php
require_once '../../include/configuration.php';
include '../../php_handler/function_handler.php';
include '../../php_handler/course_functions.php';

$UserLevel = $_POST['UserLevel'];
$loggedUser = $_POST['LoggedUser'];
$CourseCode = $_POST['defaultCourseCode'];

$userOrders = GetDeliveryOrdersByUserAndBatch($link, $loggedUser, $CourseCode);
$deliverySettings = GetDeliverySetting($link, $CourseCode);

$paymentMethods = array(
    array("id" => 0, "value" => 'PrePaid'),
    array("id" => 1, "value" => 'COD'),
    array("id" => 2, "value" => 'Bank Tansfer')
);

$orderStatus = array(
    array("id" => 0, "value" => 'Cancelled'),
    array("id" => 1, "value" => 'Processing'),
    array("id" => 2, "value" => 'Packed'),
    array("id" => 3, "value" => 'Delivered'),
    array("id" => 4, "value" => 'Transits'),
    array("id" => 5, "value" => 'Finished')
);

$studentBalanceArray = GetStudentBalance($loggedUser);
$studentBalance = $studentBalanceArray['studentBalance'];

if (isset($studentBalanceArray['TotalStudentPaymentRecords'])) {
    $studentPayments = (float)$studentBalanceArray['TotalStudentPaymentRecords'];
} else {
    // Handle the case where the key is not set or has a non-numeric value
    $studentPayments = 0.0; // or some default value
}


?>

<div class="site-title">
    <?php $UserDetails =  GetUserDetails($link, $loggedUser); ?>
    <div class="row">
        <div class="col-8">
            <h2 class="greet-text">Hi <?= $UserDetails['first_name'] ?> <?= $UserDetails['last_name'] ?></h2>
            <p class="text-secondary">Let's Make this day Productive</p>
        </div>
        <div class="col-4 text-center">
            <div class="profile-image" style="background-image : url('./assets/images/user.png')"></div>
        </div>
    </div>
</div>

<div id="index-content" class="mt-3">
    <div class="row">
        <div class="col-12 text-end mb-2">
            <button type="button" class="btn btn-warning" onclick="OpenIndex()"><i class="fa-solid fa-rotate-right"></i> Reload</button>
        </div>
    </div>

    <?php
    if ($studentPayments == 0) {
    ?>
        <div class="alert alert-danger">
            Please do the Payments!
        </div>
    <?php
        exit;
    }
    if (!empty($userOrders)) { ?>
        <div class="row my-3">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title card-topic-title">Your Orders</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Tracking Number</th>
                                        <th>Order</th>
                                        <th>Status</th>
                                        <th>Order Date</th>
                                        <th>Esti. Delivery</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($userOrders as $selectedArray) {
                                        $orderStatusDisplay = $orderStatus[$selectedArray['current_status']]['value'];
                                        $orderDate = $selectedArray['order_date'];

                                        $dateTime = new DateTime($orderDate);
                                        $formattedOrderDate = $dateTime->format('Y-m-d H:i');
                                        $current_status = $selectedArray['current_status'];

                                        $active_status = "Initial";
                                        $color = "warning";
                                        if ($current_status == 1) {
                                            $active_status = "Processing";
                                            $color = "danger";
                                        } else if ($current_status == 2) {
                                            $active_status = "Packed";
                                            $color = "success";
                                        } else if ($current_status == 3) {
                                            $active_status = "Goods in Transit";
                                            $color = "dark";
                                        }
                                    ?>
                                        <tr>
                                            <td><?= $selectedArray['tracking_number'] ?></td>
                                            <td><?= $deliverySettings[$selectedArray['delivery_id']]['delivery_title'] ?></td>
                                            <td class="text-center">
                                                <span class="badge bg-<?= $color ?>"><?= $active_status ?></span>
                                            </td>
                                            <td><?= $formattedOrderDate ?></td>
                                            <td>Withing 3-5 Working Days</td>
                                            <td class="text-center"><button class="btn btn-primary btn-sm"><i class="fa-solid fa-map-location-dot"></i> Tracking</button></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    <div class="row mt-4">
        <div class="col-12">
            <h5 class="mb-3">You can Order Following!</h5>
        </div>
        <?php
        $displayAccess = 0;
        if (!empty($deliverySettings)) {
            foreach ($deliverySettings as $selectedArray) {

                $delivery_id = $selectedArray['id'];
                $result = GetDeliveryOrders($link, $delivery_id, $loggedUser);
                if (!empty($result)) {
                    continue;
                }
                $displayAccess++;
        ?>
                <div class="col-md-4 pb-3">

                    <div class="card border-0 shadow-sm clickable other-card flex-fill" onclick=" OrderConfirmation('<?= $selectedArray['id'] ?>')">
                        <div class="card-body">
                            <img src="./lib/delivery/assets/images/<?= $selectedArray['icon'] ?>" class="icon">
                            <h4 class="mb-0"><?= $selectedArray['delivery_title'] ?></h4>
                            <h6 class="text-end mb-0"><?= number_format($selectedArray['value'], 2) ?></h6>
                        </div>
                    </div>

                    <?php if ($UserLevel != "Student") { ?>
                        <div class="text-end">
                            <button class="btn btn-dark mt-2" type="button" onclick="CreateNewDelivery('<?= $selectedArray['course_id'] ?>', '<?= $selectedArray['id'] ?>')"><i class="fa-solid fa-pencil"></i> Edit</button>
                        </div>
                    <?php } ?>
                </div>

            <?php
            }
        } else {
            ?>
            <div class="col-12">
                <div class="alert alert-dark">
                    <h6 class="mb-0">No Deliveries Available</h6>
                </div>
            </div>
        <?php
        }

        if ($displayAccess == 0) { ?>
            <div class="col-12">
                <div class="alert alert-dark">
                    <h6 class="mb-0">No Deliveries Available</h6>
                </div>
            </div>
        <?php

        }
        ?>

        <?php if ($UserLevel != "Student") { ?>
            <div class="mt-3 border-top pt-2">
                <p>Do you want to <a href="#" onclick="CreateNewDelivery('<?= $CourseCode ?>', 0)">Create New</a> ?</p>
            </div>
        <?php } ?>
    </div>
</div>