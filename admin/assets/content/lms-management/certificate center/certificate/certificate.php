<?php
// Include required files
require_once('../../../../../include/config.php');
include '../../../../../include/function-update.php';
include '../../../../../include/lms-functions.php';
require __DIR__ . '/../../../../../vendor/autoload.php';

// For use env file data
use Dotenv\Dotenv;
use Symfony\Component\HttpClient\HttpClient;

// Load environment variables
$dotenv = Dotenv::createImmutable(dirname(__DIR__, 5)); // Go up 5 directories
$dotenv->load();

// Initialize HTTP client
$client = HttpClient::create();
$LoggedUser = $_POST['LoggedUser'] ?? 'Guest';
//print_r($LoggedUser);

// Fetch and prepare the data
$response1 = $client->request('GET', $_ENV["SERVER_URL"] . '/cc_certificate_list/');
$certificateData = $response1->toArray();

//print_r($response1);

// // Check if the data is not empty
// if (empty($certificateData)) {
//     echo "No data available.";
//     exit;
// }
//print_r($LoggedUser);
?>

<div class="row">
    <div class="col-12 d-flex justify-content-end">
        <button class="btn btn-dark" type="button" onclick="openCertificateInsertForm(LoggedUser)">
            <i class="fa-solid fa-plus"></i> Add New Certificate
        </button>
    </div>
</div>
<div class="row mt-3">
    <div class="card-body">
        <div class="col-12">
            <h5 class="table-title">Certification Center</h5>
        </div>
        <div class="row">
            <?php foreach ($certificateData as $certificate): ?>
                <div class="col-md-4">
                    <div class="card mb-4 shadow">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($certificate['list_name'], ENT_QUOTES, 'UTF-8') ?></h5>
                            <p class="card-text">
                                <strong>Price:</strong> <?= number_format($certificate['price'], 2) ?> <br>
                            </p>
                            <span class="badge <?= $certificate['is_active'] ? 'bg-success' : 'bg-danger' ?>">
                                <?= $certificate['is_active'] ? 'Active' : 'Inactive' ?>
                            </span>
                        </div>
                        <!-- Buttons in the same row -->
                        <div class="d-flex justify-content-between px-3 pb-3">
                            <!-- Update Button -->
                            <button
                                class="btn btn-dark btn-sm"
                                type="button"
                                onclick="OpenEditCertificate('<?= htmlspecialchars($LoggedUser, ENT_QUOTES, 'UTF-8') ?>', <?= $certificate['id'] ?>)">
                                <i class="fa fa-edit"></i> Update
                            </button>
                            <!-- Status Button -->
                            <button
                                class="btn btn-sm <?= $certificate['is_active'] ? 'btn-secondary' : 'btn-primary' ?>"
                                type="button"
                                onclick="changeCertificateStatus(<?= $certificate['id'] ?>, <?= $certificate['is_active'] ? 0 : 1 ?>)">
                                <i class="fa-solid <?= $certificate['is_active'] ? 'fa-ban' : 'fa-check' ?>"></i>
                                <?= $certificate['is_active'] ? 'Disable' : 'Activate' ?>
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>