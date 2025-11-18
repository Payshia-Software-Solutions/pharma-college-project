<?php

require '../../vendor/autoload.php';
require_once '../../php_handler/function_handler.php';

use Symfony\Component\HttpClient\HttpClient;

// Create an HTTP client
$client = HttpClient::create();

// For using environment variables (from .env file)
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

$LoggedUser = $_POST['LoggedUser'];
$CourseCode = $_POST['CourseCode']; // CourseCode sent as a query parameter
$certificateId = $_POST['certificateId'];
//print_r($certificateId);
//print_r($CourseCode);
//print_r($_POST);


$formResponse = $client->request('GET', $_ENV["SERVER_URL"] . '/userFullDetails/username/' . $LoggedUser);

// Get the response body as an array
$formData = $formResponse->toArray();
//print_r($formData);

// Assuming $formData contains the array from the response
$mobile = $formData['telephone_1'] ?? null; // Using 'telephone_1' as the mobile number

// If 'telephone_1' is missing and 'telephone_2' should be used, fallback to 'telephone_2'
if (!$mobile && isset($formData['telephone_2'])) {
    $mobile = $formData['telephone_2'];
}

$addressLine1 = $formData['address_line_1'] ?? null;
$studentCity = $formData['city'];
$addressLine2 = $formData['address_line_2'] ?? null;

$firstName = $formData['first_name'] ?? null;
$lastName = $formData['last_name'] ?? null;
$fullName = $firstName . ' ' . $lastName;

// Output the mobile number
//echo $mobile;
//echo $addressLine1;
//echo $addressLine2;

$certificateData = $client->request('GET', $_ENV["SERVER_URL"] . '/cc_certificate_list/' . $certificateId);
// Get the response body as an array (if it's JSON)

$formData2 = $certificateData->toArray();

//print_r($formData2);
$price = $formData2['price'] ?? 0;
//print_r($price);

$formData3 = $certificateData->toArray();
//print_r($data6);
$Title = $formData3['list_name'] ?? 0;
//print_r($Title);

require_once '../../php_handler/function_handler.php'; // Include your function file

// Fetch all cities
$cities = GetCities($link);

// Extract `name_en` values
$cityNames = [];
foreach ($cities as $city) {
    if (isset($city['name_en'])) {
        $cityNames[] = $city['name_en'];
    }
}

// Validation logic for Mobile and Address Line 1
$mobileError = $addressLine1Error = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Validate Mobile Number
    if (empty($_POST["mobile"])) {
        $mobileError = "Mobile number is required.";
    } else {
        $mobile = htmlspecialchars($_POST["mobile"]);
        if (!preg_match("/^\d{10}$/", $mobile)) {
            $mobileError = "Mobile number must be 10 digits.";
        }
    }

    // Validate Address Line 1
    if (empty($_POST["address_line1"])) {
        $addressLine1Error = "Address Line 1 is required.";
    } else {
        $addressLine1 = htmlspecialchars($_POST["address_line1"]);
    }
}
?>



