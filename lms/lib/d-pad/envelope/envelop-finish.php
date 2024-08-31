<?php
require_once '../../../include/configuration.php';
include '../../../php_handler/function_handler.php';
$incorrect_values = $_POST['incorrect_values'];
?>

<div class="row">
    <div class="col-12 mb-2">
        <h4>Wrong Fields</h4>
    </div>
</div>
<?php
// Check if the $incorrect_values array is not empty
if (!empty($incorrect_values)) {
    foreach ($incorrect_values as $value) {

        if ($value == "drug_type") {
            $value = "dosage_form";
        }

        if ($value == "additional_description") {
            $value = "additional_instruction";
        }
?>
        <div class="alert alert-warning"><?= formatErrorResults($value) ?></div>
<?php
    }
} else {
    echo 'No incorrect values found.';
}
