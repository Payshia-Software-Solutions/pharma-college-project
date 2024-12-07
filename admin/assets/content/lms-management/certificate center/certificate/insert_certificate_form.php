<?php
// Include required files
require_once('../../../../../include/config.php');
include '../../../../../include/function-update.php';
include '../../../../../include/lms-functions.php';
require __DIR__ . '/../../../../../vendor/autoload.php';

// For using env file data
use Dotenv\Dotenv;
use Symfony\Component\HttpClient\HttpClient;

// Load environment variables
$dotenv = Dotenv::createImmutable(dirname(__DIR__, 5)); // Go up 5 directories
$dotenv->load();

// Initialize Symfony HTTP client
$client = HttpClient::create();
$LoggedUser = $_POST['LoggedUser'] ?? 'Guest';

// Fetch certificate data
try {
    $response1 = $client->request('GET', $_ENV["SERVER_URL"] . '/cc_certificate_list/');
    $certificateData = json_decode($response1->getContent(), true);  // Use getContent() instead of getBody()
} catch (Exception $e) {
    die('Failed to fetch certificate data: ' . $e->getMessage());
}

// Fetch criteria groups data
try {
    $response2 = $client->request('GET', $_ENV["SERVER_URL"] . '/cc_criteria_group/');
    $criteriaGroups = json_decode($response2->getContent(), true);  // Use getContent() instead of getBody()
} catch (Exception $e) {
    die('Failed to fetch criteria group data: ' . $e->getMessage());
}
//print_r($LoggedUser);
?>

<div class="container loading-popup-content">
    <div class="row">
        <div class="col-12 w-100 text-end">
            <button class="btn btn-sm btn-dark" onclick="ClosePopUP()"><i class="fa-regular fa-circle-xmark"></i></button>
        </div>
    </div>
    <h3 class="border-bottom pb-2">Add New Certificate</h3>
    <form id="insertCertificateForm" class="form" method="post">
        <div class="row">
            <div class="col-md-5 mb-2">
                <h6 class="certificateName-label">Certificate Name</h6>
                <input type="text" class="form-control" id="certificateName" name="list_name" required>
                <div class="invalid-feedback">
                    Certificate Name is required.
                </div>
            </div>
            <div class="col-md-4 mb-2">
                <h6 class="certificateName-label">Criteria Group</h6>
                <select class="form-control" id="criteriaGroupId" name="criteria_group_id" required>
                    <option value="" disabled selected>Select Criteria Group</option>
                    <?php foreach ($criteriaGroups as $group): ?>
                        <option value="<?= htmlspecialchars($group['id'], ENT_QUOTES, 'UTF-8') ?>">
                            <?= htmlspecialchars($group['group_name'], ENT_QUOTES, 'UTF-8') ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <div class="invalid-feedback">
                    Criteria Group is required.
                </div>
            </div>
            <div class="col-md-3 mb-2">
                <h6 class="certificatePrice-label">Price</h6>
                <input type="number" class="form-control" id="certificatePrice" name="price" step="0.01" required min="0.01">
                <div class="invalid-feedback">
                    Price is required and must be at least 0.01.
                </div>
            </div>
            <input type="hidden" id="createdBy" name="created_by" value="<?= htmlspecialchars($LoggedUser, ENT_QUOTES, 'UTF-8') ?>">
            <div class="text-end">
                <button type="button" class="btn btn-light" onclick="openCertificateInsertForm(LoggedUser)">Clear</button>
                <button type="button" class="btn btn-dark" onclick="submitInsertForm(LoggedUser)">Save</button>
            </div>
        </div>
    </form>
</div>