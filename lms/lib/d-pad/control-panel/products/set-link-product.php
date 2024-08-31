<?php
require_once '../../../../include/configuration.php';
include '../../../../php_handler/function_handler.php';
include '../../php_methods/d-pad-methods.php';

$posProducts = GetPOSProductDetailsAll();
$linkedProducts = GetLinkedProducts();


$productName = "";
$methodList = array();
$ageGroupList = array();
$instructionList = array();

// POST Parameters
$posProductId = $_POST['posProductId'];
$isActive = 1;

$selectedItem = $posProducts[$posProductId];

$productImage = $selectedItem['ImagePath'];
$posProductName = $selectedItem['ProductName'];


$ageArray =  array(
    array('id' => '1', 'value' => '1-5'),
    array('id' => '2', 'value' => '5-10'),
    array('id' => '3', 'value' => '10-18'),
    array('id' => '4', 'value' => '18-55'),
    array('id' => '5', 'value' => '55+')
);

if (isset($linkedProducts[$posProductId])) {
    $selectedProduct = $linkedProducts[$posProductId];
    $productName = $selectedProduct['product_name'];

    $methodListString = $selectedProduct["method_list"];
    $methodList = explode(', ', $methodListString);

    $instructionListString = $selectedProduct["instruction_list"];
    $instructionList = explode(', ', $instructionListString);

    $ageGroupsListString = $selectedProduct["age_groups"];
    $ageGroupList = explode(', ', $ageGroupsListString);
} else {
    $productName = $posProductName;
}
?>

<div class="row">
    <div class="col-12 text-end">
        <button class="btn btn-warning" onclick="LinkNewProducts()"><i class="fa-solid fa-arrow-left"></i> Go Back</button>
    </div>
