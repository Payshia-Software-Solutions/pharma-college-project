<?php
require '../../vendor/autoload.php';

use Symfony\Component\HttpClient\HttpClient;

$client = HttpClient::create();

//for use env file data
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

$LoggedUser = $_POST['LoggedUser'];
// Making a GET request
$response = $client->request('GET', $_ENV["SERVER_URL"] . '/cc_certificate_list/');
$response2 = $client->request('GET', $_ENV["SERVER_URL"] . '/cc_certificate_order/by-user/' . $LoggedUser);

// Get the response body as an array (if it's JSON)
$certificateList = $response->toArray();
$orderedCertificate = $response2->toArray();
?>

<div class="row mt-2 mb-5">
    <div class="col-12 mt-3">
        <div class="card shadow mt-5 border-0">
            <div class="card-body">
                <div class="certificate-img-box sha">
                    <img src="./lib/certificate-center/assets/images/certificate.gif"
                        class="certificate-img shadow rounded-4">
                </div>
                <h1 class="card-title text-center mt-2 fw-bold bg-light p-3 rounded-5 mb-0">Certificate Center</h1>
            </div>
        </div>
    </div>
</div>



<div id="pageContent">
    <div class="row">
        <div class="col-12 d-flex justify-content-end mb-3">
            <button onclick="OpenIndex()" type="button" class="btn btn-warning btn-sm">Reload</button>
        </div>
    </div>
    <div class="row g-3">
        <?php if ($orderedCertificate) : ?>
            <div class="col-md-6">
            <?php else : ?>
                <div class="col-12"></div>
            <?php endif ?>
            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-body">


                    <div class="text-center">
                        <h3 class="p-2 fw-bold">Order a Certificate</h3>
                    </div>

                    <div class="row">

                        <?php foreach ($certificateList as $certificate) :

                            $isOrdered = false; // Initialize a flag

                            foreach ($orderedCertificate as $certificateOrder) {
                                if ($certificateOrder['certificate_id'] == $certificate['id']) {
                                    $isOrdered = true; // Set flag to true if a match is found
                                    break; // Exit the inner loop since a match is found
                                }
                            }

                            if ($isOrdered) {
                                continue; // Skip this certificate if it is already ordered
                            } ?>
                            <div class="col-md-6 d-flex mt-2">
                                <div class="card rounded-1 clickable knowledge-card flex-fill" onclick="OpenCertificate('<?= $certificate['id'] ?>')">
                                    <div class="card-body">
                                        <h4 class="mb-0 knowledge-title"
                                            style="--bg-color:#797bba;">>
                                            <span class="rectangle"></span>
                                            <i class="fa-solid fa-graduation-cap"></i>
                                        </h4>
                                        <p class="mb-0 text-muted"><?= $certificate['list_name'] ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach ?>
                    </div>

                </div>
            </div>

            <div class="border-bottom my-4"></div>
            </div>

            <!-- only show if had order -->
            <?php if ($orderedCertificate) : ?>
                <div class="col">
                    <div class="card border-0 shadow-lg rounded-4">
                        <div class="card-body">

                            <div class="text-center">
                                <h3 class="p-2 fw-bold">Ongoing Orders</h3>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Certificate</th>
                                                <th scope="col">Order Date</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($orderedCertificate as $certificate) : ?>
                                                <tr>
                                                    <td><?= $certificate['certificate_name'] ?></td>
                                                    <td><?= $certificate['created_at'] ?></td>
                                                    <td>
                                                        <?php
                                                        $buttonClass = ($certificate['certificate_status'] === 'Printed') ? 'btn-success' : 'btn-danger';
                                                        $buttonText = ($certificate['certificate_status'] === 'Printed') ? 'Printed' : 'Pending';
                                                        ?>
                                                        <button class="btn btn-sm <?= $buttonClass ?>" disabled><?= $buttonText ?></button>
                                                    </td>
                                                    <td>
                                                        <button onclick="OpenPaymentView('<?= $certificate['id'] ?>','<?= $certificate['certificate_name'] ?>')" class="btn btn-primary btn-sm"
                                                            type="button"><i class="fa-solid fa-eye"></i>
                                                            View</button>
                                                    </td>
                                                </tr>
                                            <?php endforeach ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="border-bottom my-4"></div>
                </div>
            <?php endif ?>
    </div>
</div>