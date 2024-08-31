<?php
require_once '../../include/configuration.php';
include '../../php_handler/function_handler.php';
?>

<style>
    body {
        height: 100vh;
        margin: 0;
    }

    h3 {
        font-weight: 600;
    }

    input {
        padding: 12px !important;
        box-shadow: none !important;
    }

    select {
        padding: 12px !important;
        box-shadow: none !important;
    }

    .text-label {
        font-weight: 500;
    }
</style>

<div class="card register-card border-0 rounded-4 shadow mt-5">
    <div class="card-body p-md-5">

        <div class="row g-4">
            <div class="col-12 text-center">
                <img src="./assets/images/logo.png" alt="Logo" height="50" class="d-inline-block align-text-top">

                <h4 class="text-start mb-0 mt-3 border-bottom pb-2">Create your account</h4>
            </div>
            <div class=" col-md-12">
                <label for="email" class="">Email Address*</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="Email Address" required>
            </div>

            <div class=" col-md-12">
                <label for="email" class="">Full Name*</label>
                <input type="email" name="fullName" id="fullName" class="form-control" placeholder="Full Name" required>
            </div>

            <div class=" col-md-12">
                <label for="email" class="">Name with Initials*</label>
                <input type="email" name="nameWithInitials" id="nameWithInitials" class="form-control" placeholder="Name with Initials" required>
            </div>

            <div class=" col-md-2">
                <label for="status_id" class="">Status*</label>
                <select class="form-control" id="status_id" name="status_id">
                    <option value="Dr.">Dr.</option>
                    <option value="Mr." selected>Mr.</option>
                    <option value="Miss.">Miss.</option>
                    <option value="Mrs.">Mrs.</option>
                    <option value="Rev.">Rev.</option>
                </select>
            </div>
            <div class=" col-md-5">
                <label for="email" class="">First Name*</label>
                <input type="text" name="fname" id="fname" class="form-control" placeholder="First Name" required>
            </div>
            <div class=" col-md-5">
                <label for="email" class="">Last Name*</label>
                <input type="text" name="lname" id="lname" class="form-control" placeholder="Last Name" required>
            </div>

            <div class=" col-md-6">
                <label for="password" class="">Password*</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="***********" required>
            </div>

            <div class=" col-md-6">
                <label for="password" class="">Confirm Password*</label>
                <input type="password" name="confirmPassword" id="confirmPassword" class="form-control" placeholder="***********" required>
            </div>

            <div class=" col-md-4">
                <label for="email" class="">NIC Number*</label>
                <input type="text" name="NicNumber" id="NicNumber" class="form-control" placeholder="NIC Number" required>
            </div>

            <div class=" col-md-4">
                <label for="email" class="">Phone Number*</label>
                <input type="number" name="phoneNumber" id="phoneNumber" class="form-control" maxlength="10" placeholder="Phone Number" required>
                <p id="phoneError"></p>
            </div>
            <div class=" col-md-4">
                <label for="email" class="">WhatsApp Number*</label>
                <input type="number" name="whatsAppNumber" id="whatsAppNumber" class="form-control" maxlength="10" placeholder="WhatsApp Number" required>
            </div>

            <div class=" col-md-12">
                <label for="email" class="">Address Line 1*</label>
                <input type="text" name="addressL1" id="addressL1" class="form-control" placeholder="Address Line 1" required>
            </div>
            <div class=" col-md-12">
                <label for="email" class="">Address Line 2*</label>
                <input type="text" name="addressL2" id="addressL2" class="form-control" placeholder="Address Line 2">
            </div>

            <div class=" col-md-4">
                <label for="email" class="">City</label>
                <select class="form-control js-example-basic-single" id="city" name="city" required onchange="GetDistrict(this.value);">

                    <?php
                    //Get Module List
                    $sql = "SELECT `id`, `district_id`, `name_en`, `name_si` FROM `cities` ORDER BY `name_en`";
                    $sql_result = $link->query($sql);
                    while ($row = $sql_result->fetch_assoc()) { ?>
                        <option value="<?php echo $row["id"]; ?>"><?php echo $row["name_en"]; ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class=" col-md-4">
                <label for="email" class="">District</label>
                <input type="text" name="District" id="District" class="form-control" placeholder="District" readonly>
            </div>

            <div class=" col-md-4">
                <label for="email" class="">Postal Code</label>
                <input type="text" name="postalCode" id="postalCode" class="form-control" placeholder="Postal Code" readonly>
            </div>

            <div class=" col-md-12">
                <label for="email" class="">Your Paid Amount*</label>
                <input type="number" name="paid_amount" id="paid_amount" class="form-control" placeholder="Eg - 9500.00" required>
            </div>

        </div>

        <div class="text-end mt-3">
            <button id="userRegisterButton" class="btn btn-dark mb-4" type="button" value="Register" name="userRegisterButton" onclick="SaveNewUser();">Register</button>
        </div>
        <p class="text-secondary border-top pt-2">Do you have an account? <a href="./login" class="text-reset">Login here</a></p>
    </div>

</div>