</div>
<div class="inner-pop-content">
    <div class="row g-3">
        <div class="col-md-4 col-lg-3">
            <h5 class="mb-0 mb-2"><?= $posProductName ?></h5>
            <div class="text-center">
                <img src="https://pos.payshia.com/uploads/product_images/<?= $productImage ?>" class="card-image w-100 mb-2">
            </div>
        </div>
        <div class="col-md-8 col-lg-9">
            <form id="product-form" action="" method="post">

                <div class="row g-3">
                    <div class="col-12">
                        <p class="text-secondary mb-0">Product Name</p>
                        <input class="form-control" type="text" name="productName" id="productName" value="<?= $productName ?>" placeholder="Enter Product Name" required>
                    </div>


                    <div class="col-12">
                        <div class="row g-3">
                            <div class="col-md-6">

                                <div class="row g-2">
                                    <div class="col-10">

                                        <div class="row g-3">
                                            <div class="col-12">
                                                <p class="text-secondary mb-0">Possible Methods</p>
                                                <select class="form-control p-2 form-select" name="usingMethods" id="usingMethods">
                                                    <option value="bd">bd</option>
                                                    <option value="tds">tds</option>
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-2">
                                        <p class="text-secondary mb-0">Action</p>
                                        <button type="button" class="form-control p-2 btn btn-light w-100" id="addBtn"><i class="fa-solid fa-plus"></i></button>
                                    </div>
                                </div>

                                <div class="row g-2 mt-2">
                                    <div class="col-10">
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <p class="text-secondary mb-0">Possible Age Groups</p>
                                                <select class="form-control p-2 form-select" name="ageGroup" id="ageGroup">
                                                    <?php
                                                    if (!empty($ageArray)) {
                                                        foreach ($ageArray as $selectedArray) {
                                                    ?>
                                                            <option value="<?= $selectedArray['value'] ?>"><?= $selectedArray['value'] ?></option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>

                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-2">
                                        <p class="text-secondary mb-0">Action</p>
                                        <button type="button" class="form-control p-2 btn btn-light w-100" id="addAgeBtn"><i class="fa-solid fa-plus"></i></button>
                                    </div>
                                </div>

                                <div class="row g-2 mt-2">
                                    <div class="col-10">
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <p class="text-secondary mb-0">Instructions</p>
                                                <input type="text" class="form-control p-2" name="drugInstruction" id="drugInstruction" placeholder="Enter Drug Instruction">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-2">
                                        <p class="text-secondary mb-0">Action</p>
                                        <button type="button" class="form-control p-2 btn btn-light w-100" id="addInstructionBtn"><i class="fa-solid fa-plus"></i></button>
                                    </div>
                                </div>


                            </div>
                            <div class="col-md-6">
                                <label>Methods</label>
                                <div class="methodList row">
                                    <?php
                                    if (!empty($methodList)) {
                                        foreach ($methodList as $selectedItem) {
                                            if ($selectedItem == '') {
                                                continue;
                                            }
                                    ?>
                                            <div class="col-md-6 method-item">
                                                <div class=" bg-light p-2 rounded-3 mb-2">
                                                    <div class="row">
                                                        <div class="col-10">
                                                            <h5 class="mb-0"><?= $selectedItem ?>
                                                        </div>
                                                        <div class="col-2 text-end">
                                                            <i onclick="removeItem(this)" class="clickable text-danger fa-solid fa-trash"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    <?php
                                        }
                                    }
                                    ?>
                                </div>

                                <div class="border-top mt-2"></div>

                                <label class="mt-2">Ages</label>
                                <div class="ageList row">
                                    <?php
                                    if (!empty($ageGroupList)) {
                                        foreach ($ageGroupList as $selectedItem) {

                                            if ($selectedItem == '') {
                                                continue;
                                            }
                                    ?>
                                            <div class="col-md-6 method-item">
                                                <div class=" bg-light p-2 rounded-3 mb-2">
                                                    <div class="row">
                                                        <div class="col-10">
                                                            <h5 class="mb-0"><?= $selectedItem ?>
                                                        </div>
                                                        <div class="col-2 text-end">
                                                            <i onclick="removeAgeItem(this)" class="clickable text-danger fa-solid fa-trash"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    <?php
                                        }
                                    }
                                    ?>
                                </div>


                                <div class="border-top mt-2"></div>

                                <label class="mt-2">Instructions</label>
                                <div class="instructionList row">
                                    <?php
                                    if (!empty($instructionList)) {
                                        foreach ($instructionList as $selectedItem) {
                                            if ($selectedItem == '') {
                                                continue;
                                            }
                                    ?>
                                            <div class="col-12 method-item">
                                                <div class=" bg-light p-2 rounded-3 mb-2">
                                                    <div class="row">
                                                        <div class="col-10">
                                                            <h5 class="mb-0"><?= $selectedItem ?>
                                                        </div>
                                                        <div class="col-2 text-end">
                                                            <i onclick="removeInstruction(this)" class="clickable text-danger fa-solid fa-trash"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    <?php
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </form>

        </div>
    </div>

    <div class="row">
        <div class="col-12 text-end">
            <button onclick="saveProductLink('<?= $posProductId ?>', '<?= $isActive ?>')" class="btn btn-dark"><i class="fa-solid fa-floppy-disk"></i> Save Changes</button>
        </div>
    </div>
</div>

<script>
    // $('#usingMethods').select2();

    $("#addBtn").click(function() {
        // Get the entered drug name
        var usingMethod = $("#usingMethods").val();

        // Check if the input is not empty
        if (usingMethod !== '' && usingMethod != null) {
            usingMethod = usingMethod.trim()
            // Check if the item already exists in the list
            if (!$(".methodList:contains('" + usingMethod + "')").length) {
                // Append a new item to the drugList
                var newItem = '<div class="col-md-6 method-item"><div class=" bg-light p-2 rounded-3 mb-2">' +
                    '<div class="row">' +
                    '<div class="col-10">' +
                    '<h5 class="mb-0">' + usingMethod + '</h5>' +
                    '</div>' +
                    '<div class="col-2 text-end">' +
                    '<i onclick="removeItem(this)" class="clickable text-danger fa-solid fa-trash"></i>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>';

                $(".methodList").append(newItem);

                // Clear the input field
                // $("#usingMethods").val('');
                $("#usingMethods").focus();
            } else {
                // Display a message or perform other actions when the item already exists
                result = 'This method already exists in the list.'
                showNotification(result, 'error', 'Warning!')
            }
        } else {
            // Display a message or perform other actions when the item already exists
            result = 'Please select an item.'
            showNotification(result, 'error', 'Warning!')
        }
    });

    $("#addAgeBtn").click(function() {
        // Get the entered drug name
        var usingMethod = $("#ageGroup").val();

        // Check if the input is not empty
        if (usingMethod !== '' && usingMethod != null) {
            usingMethod = usingMethod.trim()
            // Check if the item already exists in the list
            if (!$(".ageList:contains('" + usingMethod + "')").length) {
                // Append a new item to the drugList
                var newItem = '<div class="col-md-6 age-item "><div class="bg-light p-2 rounded-3 mb-2">' +
                    '<div class="row">' +
                    '<div class="col-10">' +
                    '<h5 class="mb-0">' + usingMethod + '</h5>' +
                    '</div>' +
                    '<div class="col-2 text-end">' +
                    '<i onclick="removeAgeItem(this)" class="clickable text-danger fa-solid fa-trash"></i>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>';

                $(".ageList").append(newItem);

                // Clear the input field
                // $("#ageGroup").val('');
                $("#ageGroup").focus();
            } else {
                // Display a message or perform other actions when the item already exists
                result = 'This method already exists in the list.'
                showNotification(result, 'error', 'Warning!')
            }
        } else {
            // Display a message or perform other actions when the item already exists
            result = 'Please select an item.'
            showNotification(result, 'error', 'Warning!')
        }
    });

    $("#addInstructionBtn").click(function() {
        // Get the entered drug name
        var drugInstruction = $("#drugInstruction").val();

        // Check if the input is not empty
        if (drugInstruction !== '' && drugInstruction != null) {
            drugInstruction = drugInstruction.trim()
            // Check if the item already exists in the list
            if (!$(".instructionList:contains('" + drugInstruction + "')").length) {
                // Append a new item to the drugList
                var newItem = '<div class="col-12 instruction-item"><div class="bg-light p-2 rounded-3 mb-2">' +
                    '<div class="row">' +
                    '<div class="col-10">' +
                    '<h5 class="mb-0">' + drugInstruction + '</h5>' +
                    '</div>' +
                    '<div class="col-2 text-end">' +
                    '<i onclick="removeInstruction(this)" class="clickable text-danger fa-solid fa-trash"></i>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>';

                $(".instructionList").append(newItem);

                // Clear the input field
                $("#drugInstruction").val('');
                $("#drugInstruction").focus();
            } else {
                // Display a message or perform other actions when the item already exists
                result = 'This method already exists in the list.'
                showNotification(result, 'error', 'Warning!')
            }
        } else {
            // Display a message or perform other actions when the item already exists
            result = 'Please select an item.'
            showNotification(result, 'error', 'Warning!')
        }
    });



    // Function to remove the clicked item
    function removeItem(element) {
        $(element).closest('.method-item').remove();
    }
    // Function to remove the clicked item
    function removeAgeItem(element) {
        $(element).closest('.age-item').remove();
    }

    function removeInstruction(element) {
        $(element).closest('.instruction-item').remove();
    }
</script>