<div class="card border-0 shadow-lg rounded-4 p-5" id="form-card">

    <div class="row">
        <div class="col-12 text-end">
            <i class="fa-solid fa-close"
                onclick="CloseCertificateForm('<?= $LoggedUser ?>', '<?= $certificateId ?>')"
                type="button"></i>
        </div>
    </div>

    <!--desktop view-->

    <form class="desktop-view" id="order_form" action="" method="post">
        <div class="text-center p-10">
            <h3 class="p-2 fw-bold"><?= $Title ?> Order Form</h3>
        </div>

        <input type="hidden" name="course_code" value="<?= htmlspecialchars($CourseCode) ?>">
        <!-- Hidden input to auto-fill created_by -->
        <div class="form-group row">
            <div class="col-5">
                <label for="Student_ID">Student ID:</label>
                <input type="text" class="form-control" id="created_by" name="created_by" value=<?= htmlspecialchars($LoggedUser) ?> readonly>
                <br>
            </div>
            <div class="col-7">
                <!--Student Name-->
                <label for="fullName">Full Name:</label>
                <input type="text" class="form-control" id="fullName" name="fullName" value="<?= htmlspecialchars($fullName) ?>" required readonly>
                <br>
            </div>
        </div>


        <div class="form-group row">
            <!-- Mobile Number -->
            <div class="col-5">
                <label for="mobile">Mobile Number:</label>
                <input type="text" class="form-control" id="mobile" name="mobile" value="<?= htmlspecialchars($mobile) ?>" required>
                <?php if (!empty($mobileError)): ?>
                    <div class="text-danger"><?= $mobileError ?></div>
                <?php endif; ?>
                <br>
            </div>
            <!-- Address Line 1 -->
            <div class="col-7">
                <label for="address_line1">Address Line 1:</label>
                <input type="text" class="form-control" id="address_line1" name="address_line1" value="<?= htmlspecialchars($addressLine1) ?>" required>
                <?php if (!empty($addressLine1Error)): ?>
                    <div class="text-danger"><?= $addressLine1Error ?></div>
                <?php endif; ?>
                <br>
            </div>
        </div>

        <div class="form-group row">
            <!--city_id-->
            <div class="col-5">
                <label for="city-dropdown">Select City:</label>
                <select name="city_id" id="city_id" class="form-control" required>
                    <option value="" disabled selected>Select City</option>
                    <?php foreach ($cities as $city): ?>
                        <option value="<?= htmlspecialchars($city['id'], ENT_QUOTES, 'UTF-8') ?>" <?= ($studentCity == $city['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($city['name_en'], ENT_QUOTES, 'UTF-8') ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <br>
            </div>
            <!-- Address Line 2 -->
            <div class="col-7">
                <label for="address_line2">Address Line 2:</label>
                <input type="text" class="form-control" id="address_line2" name="address_line2" value="<?= htmlspecialchars($addressLine2) ?>">
                <br>
            </div>
        </div>



        <input type="hidden" name="type" value="1">
        <input type="hidden" name="payment" value="12000">
        <input type="hidden" name="package_id" value="1">
        <input type="hidden" name="certificate_id" value="1">
        <input type="hidden" name="certificate_status" value="Pending">
        <input type="hidden" name="cod_amount" value="111">
        <input type="hidden" name="is_active" value="1">

        <!--Submit Button-->

        <button class="btn btn-success w-100 btn-lg"
            onclick="submitOrder('<?= $certificateId ?>')"
            type="button">Order</button>

    </form>


    <!--mobile view-->

    <form class="mobile-view" id="order_form" action="" method="post">
        <div class="text-center p-10">
            <h3 class="p-2 fw-bold"><?= $Title ?> Order Form</h3>
        </div>

        <!-- Hidden input to auto-fill created_by -->

        <input type="hidden" name="course_code" value="<?= htmlspecialchars($CourseCode) ?>">
        <div class="form-group">
            <label for="Student_ID">Student ID:</label>
            <input type="text" class="form-control" id="created_by" name="created_by" value=<?= htmlspecialchars($LoggedUser) ?> readonly>
            <br>
        </div>

        <!--Student Name-->
        <div class="form-group">
            <label for="fullName">Full Name:</label>
            <input type="text" class="form-control" id="fullName" name="fullName" value="<?= htmlspecialchars($fullName) ?>" required readonly>
            <br>
        </div>

        <!-- Mobile Number -->
        <div class="form-group">
            <label for="mobile">Mobile Number:</label>
            <input type="text" class="form-control" id="mobile" name="mobile" value="<?= htmlspecialchars($mobile) ?>" required>
            <?php if (!empty($mobileError)): ?>
                <div class="text-danger"><?= $mobileError ?></div>
            <?php endif; ?>
            <br>
        </div>

        <!-- Address Line 1 -->
        <div class="form-group">
            <label for="address_line1">Address Line 1:</label>
            <input type="text" class="form-control" id="address_line1" name="address_line1" value="<?= htmlspecialchars($addressLine1) ?>" required>
            <?php if (!empty($addressLine1Error)): ?>
                <div class="text-danger"><?= $addressLine1Error ?></div>
            <?php endif; ?>
            <br>
        </div>

        <!-- Address Line 2 -->
        <div class="form-group">
            <label for="address_line2">Address Line 2:</label>
            <input type="text" class="form-control" id="address_line2" name="address_line2" value="<?= htmlspecialchars($addressLine2) ?>">
            <br>
        </div>

        <!--city_id-->
        <div class="form-group">
            <label for="city-dropdown">Select City:</label>
            <select name="city_id" id="city_id" class="form-control" required>
                <option value="">Select City</option>
                <?php foreach ($cities as $city): ?>
                    <option value="<?= htmlspecialchars($city['id'], ENT_QUOTES, 'UTF-8') ?>" <?= ($studentCity == $city['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($city['name_en'], ENT_QUOTES, 'UTF-8') ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <br>
        </div>



        <input type="hidden" name="type" value="1">
        <input type="hidden" name="payment" value="12000">
        <input type="hidden" name="package_id" value="1">
        <input type="hidden" name="certificate_id" value="1">
        <input type="hidden" name="certificate_status" value="print">
        <input type="hidden" name="cod_amount" value="111">
        <input type="hidden" name="is_active" value="1">

        <!--Submit Button-->

        <button class="btn btn-success w-100 btn-lg"
            onclick="submitOrder('<?= $certificateId ?>')"
            type="button">Order</button>

    </form>

</div>


<!-- <script>
    // Get the radio buttons and packageGroup div
    const graduationRadio = document.getElementById("graduation");
    const certificateRadio = document.getElementById("certificate");
    const packageGroup = document.getElementById("packageGroup");

    // Function to toggle the visibility of the packageGroup
    function togglePackageGroup() {
        if (graduationRadio.checked) {
            packageGroup.style.display = "block"; // Show the packageGroup div
        } else {
            packageGroup.style.display = "none"; // Hide the packageGroup div
        }
    }

    // Event listeners to call the toggle function when the radio button is clicked
    graduationRadio.addEventListener("change", togglePackageGroup);
    certificateRadio.addEventListener("change", togglePackageGroup);

    // Initialize the visibility based on the selected radio button
    togglePackageGroup();
</script> -->