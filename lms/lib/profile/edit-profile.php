<?php

use Mpdf\Tag\Em;

require_once '../../include/configuration.php';
include '../../php_handler/function_handler.php';

$userLevel = $_POST['UserLevel'];
$LoggedUser = $_POST['LoggedUser'];
$CourseCode = $_POST['CourseCode'];

$cityList = GetCities($link);
$districtList = getDistricts($link);
$lmsStudent =  GetLmsStudent()[$LoggedUser];
$userDetails = GetUserDetails($link, $LoggedUser);

$first_name = $userDetails['first_name'];
$last_name = $userDetails['last_name'];
$address_line_1 = $userDetails['address_line_1'];
$address_line_2 = $userDetails['address_line_2'];
$city = $userDetails['city'];
$district = $userDetails['district'];
$postal_code = $userDetails['postal_code'];
$telephone_1 = $userDetails['telephone_1'];
$telephone_2 = $userDetails['telephone_2'];
$nic = $userDetails['nic'];
$e_mail = $userDetails['e_mail'];
$gender = $userDetails['gender'];
$birth_day = $userDetails['birth_day'];
$user_name = $userDetails['username'];
$updated_at = $userDetails['updated_at'];
$civil_status = $userDetails['civil_status'];
$full_name = $userDetails['full_name'];
$name_with_initials = $userDetails['name_with_initials'];
$name_on_certificate = $userDetails['name_on_certificate'];
// var_dump($userDetails);
// var_dump($lmsStudent);
?>


<div class="wizard px-md-5 pt-md-0 pb-md-4">

    <div class="wizard-navigation">
        <button type="button" class="navigation-button active" data-target="basic-info">
            <i class="fa-solid fa-user"></i>
            <h4 class="mb-0 fw-bold">Basic</h4>
        </button>
        <button type="button" class="navigation-button" data-target="address-info">
            <i class="fa-solid fa-address-book"></i>
            <h4 class="mb-0 fw-bold">Address</h4>
        </button>
        <button type="button" class="navigation-button" data-target="certificate-info">
            <i class="fa-solid fa-certificate"></i>
            <h4 class="mb-0 fw-bold">Certificate</h4>
        </button><button type="button" class="navigation-button" data-target="review-info">
            <i class="fa-solid fa-blender"></i>
            <h4 class="mb-0 fw-bold">Finish</h4>
        </button>
    </div>


    <form id="user-details-form" class="">

        <div class="wizard-content" id="basic-info">
            <h3>User Details</h3>
            <div class="row g-2 mt-3">
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="status_id">Civil Status</label>
                        <select onchange="updateReview(this)" class="form-control form-control-sm" id="status_id" name="status_id">
                            <option value="Dr." <?= ($civil_status == "Dr.") ? "selected" : "" ?>>Dr.</option>
                            <option value="Mr." <?= ($civil_status == "Mr.") ? "selected" : "" ?>>Mr.</option>
                            <option value="Miss." <?= ($civil_status == "Miss.") ? "selected" : "" ?>>Miss.</option>
                            <option value="Mrs." <?= ($civil_status == "Mrs.") ? "selected" : "" ?>>Mrs.</option>
                            <option value="Ms." <?= ($civil_status == "Ms.") ? "selected" : "" ?>>Ms.</option>
                            <option value="Rev." <?= ($civil_status == "Rev.") ? "selected" : "" ?>>Rev.</option>
                        </select>

                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="fname">First Name</label>
                        <input onchange="updateReview(this)" type="text" class="form-control" id="fname" name="fname" value="<?= $first_name ?>">
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="lname">Last Name</label>
                        <input onchange="updateReview(this)" type="text" class="form-control" id="lname" name="lname" value="<?= $last_name; ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <select onchange="updateReview(this)" class="form-control form-control-sm" id="Gender" name="Gender">
                            <option value="Male" <?= ($gender == "Male") ? "selected" : "" ?>>Male</option>
                            <option value="Female" <?= ($gender == "Female") ? "selected" : "" ?>>Female</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="DOBirth">Birth Day</label>
                        <input onchange="updateReview(this)" type="date" name="DOBirth" id="DOBirth" class="form-control form-control-sm" placeholder="" value="<?= $birth_day ?>" required>
                    </div>
                </div>


                <div class="col-md-4">
                    <div class="form-group">
                        <label for="NicNumber">NIC</label>
                        <input onchange="updateReview(this)" type="text" name="NicNumber" id="NicNumber" class="form-control form-control-sm" placeholder="" value="<?= $nic; ?>" required>
                    </div>
                </div>




                <div class="col-12 text-end">
                    <button data-target="address-info" type="button" class="btn btn-success next-button" onclick="NextButton('address-info')">Next <i class="fa-solid fa-caret-right"></i></button>
                </div>
            </div>
        </div>

        <div class="wizard-content" id="address-info">
            <h3>Address Details</h3>
            <div class="row g-2 mt-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="phoneNumber">Phone Number</label>
                        <input onchange="updateReview(this)" type="tel" name="phoneNumber" id="phoneNumber" class="form-control form-control-sm" placeholder="" value="<?= $telephone_1 ?>" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="whatsAppNumber">WhatsApp Number</label>
                        <input onchange="updateReview(this)" type="tel" name="whatsAppNumber" id="whatsAppNumber" class="form-control form-control-sm" placeholder="" value="<?= $telephone_2; ?>" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="addressL1">Address Line 1</label>
                        <input onchange="updateReview(this)" type="text" class="form-control" id="addressL1" name="addressL1" value="<?php echo $userDetails['address_line_1']; ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="addressL2">Address Line 2</label>
                        <input onchange="updateReview(this)" type="text" class="form-control" id="addressL2" name="addressL2" value="<?php echo $userDetails['address_line_2']; ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="city">City</label>
                        <select onchange="updateReview(this)" class="form-control form-control-sm js-example-basic-single" id="city" name="city" required onchange="GetDistrict(this.value);">
                            <?php
                            if (!empty($cityList)) {
                                foreach ($cityList as $selectedArray) {
                            ?>
                                    <option value="<?= $selectedArray["id"]; ?>" <?= ($city == $selectedArray["id"]) ? "selected" : ""; ?>><?= $selectedArray["name_en"]; ?></option>
                            <?php }
                            } ?>
                        </select>
                    </div>
                </div>


                <div class="col-12 text-end">
                    <button data-target="address-info" type="button" class="btn btn-success next-button" onclick="NextButton('certificate-info')">Next <i class="fa-solid fa-caret-right"></i></button>
                </div>

            </div>

        </div>

        <div class="wizard-content" id="certificate-info">
            <h3>Certification Details</h3>
            <div class="row g-2 mt-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="full_name">Full Name</label>
                        <input onchange="updateReview(this)" type="text" class="form-control" id="full_name" name="full_name" value="<?php echo $userDetails['full_name']; ?>">
                    </div>

                </div>

                <div class="col-md-6">

                    <div class="form-group">
                        <label for="name_with_initials">Name with Initials</label>
                        <input onchange="updateReview(this)" type="text" class="form-control" id="name_with_initials" name="name_with_initials" value="<?php echo $userDetails['name_with_initials']; ?>">
                    </div>

                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label for="name_on_certificate">Name on Certificate</label>
                        <input onchange="updateReview(this)" type="text" class="form-control" id="name_on_certificate" name="name_on_certificate" value="<?php echo $userDetails['name_on_certificate']; ?>">
                    </div>
                </div>

                <div class="col-12 text-end">
                    <button data-target="address-info" type="button" class="btn btn-success next-button" onclick="NextButton('review-info')">Next <i class="fa-solid fa-caret-right"></i></button>
                </div>
            </div>
        </div>

        <div class="wizard-content" id="review-info">
            <h3>Review</h3>
            <div id="review-content">
                <p>There is No Changes!</p>
            </div>
            <div class="col-12 text-end">
                <!-- Add the Save Changes button -->
                <button type="button" class="btn btn-success" id="saveButton" style="display: none;" onclick="saveProfileEditRequest()"><i class="fa-solid fa-floppy-disk"></i> Save Changes</button>
            </div>
        </div>



    </form>
