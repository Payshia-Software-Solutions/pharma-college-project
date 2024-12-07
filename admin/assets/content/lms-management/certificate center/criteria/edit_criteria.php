<?php
require_once('../../../../../include/config.php');
require __DIR__ . '/../../../../../vendor/autoload.php';

use Dotenv\Dotenv;
use Symfony\Component\HttpClient\HttpClient;

// Load environment variables
$dotenv = Dotenv::createImmutable(dirname(__DIR__, 5));
$dotenv->load();

$client = HttpClient::create();

// Retrieve POST data
$LoggedUser = $_POST['LoggedUser'] ?? 'Guest';
$criteriaId = $_POST['criteriaId'] ?? null;

// Fetch criteria details
$criteriaDetails = [];
if ($criteriaId) {
    $response = $client->request('GET', $_ENV["SERVER_URL"] . "/cc_criteria_list/$criteriaId");
    $criteriaDetails = $response->toArray();
}

?>

<!-- HTML for Editing Criteria -->
<div class="loading-popup-content">
    <div class="row">
        <div class="col-12 w-100 text-end">
            <button class="btn btn-sm btn-dark" onclick="ClosePopUP()"><i class="fa-regular fa-circle-xmark"></i></button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h3 class="border-bottom pb-2">Edit Criteria</h3>
            <form id="update-form" action="" method="post">
                <div class="row">
                    <div class="col-md-7 mb-2">
                        <h6 class="list-label">Criteria Name</h6>
                        <input type="text" class="form-control" id="list_name" name="list_name"
                            value="<?= htmlspecialchars($criteriaDetails['list_name'] ?? '', ENT_QUOTES) ?>" required>
                    </div>

                    <div class="col-md-5 mb-2">
                        <h6 class="moq-label">MOQ</h6>
                        <input type="number" class="form-control" id="moq" name="moq"
                            value="<?= htmlspecialchars($criteriaDetails['moq'] ?? '', ENT_QUOTES) ?>" required>
                    </div>
                </div>

                <input type="hidden" id="criteria_id" name="criteria_id" value="<?= htmlspecialchars($criteriaId, ENT_QUOTES) ?>">


                <input type="number" class="form-control" id="is_active" name="is_active"
                    value="1" hidden>

                <div class="text-end">
                    <!-- Example: A button to trigger the Update function -->
                    <button type="button" class="btn btn-light" onclick="OpenEditCriteria('<?= $LoggedUser ?>', '<?= $criteriaDetails['id'] ?>')">Clear</button>
                    <button type="button" class="btn btn-dark" onclick="UpdateCriteria(<?= $criteriaId ?>)">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
</div>