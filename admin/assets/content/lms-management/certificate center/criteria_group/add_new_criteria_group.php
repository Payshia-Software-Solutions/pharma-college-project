<?php
require_once('../../../../../include/config.php');
include '../../../../../include/function-update.php';
include '../../../../../include/lms-functions.php';
require __DIR__ . '/../../../../../vendor/autoload.php';

use Dotenv\Dotenv;
use Symfony\Component\HttpClient\HttpClient;

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Load environment variables
$dotenv = Dotenv::createImmutable(dirname(__DIR__, 5)); // Go up 5 directories
$dotenv->load();

// Create the HttpClient
$client = HttpClient::create();

// Fetch and prepare the data
$response = $client->request('GET', $_ENV["SERVER_URL"] . '/cc_criteria_list/');
$criteriaList = $response->toArray();

// if ($result && $result->num_rows > 0) {
//     while ($row = $result->fetch_assoc()) {
//         $criteriaList[] = $row;
//     }
// }

?>
<div class="loading-popup-content">
    <div class="row">
        <div class="col-12 w-100 text-end">
            <button class="btn btn-sm btn-dark" onclick="ClosePopUP()"><i class="fa-regular fa-circle-xmark"></i></button>
        </div>
    </div>
    <h3 class="border-bottom pb-2">Add New Criteria Group</h3>

    <!-- Display success or error messages -->
    <?php if (!empty($success_message)): ?>
        <div class="alert alert-success"><?= $success_message ?></div>
    <?php elseif (!empty($error_message)): ?>
        <div class="alert alert-danger"><?= $error_message ?></div>
    <?php endif; ?>

    <form method="POST" action="" id="criteriaGroupInsertForm">
        <div class="mb-3">
            <h6 class="criteriaGroupName-label">Criteria Group Name</h6>
            <input type="text" class="form-control" id="group_name" name="group_name" required>
            <div class="invalid-feedback">Group Name is required.</div>
        </div>
        <div class="mb-3">
            <h6 class="criteria_group-label">Select Criteria</h6>
            <div id="criteria_group" class="row g-3"> <!-- Use Bootstrap's grid system -->
                <?php foreach ($criteriaList as $criteria): ?>
                    <div class="col-12 col-md-6 col-lg-4"> <!-- Adjust column size per screen -->
                        <div class="form-check">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                id="criteria_<?= $criteria['id'] ?>"
                                name="criteria_group[]"
                                value="<?= $criteria['id'] ?>"> <!-- Use ID as the value -->
                            <label class="form-check-label" for="criteria_<?= $criteria['id'] ?>">
                                <?= htmlspecialchars($criteria['list_name'], ENT_QUOTES, 'UTF-8') ?>
                            </label>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="invalid-feedback">At least one criteria must be selected.</div>
        </div>


        <!--created_by and is_active fields-->
        <input type="text" class="form-control" id="created_by" name="created_by" value="$LoggedUser" hidden>
        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" hidden>

        <!-- <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" id="is_active" name="is_active">
            <label class="form-check-label" for="is_active">Active</label>
        </div> -->

        <div class="text-end">
            <button type="button" class="btn btn-light" onclick="AddNewCriteriaGroup(LoggedUser)">Clear</button>
            <button type="submit" class="btn btn-dark" onclick="submitCriteriaGroupInsertForm()">Save</button>
        </div>
    </form>
</div>