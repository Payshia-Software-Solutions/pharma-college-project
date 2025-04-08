<?php
require __DIR__ . '/../../../../../vendor/autoload.php';
include '../../../../../include/function-update.php';

// Get User Theme
$userThemeInput = isset($_POST['userTheme']) ? $_POST['userTheme'] : null;
$userTheme = getUserTheme($userThemeInput);

// For use env file data
use Dotenv\Dotenv;
use Symfony\Component\HttpClient\HttpClient;

// Load environment variables
$dotenv = Dotenv::createImmutable(dirname(__DIR__, 5));
$dotenv->load();

// Initialize HTTP client
$client = HttpClient::create();

// Fetch certificate order data from API
$response = $client->request('GET', $_ENV["SERVER_URL"] . '/packages/');
$graduationPackages = $response->toArray();
?>
<div class="loading-popup-content-right <?= htmlspecialchars($userTheme) ?>">
    <div class="row">
        <div class="col-6">
            <h3 class="mb-0">Packages</h3>
        </div>

        <div class="col-6 text-end">
            <button class="btn btn-light btn-sm" onclick="ClosePopUPRight(0)" type="button"><i
                    class="fa solid fa-xmark"></i> Cancel</button>

            <button class="btn btn-success btn-sm" onclick="" type="button"><i class="fa solid fa-floppy-disk"></i> Save
                Changes</button>
        </div>

        <div class="col-12">
            <div class="border-bottom border-5 my-2"></div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-12 text-end">
            <button class="btn btn-info" onclick="OpenInactivePackageModal()"><i class="fa fa-pencil-alt"></i> Inactive
                Packages</button>
            <button class="btn btn-dark" onclick="OpenPackageForm()"><i class="fa fa-plus"></i> New Package</button>
        </div>
        <div class="col-12">
            <div class="row g-2">
                <?php foreach ($graduationPackages as $package) :  if ($package['is_active'] == 0) continue;
                ?>
                    <div class="col-6">
                        <div class="card">
                            <div class="card-body">
                                <h4><?= $package['package_name'] ?></h3>
                                    <div class="row g-2">
                                        <div class="col-6 col-md-4">
                                            <div class="rounded-3 p-2 bg-light shadow-none">
                                                <h5>Rate</h5>
                                                <p class="mb-0 fw-bold">LKR <?= $package['price'] ?></p>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-4">
                                            <div class="rounded-3 p-2 bg-light shadow-none">
                                                <h5>Parent Seats</h5>
                                                <p class="mb-0 fw-bold"><?= $package['parent_seat_count'] ?></p>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-4">
                                            <div class="rounded-3 p-2 bg-light shadow-none">
                                                <h5>Garland</h5>
                                                <p class="mb-0 fw-bold"><?= $package['garland'] ?></p>
                                            </div>
                                        </div>
                                        <div class="col-12 text-end">

                                            <button type="button"
                                                onclick="ChangePackageStatus(<?= $package['package_id'] ?>, 0)"
                                                class="btn btn-sm btn-danger"><i class="fa fa-ban"></i>
                                                Inactive</button>
                                            <button type="button" onclick="OpenPackageForm(<?= $package['package_id'] ?>)"
                                                class="btn btn-sm btn-dark"><i class="fa fa-pencil-alt"></i>
                                                Edit</button>

                                        </div>
                                    </div>


                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        </div>

    </div>
</div>