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

<div class="row mb-2 g-2">
    <div class="col-12 text-end">
        <button onclick="LinkNewProducts()" class="btn btn-dark" type="button">
            <h6 class="mb-0"><i class="fa-solid fa-link"></i> Link New Products</h6>
        </button>
    </div>
</div>

<div class="inner-pop-content">

    <div class="row g-3">
        <?php
        if (!empty($linkedProducts)) {
            foreach ($linkedProducts as $selectedArray) {
                $posProductId = $selectedArray['pos_id'];
                $selectedItem = $posProducts[$posProductId];

                $linkedProduct = $linkedProducts[$posProductId];

                $productImage = $selectedItem['ImagePath'];
                $productName = $selectedItem['ProductName'];

                $lmsProductName = $linkedProduct['product_name'];
        ?>
                <div class="col-6 col-md-4 d-flex">
                    <div class="product-card card border-0 shadow-sm flex-fill rounded-3 clickable" onclick="SetProductLink('<?= $posProductId ?>')">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4 col-md-3">
                                    <img src="https://pos.payshia.com/uploads/product_images/<?= $productImage ?>" class="card-image w-100">
                                </div>
                                <div class="col-8 col-md-9">
                                    <p class="text-secondary mb-0">POS Name</p>
                                    <h6 class="mb-0 pb-2"><?= $productName ?></h6>
                                    <div class="border-top pt-2">
                                        <p class="text-secondary mb-0">LMS Name</p>
                                        <h6 class="mb-0"><?= $lmsProductName ?></h6>
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