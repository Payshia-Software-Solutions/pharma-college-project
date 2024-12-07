<?php
require_once('../../../../../include/config.php');
require __DIR__ . '/../../../../../vendor/autoload.php';

use Dotenv\Dotenv;
use Symfony\Component\HttpClient\HttpClient;

// Load environment variables
$dotenv = Dotenv::createImmutable(dirname(__DIR__, 5));
$dotenv->load();

$client = HttpClient::create();
$criteriaGroupId = filter_input(INPUT_POST, 'criteriaGroupId', FILTER_SANITIZE_NUMBER_INT);

// Fetch criteria group data
try {
    $response = $client->request('GET', $_ENV['SERVER_URL'] . '/cc_criteria_group/' . $criteriaGroupId);
    if ($response->getStatusCode() !== 200) {
        throw new Exception('Failed to fetch criteria group. [Error Code: E001]');
    }
    $criteriaGroup = $response->toArray();
} catch (Exception $e) {
    error_log("[E001] Fetch Criteria Group Error: " . $e->getMessage());
    echo "<div class='alert alert-danger'>Error: Unable to load criteria group. Please try again later. [Error Code: E001]</div>";
    exit;
}

// Fetch criteria list
try {
    $response = $client->request('GET', $_ENV['SERVER_URL'] . '/cc_criteria_list/');
    if ($response->getStatusCode() !== 200) {
        throw new Exception('Failed to fetch criteria list. [Error Code: E002]');
    }
    $criteriaList = $response->toArray();
} catch (Exception $e) {
    error_log("[E002] Fetch Criteria List Error: " . $e->getMessage());
    echo "<div class='alert alert-danger'>Error: Unable to load criteria list. Please try again later. [Error Code: E002]</div>";
    exit;
}
?>

<div class="loading-popup-content" id="content-container">
    <div class="row">
        <div class="col-12 w-100 text-end">
            <button class="btn btn-sm btn-dark" onclick="ClosePopUP()"><i class="fa-regular fa-circle-xmark"></i></button>
        </div>
    </div>
    <h3 class="border-bottom pb-2">Criteria Group Details</h3>

    <form method="POST" action="open_criteria_group.php" id="OpenCriteriaGroupForm">
        <input type="hidden" name="criteria_group_id" value="<?= htmlspecialchars($criteriaGroup['id'], ENT_QUOTES, 'UTF-8') ?>">

        <div class="mb-3">
            <h6 class="group_name-lable">Group Name</h6>
            <input
                readonly
                type="text"
                class="form-control"
                id="group_name"
                name="group_name"
                value="<?= htmlspecialchars($criteriaGroup['group_name'], ENT_QUOTES, 'UTF-8') ?>"
                required>
        </div>

        <div class="mb-3">
            <h6 class="selected_criteria-lable">Selected Criterias</h6>
            <div id="criteria_group" class="row g-3">
                <?php
                $selectedCriteria = json_decode($criteriaGroup['criteria_group'], true) ?? [];
                foreach ($criteriaList as $criteria) {
                    $isSelected = in_array($criteria['id'], $selectedCriteria);
                ?>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-check">
                            <input
                                readonly
                                class="form-check-input"
                                type="checkbox"
                                id="criteria_<?= $criteria['id'] ?>"
                                name="criteria_group[]"
                                value="<?= $criteria['id'] ?>"
                                <?= $isSelected ? 'checked' : '' ?>>
                            <label class="form-check-label" for="criteria_<?= $criteria['id'] ?>">
                                <?= htmlspecialchars($criteria['list_name'], ENT_QUOTES, 'UTF-8') ?>
                            </label>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </form>
</div>