</div>
<script>
    // Initialize an object to store field values and labels
    const fieldValues = {};

    // Function to update the field values object and refresh the review section
    function updateReview(field) {
        // Get the ID of the input field
        const fieldId = field.id;

        // Find the label associated with the input field
        const label = document.querySelector(`label[for="${fieldId}"]`);

        // Get the label name
        const labelName = label.textContent;

        // Get the field value
        const fieldValue = field.value;

        // Update the field values object with the new value
        fieldValues[fieldId] = {
            label: labelName,
            value: fieldValue
        };

        // Refresh the review section
        refreshReview();
    }

    function refreshReview() {
        document.getElementById('saveButton').style.display = "inline-block";
        // Select the review section
        const reviewSection = document.getElementById('review-content');

        // Initialize an empty string to hold the HTML content of the review section
        let reviewContent = '';

        let count = 0;
        // Iterate over the field values object and construct the review content
        for (const fieldId in fieldValues) {
            if (fieldValues.hasOwnProperty(fieldId)) {
                const fieldData = fieldValues[fieldId];
                // Start a new row for every 2 fields (2 columns per row)
                if (count % 2 === 0) {
                    reviewContent += '<div class="row">';
                }
                // Add a Bootstrap column for each field
                reviewContent += `<div class="col-md-6"><p><strong>${fieldData.label}:</strong> ${fieldData.value}</p></div>`;
                // Close the row after every 2 fields
                if (count % 2 !== 0) {
                    reviewContent += '</div>';
                }
                count++;
            }
        }
        // Close the row if the number of fields is odd
        if (count % 2 !== 0) {
            reviewContent += '</div>';
        }

        // Update the inner HTML of the review section with the new content
        reviewSection.innerHTML = reviewContent;
    }
</script>



<script>
    function setupWizard() {
        const buttons = document.querySelectorAll('.navigation-button');
        const contents = document.querySelectorAll('.wizard-content');

        buttons.forEach(function(button) {
            button.addEventListener('click', function() {
                const target = button.getAttribute('data-target');
                // Hide all contents
                contents.forEach(function(content) {
                    content.style.display = 'none';
                });

                // Show the targeted content
                document.getElementById(target).style.display = 'block';

                // Remove active class from all buttons
                buttons.forEach(function(btn) {
                    btn.classList.remove('active');
                });

                // Add active class to the clicked button
                button.classList.add('active');
            });
        });


    }

    // Call setupWizard function when the page loads
    setupWizard();


    function NextButton(dataTarget) {
        const buttons = document.querySelectorAll('.navigation-button');
        const contents = document.querySelectorAll('.wizard-content');

        // Hide all contents
        contents.forEach(function(content) {
            content.style.display = 'none';
        });

        // Show the targeted content
        document.getElementById(dataTarget).style.display = 'block';

        // Remove active class from all buttons
        buttons.forEach(function(btn) {
            btn.classList.remove('active');
        });

        // Add active class to the corresponding button
        buttons.forEach(function(button) {
            if (button.getAttribute('data-target') === dataTarget) {
                button.classList.add('active');
            }
        });
    }
    // $('#city').select2()
</script>