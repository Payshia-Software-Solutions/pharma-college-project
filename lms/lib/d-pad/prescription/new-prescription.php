<?php
require_once '../../../include/configuration.php';
include '../../../php_handler/function_handler.php';
include '../php_methods/d-pad-methods.php';


$posProducts = GetPOSProductDetailsAll();
$lmsProducts = GetLinkedProducts();
$prescriptionId = $prescriptionName = $prescriptionStatus = $createdAt = $createdBy = $presName = $presDate = $presAge = $presMethod = $doctorName = $notes = '';

$prescriptionId = $_POST['prescriptionID'];
if ($prescriptionId != '0') {
    $prescriptionArray = GetPrescriptions()[$prescriptionId];

    $prescriptionId = $prescriptionArray['prescription_id'];
    $prescriptionName = $prescriptionArray['prescription_name'];
    $prescriptionStatus = $prescriptionArray['prescription_status'];
    $createdAt = $prescriptionArray['created_at'];
    $createdBy = $prescriptionArray['created_by'];
    $presName = $prescriptionArray['Pres_Name'];
    $presDate = $prescriptionArray['pres_date'];
    $presAge = $prescriptionArray['Pres_Age'];
    $presMethod = $prescriptionArray['Pres_Method'];
    $doctorName = $prescriptionArray['doctor_name'];
    $notes = $prescriptionArray['notes'];
}



?>

<div class="row">
    <div class="col-md-12">
        <h3 class="mb-2 pb-2 border-bottom card-title fw-bold"><?= ($prescriptionId != '0') ? $prescriptionArray['Pres_Name'] : 'New Prescription' ?></h3>
        <form id="prescriptionForm" method="post">

            <div class="row g-3 mt-2">
                <div class="col-md-6">
                    <p class="text-secondary mb-0">Name</p>
                    <input type="text" class="form-control p-2" value="<?= $prescriptionName ?>" name="patientName" id="patientName" placeholder="Enter Patient Name" required>
                </div>

                <div class="col-6 col-md-3">
                    <p class="text-secondary mb-0">Date</p>
                    <input type="date" class="form-control p-2" value="<?= $presDate ?>" name="patientDate" id="patientDate" placeholder="Enter Patient Date" required>
                </div>

                <div class="col-6 col-md-3">
                    <p class="text-secondary mb-0">Age</p>
                    <input type="number" class="form-control p-2" value="<?= $presAge ?>" name="patientAge" id="patientAge" placeholder="Enter Patient Age" required>
                </div>

                <div class="col-md-6">
                    <p class="text-secondary mb-0">Description</p>
                    <textarea id="drugDescription" name="drugDescription"><?= $notes ?></textarea>
                </div>

                <div class="col-md-6">
                    <div class="row g-2">
                        <div class="col-7">
                            <p class="text-secondary mb-0">Drugs</p>
                            <select class="form-control p-2 w form-select" name="drugName" id="drugName">
                                <option value="">Select Medicine</option>
                                <?php
                                if (!empty($lmsProducts)) {
                                    foreach ($lmsProducts as $selectedArray) {
                                        $selectedItem = $posProducts[$selectedArray['pos_id']];
                                ?>
                                        <option value="<?= $selectedItem['ProductName'] ?>"><?= $selectedItem['ProductName'] ?></option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-3">
                            <p class="text-secondary mb-0">Method</p>
                            <select class="form-control p-2 form-select" name="usingMethod" id="usingMethod">
                                <option value="bd">bd</option>
                                <option value="tds">tds</option>
                            </select>
                        </div>
                        <div class="col-2">
                            <p class="text-secondary mb-0">Action</p>
                            <button type="button" class="form-control p-2 btn btn-light w-100" id="addDrugBtn"><i class="fa-solid fa-plus"></i></button>
                        </div>
                    </div>

                    <div class="drugList mt-2">
                        <?php
                        if (isset($prescriptionArray)) {
                            $drugListString = $prescriptionArray["drugs_list"];
                            $drugListArray = explode(', ', $drugListString);
                            if (!empty($drugListArray)) {
                                foreach ($drugListArray as $selectedItem) {
                        ?>
                                    <div class="medicine-item bg-light p-2 rounded-3 mb-2">
                                        <div class="row">
                                            <div class="col-10">
                                                <h5 class="mb-0"><?= $selectedItem ?></h5>
                                            </div>
                                            <div class="col-2 text-end">
                                                <i onclick="removeItem(this)" class="clickable text-danger fa-solid fa-trash"></i>
                                            </div>
                                        </div>
                                    </div>


                        <?php
                                }
                            }
                        }

                        ?>
                    </div>
                </div>

                <div class="col-md-6">
                    <p class="text-secondary mb-0">Method</p>
                    <input type="text" class="form-control p-2" name="usingMethod" value="<?= $presMethod ?>" id="usingMethod" placeholder="Enter Using Method" required>
                </div>

                <div class="col-md-6">
                    <p class="text-secondary mb-0">Doctor Name</p>
                    <input type="text" class="form-control p-2" name="doctorName" value="<?= $doctorName ?>" id="doctorName" placeholder="Enter Patient Name" required>
                </div>

                <div class="col-12 text-end">
                    <button class="btn btn-dark" type="button" onclick="savePrescription('<?= $prescriptionId ?>')"><i class="fa-solid fa-floppy-disk"></i> Save Changes</button>
                </div>
            </div>

        </form>

    </div>
</div>


<script>
    tinymce.remove()
    tinymce.init({
        selector: 'textarea',
        height: 250,
        plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount fullscreen',
        toolbar: 'undo redo fullscreen| blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
    });
</script>

<script>
    $('#drugName').select2();
    // When the add button is clicked
    $("#addDrugBtn").click(function() {
        // Get the entered drug name
        var drugName = $("#drugName").val().trim();
        var usingMethod = $("#usingMethod").val().trim();

        // Check if the input is not empty
        if (drugName !== '') {
            // Append a new item to the drugList
            var newItem = '<div class="medicine-item bg-light p-2 rounded-3 mb-2">' +
                '<div class="row">' +
                '<div class="col-10">' +
                '<h5 class="mb-0">' + drugName + ' ' + usingMethod + '</h5>' +
                '</div>' +
                '<div class="col-2 text-end">' +
                '<i onclick="removeItem(this)" class="clickable text-danger fa-solid fa-trash"></i>' +
                '</div>' +
                '</div>' +
                '</div>';

            $(".drugList").append(newItem);

            // Clear the input field
            $("#drugName").val('');
            $("#drugName").focus();
        }
    });

    // Function to remove the clicked item
    function removeItem(element) {
        $(element).closest('.medicine-item').remove();
    }
</script>