<?php
require_once '../../../include/configuration.php';
include '../../../php_handler/function_handler.php';
include '../php_methods/d-pad-methods.php';

$studentsArray =  GetLmsStudent();
// var_dump($studentsArray);
?>

<div class="row mb-3">
    <div class="col-12">
        <h4 class="mb-0 fw-bold">User Submissions</h4>
    </div>
</div>


<div class="row g-2 m-2">
    <div class="col-md-9">
        <select class="form-control form-select" name="studentNumber" id="studentNumber">
            <option value="">Select Student</option>
            <?php
            if (!empty($studentsArray)) {
                foreach ($studentsArray as $selectedItem) {
            ?>
                    <option value="<?= $selectedItem['username'] ?>"><?= $selectedItem['username'] ?> - <?= $selectedItem['fname'] ?> <?= $selectedItem['lname'] ?></option>
            <?php
                }
            }

            ?>
        </select>
        </select>
    </div>
    <div class="col-md-3">
        <button type="button" onclick="GetUserSubmissions($('#studentNumber').val())" class="btn btn-dark form-control w-100" style="height: 45px;">Get</button>
    </div>
</div>

<div id="submission-list"></div>

<script>
    $('#studentNumber').select2()
</script>