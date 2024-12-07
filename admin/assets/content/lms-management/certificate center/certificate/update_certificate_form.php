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
$certificateId = $_POST['certificateId'];
//print_r($certificateId);

// Fetch and prepare the data
$response1 = $client->request('GET', $_ENV["SERVER_URL"] . '/cc_certificate_list/' . $certificateId);
$certificateData = $response1->toArray();

//print_r($certificateData);

// Fetch criteria groups data
try {
    $response2 = $client->request('GET', $_ENV["SERVER_URL"] . '/cc_criteria_group/');
    $criteriaGroups = json_decode($response2->getContent(), true);  // Use getContent() instead of getBody()
} catch (Exception $e) {
    die('Failed to fetch criteria group data: ' . $e->getMessage());
}

// Fetch criteria groups data
try {
    $response2 = $client->request('GET', $_ENV["SERVER_URL"] . '/cc_criteria_group/' . $certificateData['criteria_group_id']);
    $criteriaSelectedGroup = json_decode($response2->getContent(), true);  // Use getContent() instead of getBody()
} catch (Exception $e) {
    die('Failed to fetch criteria group data: ' . $e->getMessage());
}

//print_r($criteriaSelectedGroup);
$selectedGroupName = $criteriaSelectedGroup['group_name'];
//print_r($selectedGroupName);
?>

<div class="container loading-popup-content">
    <div class="row">
        <div class="col-12 w-100 text-end">
            <button class="btn btn-sm btn-dark" onclick="ClosePopUP()"><i class="fa-regular fa-circle-xmark"></i></button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h3 class="mb-0">Certificate Information</h3>
            <p class="border-bottom pb-2">Please fill the all required fields.</p>

            <form id="UpdateCertificateForm" class="updateCertificate-form">
                <div class="row">
                    <input type="text" hidden id="id" name="id" value="<?= htmlspecialchars($certificateId, ENT_QUOTES, 'UTF-8') ?>">
                    <div class="col-md-5 mb-2">
                        <h6 class="name-label">Certificate Name</h6>
                        <input type="text" class="form-control" id="certificateName" name="list_name" value="<?= htmlspecialchars($certificateData['list_name'], ENT_QUOTES, 'UTF-8') ?>">
                    </div>
                    <div class="col-md-4 mb-2">
                        <h6 class="certificateGroup-label">Criteria Group</h6>
                        <select class="form-control" id="criteriaGroupId" name="criteria_group_id" required>
                            <!-- Add the current group as the pre-selected option -->
                            <option value="<?= htmlspecialchars($certificateData['criteria_group_id'], ENT_QUOTES, 'UTF-8') ?>" selected>
                                <?= htmlspecialchars($selectedGroupName, ENT_QUOTES, 'UTF-8') ?>
                            </option>
                            <!-- List all other groups except the pre-selected one -->
                            <?php foreach ($criteriaGroups as $group): ?>
                                <?php if ($group['id'] != $certificateData['criteria_group_id']): ?>
                                    <option value="<?= htmlspecialchars($group['id'], ENT_QUOTES, 'UTF-8') ?>">
                                        <?= htmlspecialchars($group['group_name'], ENT_QUOTES, 'UTF-8') ?>
                                    </option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-3 mb-2">
                        <h6 class="price-label">Price</h6>
                        <input type="text" class="form-control" id="price" name="price" value="<?= htmlspecialchars($certificateData['price'], ENT_QUOTES, 'UTF-8') ?>">
                    </div>
                    <input type="hidden" id="createdBy" name="created_by" value="<?= htmlspecialchars($LoggedUser, ENT_QUOTES, 'UTF-8') ?>">
                    <div class="text-end">
                        <button type="button" class="btn btn-light" onclick="OpenEditCertificate('<?= htmlspecialchars($LoggedUser, ENT_QUOTES, 'UTF-8') ?>', <?= $certificateId ?>)">Clear</button>
                        <button type="button" class="btn btn-dark" onclick="SubmitCertificateUpdateForm()">Save</button>
                    </div>

                </div>

            </form>
        </div>

    </div>
</div>