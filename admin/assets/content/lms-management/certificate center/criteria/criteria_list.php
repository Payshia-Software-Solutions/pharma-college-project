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

// Fetch and prepare the data
$response1 = $client->request('GET', $_ENV["SERVER_URL"] . '/cc_criteria_list/');
$criteriaData = $response1->toArray();

?>

<!-- HTML Table -->
<div class="card shadow-lg p-3 mb-5">
    <div class="card-body">
        <div class="row mb-0">
            <div class="col-12 d-flex justify-content-end">
                <button type="button"
                    onclick="AddNewCriteria('<?= htmlspecialchars($LoggedUser, ENT_QUOTES) ?>')"
                    class="btn btn-dark">
                    <i class="fa-solid fa-plus"></i> Add New Criteria
                </button>
            </div>
        </div>
        <div class="container" id="insertFormContainer">
            <div class="row">
                <div class="row g-3">
                    <div class="col-md-12">
                        <div class="col-12">
                            <h5 class="table-title">Criteria List</h5>
                        </div>

                        <div class="table-responsive">
                            <table class="table" id="criteria-list-table">
                                <thead>
                                    <tr>
                                        <th>Criteria Name</th>
                                        <th>MOQ</th>
                                        <th>Active</th>
                                        <th>Status</th>
                                        <th>Action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($criteriaData as $criteria): ?>
                                        <tr> <!-- Add opening <tr> tag here -->
                                            <td><?= htmlspecialchars($criteria["list_name"], ENT_QUOTES) ?></td>
                                            <td><?= htmlspecialchars($criteria["moq"], ENT_QUOTES) ?></td>
                                            <td><?= htmlspecialchars($criteria["is_active"], ENT_QUOTES) ?></td>
                                            <td> <span class="badge <?= $criteria['is_active'] ? 'bg-success' : 'bg-danger' ?>">
                                                    <?= $criteria['is_active'] ? 'Active' : 'Inactive' ?>
                                                </span></td>
                                            <td><button
                                                    onclick="OpenEditCriteria('<?= htmlspecialchars($LoggedUser, ENT_QUOTES) ?>', <?= $criteria['id'] ?>)" class="btn btn-dark btn-sm"
                                                    type="button">
                                                    <i class="fa fa-edit"></i> Update
                                                </button>
                                                <button
                                                    class="btn btn-sm <?= $criteria['is_active'] ? 'btn-secondary' : 'btn-primary' ?>"
                                                    type="button"
                                                    onclick="changeCriteriaStatus(<?= $criteria['id'] ?>, <?= $criteria['is_active'] ? 0 : 1 ?>)">
                                                    <i class="fa-solid <?= $criteria['is_active'] ? 'fa-ban' : 'fa-check' ?>"></i>
                                                    <?= $criteria['is_active'] ? 'Disable' : 'Activate' ?>
                                                </button>
                                            </td>
                                        </tr> <!-- Add closing </tr> tag here -->
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>