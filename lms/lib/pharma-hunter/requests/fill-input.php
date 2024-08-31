<?php
require_once '../../../include/configuration.php';
include '../../../php_handler/function_handler.php';
include '../php_methods/pharma-hunter-methods.php';

$sourceType = $_POST['sourceType'];

$rackList =  GetSource('racks'); //racks, dosageForm, dosageCategory, drugGroup
$dosageFormList =  GetSource('dosageForm');
$dosageCategoryList =  GetSource('drugCategory');
$drugGroupList =  GetSource('drugGroup');

if ($sourceType == "racks") {
    $selectedList =  $rackList;
    $selectedTitle = 'Available Racks';
} else if ($sourceType == 'dosageForm') {
    $selectedList = $dosageFormList;
    $selectedTitle = 'Available Dosage Forms';
} else if ($sourceType == 'drugCategory') {
    $selectedList = $dosageCategoryList;
    $selectedTitle = 'Available Dosage Categories';
} else if ($sourceType == 'drugGroup') {
    $selectedList = $drugGroupList;
    $selectedTitle = 'Available Drug Groups';
}
?>

<h5 class="border-bottom pb-2 mb-2 fw-bold"><?= $selectedTitle ?></h5>
<div class="row g-2">

    <?php
    if (!empty($selectedList)) {
        foreach ($selectedList as $selectedArray) {

            $dataValue = $selectedArray['name'];
            $dataId = $selectedArray['id'];
    ?>
            <div class="col-md-4">
                <div class="card clickable shadow-sm border-0" onclick="SetDataValue('<?= $sourceType ?>', '<?= $dataValue ?>', '<?= $dataId ?>')">
                    <div class="card-body">
                        <h6 class="mb-0 fw-bold"><?= $dataValue ?></h6>
                    </div>
                </div>
            </div>
    <?php
        }
    }

    ?>
</div>