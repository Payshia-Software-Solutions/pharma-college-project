<?php

require '../../../vendor/autoload.php';

use Dotenv\Dotenv;
use Symfony\Component\HttpClient\HttpClient;

//for use env file data
$dotenv = Dotenv::createImmutable(__DIR__ . '../../../../');
$dotenv->load();

$client = HttpClient::create();

// Make the GET request to fetch payement reasons
$response = $client->request('GET', $_ENV["SERVER_URL"] .'/payment-reason/');
$paymentReasons = $response->toArray();

?>

<form id="slipPaymentForm" enctype="multipart/form-data">
    <div class="row">
        <div class="mb-3 col-md-6">
            <label for="image" class="form-label">Slip Upload</label>
            <input type="file" class="form-control" id="image" aria-describedby="imgHelp" required name="image"
                accept=".jpg, .jpeg, .png, .pdf">
            <div id="imgHelp" class="form-text">Only JPG, JPEG, PNG, Pdf format</div>
        </div>
        <div class="mb-3 col-md-6">
            <label for="exampleInputPassword1" class="form-label">Reason For Payment</label>
            <select name="reason" class="form-select" aria-label="Default select example">
                <?php foreach ($paymentReasons as $reason ): ?>
                <option value="<?=$reason['id']?>"><?=$reason['reason']?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="row">

        <div class="col-md-6">
            <div class="mb-3">
                <label for="referenceNumber" class="form-label">Reference Number</label>
                <input type="text" class="form-control" id="referenceNumber" name="reference_number" required
                    placeholder="Enter Reference Number">
            </div>

        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="amount" class="form-label">Payment Amount</label>
                <input type="number" class="form-control" id="amount" name="amount" required placeholder="00.00"
                    step="0.01" min="0">
            </div>
        </div>

    </div>
    <div class=" row">
        <div class="col-12">
            <div class="mb-3">
                <label for="extraNote" class="form-label">Extra Note</label>
                <textarea class="form-control" name="extra_note" id="extraNote"
                    placeholder="Enter Extra Note"></textarea>
            </div>

        </div>

    </div>
    <div class="col text-end">
        <button onclick="submitSlip()" type="button" class="btn btn-primary">Submit</button>
    </div>
</form>