<?php
require_once '../../../../include/configuration.php';
include '../../../../php_handler/function_handler.php';
include '../../php_methods/d-pad-methods.php';

$posProducts = GetPOSProductDetailsAll();
$linkedProducts = GetLinkedProducts();
?>

<style>
    .inner-pop-content {
        max-height: 60vh;
        border-radius: 10px;
        overflow-y: auto;
        overflow-x: hidden;
        padding: 5px;
    }
</style>
<div class="row">
    <div class="col-12 text-end">
        <button class="btn btn-warning" onclick="OpenPosProductPage()"><i class="fa-solid fa-arrow-left"></i> Go Back</button>
    </div>
</div>
<div class="inner-pop-content">

    <div class="row g-2">
        <?php
        if (!empty($posProducts)) {
            foreach ($posProducts as $selectedItem) {
                $linkStatus = "None";
                $linkColor = 'primary';

                $posProductId = $selectedItem['product_id'];
                $productImage = $selectedItem['ImagePath'];
                $productName = $selectedItem['ProductName'];

                if (isset($linkedProducts[$posProductId])) {
                    $linkStatus = "Linked";
                    $linkColor = 'success';
                }
        ?>
                <div class="col-6 col-md-3 col-xxl-2 d-flex">
                    <div class="card border-0 shadow-sm flex-fill rounded-3 clickable" onclick="SetProductLink('<?= $posProductId ?>')">
                        <div class=" card-body">
                            <div class="row">
                                <div class="col-12">
                                    <img src="https://pos.payshia.com/uploads/product_images/<?= $productImage ?>" class="card-image w-100 mb-2">
                                    <h6 class="mb-0"><?= $productName ?></h6>
                                    <div class="text-end">
                                        <span class="badge mb-0 bg-<?= $linkColor ?>"><?= $linkStatus ?></span>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            }
        } else {
            ?>
            <div class="col-12">
                <div class="alert alert-warning">No Products!</div>
            </div>
        <?php
        }
        ?>
    </div>

</div>