<?php
// Include required files
require_once('../../../../include/config.php');
include '../../../../include/function-update.php';
include '../../../../include/lms-functions.php';
require __DIR__ . '/../../../../vendor/autoload.php';

// For use env file data
use Dotenv\Dotenv;
use Symfony\Component\HttpClient\HttpClient;

// Load environment variables
$dotenv = Dotenv::createImmutable(dirname(__DIR__, 4)); // Go up 5 directories
$dotenv->load();

// Initialize HTTP client
$client = HttpClient::create();

// Fetch logged-in user data (if needed)
$LoggedUser = $_POST['LoggedUser'];
$UserLevel = $_POST['UserLevel'];


// Fetch certificate order data from API
$response = $client->request('GET', $_ENV["SERVER_URL"] . '/cc_certificate_order/');

//var_dump($response);
$data = $response->toArray();

//print_r($data);

// Fetch all cities data from the database
$cities = GetCities($link);

$pendingCount = 0;

// Loop through the data and count the number of 'pending' certificates
foreach ($data as $row) {
    if ($row['certificate_status'] == 'pending') {
        $pendingCount++;
    }
}

?>

<div class="row">
    <div class="col-12 col-md-2 mb-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <p class="mb-0 text-white">Pending</p>
                <h1><?= $pendingCount ?></h1>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-3 mb-3 ">
        <div class="card bg-warning text-white">
            <button type="button"
                onclick="ViewCertificate('<?= $LoggedUser ?>')"
                class="btn btn-dark card-body"><i class="fa fa-certificate"></i><br>
                Certificate
            </button>
        </div>
    </div>
    <div class="col-12 col-md-3 mb-3 ">
        <div class="card bg-warning text-white">
            <button type="button"
                onclick="ViewCriteriaGroups('<?= htmlspecialchars($LoggedUser, ENT_QUOTES) ?>')"
                class="btn btn-dark w-100 card-body"><i class="fa fa-list-alt"></i><br>
                Criteria Groups
            </button>
        </div>
    </div>
    <div class="col-12 col-md-3 mb-3">
        <div class="card bg-warning text-white">
            <button type="button"
                onclick="ViewCriteriaList('<?= htmlspecialchars($LoggedUser, ENT_QUOTES) ?>')"
                class="btn btn-dark card-body"><i class="fa fa-list"></i><br>
                Criteria List
            </button>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-12">
        <div class="">
            <div class="">
                <div class="col-12">
                    <h5 class="table-title">Certification Center</h5>
                </div>
                <div class="row">
                    <div class="table-responsive">
                        <table class="table" id="certificate-order-table">
                            <thead>
                                <tr>
                                    <th scope="col">Certificate Name</th>
                                    <th scope="col">Order Date</th>
                                    <th scope="col">Mobile</th>
                                    <th scope="col">Address Line 01</th>
                                    <th scope="col">Address Line 02</th>
                                    <th scope="col">City</th>
                                    <th scope="col">Certificate Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data as $row) {
                                    // Get city name from the city ID
                                    $city_id = $row['city_id'];
                                    $city_name = isset($cities[$city_id]) ? $cities[$city_id]['name_en'] : 'Unknown'; // Default to 'Unknown' if city not found
                                    $print_id = $row['id'];
                                ?>
                                    <tr>
                                        <td><?= $row['certificate_name'] ?></td>
                                        <td><?= $row['created_at'] ?></td>
                                        <td><?= $row['mobile'] ?></td>
                                        <td><?= $row['address_line1'] ?></td>
                                        <td><?= $row['address_line2'] ?></td>
                                        <td><?= $city_name ?></td>
                                        <td><?= $row['certificate_status'] ?></td>
                                        <td>
                                            <button onclick="OpenTranscriptDataEntry('<?= $row['created_by'] ?>', '<?= $row['course_code'] ?>')" class="btn btn-success btn-sm rounded-2" type="button"><i class="fa-solid fa-file-lines"></i></button>
                                            <button onclick="OpenEditProfileDialogue('<?= $row['created_by'] ?>', '<?= $row['course_code'] ?>')" class="btn btn-primary btn-sm rounded-2" type="button"><i class="fa-solid fa-user-pen"></i></button>
                                            <button onclick="PrintDialogOpen('<?= $row['created_by'] ?>', '<?= $row['course_code'] ?>', '<?= $row['id'] ?>')" class="btn btn-dark btn-sm rounded-2" type="button"><i class="fa-solid fa-print"></i></button>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>

<script>
    $(document).ready(function() {
        $('#certificate-order-table').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf'
                // 'colvis'
            ],
            order: [
                [1, 'desc'],
                [0, 'asc']
            ]
        });
    });
</script>