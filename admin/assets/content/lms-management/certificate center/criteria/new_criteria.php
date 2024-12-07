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
?>

<!-- Insert New Criteria Form -->
<div class=" loading-popup-content">
    <div class="row">
        <div class="col-12 w-100 text-end">
            <button class="btn btn-sm btn-dark" onclick="ClosePopUP()"><i class="fa-regular fa-circle-xmark"></i></button>
        </div>
    </div>
    <div class="row g-3">
        <div class="col-md-12">

            <div class="col-12">
                <h3 class="border-bottom pb-2">Add New Criteria</h3>
            </div>

            <form id="order_form" action="" method="post">
                <div class="row">
                    <div class="col-md-7 mb-2">
                        <h6 class="list_name-lable">Criteria Name</h6>
                        <input type="text" class="form-control" id="list_name" name="list_name" required>
                    </div>

                    <div class="col-md-5 mb-2">
                        <h6 class="moq-lable">MOQ</h6>
                        <input type="number" class="form-control" id="moq" name="moq" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <input type="number" hidden class="form-control" id="is_active" name="is_active" required value="1">
                    </div>
                </div>
                <div class="text-end">
                    <button type="button" class="btn btn-light" onclick="AddNewCriteria(LoggedUser)">Clear</button>
                    <button type=" button" class="btn btn-dark" onclick="InsertCriteria()">Save</button>
                </div>

            </form>


        </div>
    </div>
</div>
</div>
</div>