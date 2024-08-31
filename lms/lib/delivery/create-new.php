<?php
require_once '../../include/configuration.php';
include '../../php_handler/function_handler.php';
$UserLevel = $_POST['UserLevel'];
$loggedUser = $_POST['LoggedUser'];
$selectedId = $_POST['selectedId'];
$CourseCode = $_POST['CourseCode'];
$deliverySettings = GetDeliverySetting($link, $CourseCode);
$selectedCourse = GetCourses($link)[$CourseCode];
if ($selectedId != 0) {
    $deliverySettings = GetDeliverySetting($link, $CourseCode)[$selectedId];
    $icon = $deliverySettings['icon'];
    $titleName = $deliverySettings['delivery_title'];
    $selectedCourse = GetCourses($link)[$deliverySettings['course_id']];
    $orderValue = $deliverySettings['value'];
} else {
    $icon = $titleName = $orderValue = null;
}

?>
<div class="border-bottom"></div>

<form action="#" method="post" id="submit-form">
    <div class="row mt-3">
        <div class="col-md-8">
            <label for="titleName" class="text-secondary">Selected Course</label>
            <h5><?= $selectedCourse['course_code'] ?> - <?= $selectedCourse['course_name'] ?></h5>
            <input type="hidden" name="selectedCourseCode" id="selectedCourseCode" value="<?= $CourseCode ?>">
            <input type="hidden" name="item_image_tmp" id="item_image_tmp" value="<?= $icon ?>">

        </div>
        <div class="col-md-4">
            <?php if ($selectedId != 0) { ?>
                <img src="./lib/delivery/assets/images/<?= $icon ?>" class="icon" style="width: 100px;">
            <?php } ?>
        </div>

        <div class="col-md-6 mt-2">
            <label for="titleName" class="text-secondary">Title Name</label>
            <input class="form-control p-2" type="text" name="titleName" id="titleName" value="<?= $titleName ?>" placeholder="Enter Title Name!">
        </div>
        <div class="col-md-3 mt-2">
            <label for="titleName" class="text-secondary">Value</label>
            <input class="form-control p-2" type="number" name="value" id="value" placeholder="Enter Value!" value="<?= $orderValue ?>">
        </div>
        <div class="col-md-3 mt-2">
            <label for="titleName" class="text-secondary">Icon</label>
            <input class="form-control p-2" type="file" name="icon" id="icon" placeholder="Enter Title Name!">
        </div>
        <div class="col-12 text-end mt-3">
            <button type="button" class="btn btn-dark" onclick="SaveDelivery(1, '<?= $selectedId ?>')">Save Delivery</button>
        </div>

        <p class="text-secondary border-top pt-2 mt-3 text-center mb-0">Icons - <a href="https://www.flaticon.com/" target="_blank">www.flaticon.com</a></p>
    </div>
</form>