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

<form>
    <div class="row">
        <div class="mb-3 col-6">
            <label for="slipImg" class="form-label">Slip Upload</label>
            <input type="file" class="form-control" id="slipImg" aria-describedby="imgHelp" required name="slipImg"
                accept=".jpg, .jpeg, .png">
            <div id="imgHelp" class="form-text">Only JPG, JPEG, PNG format</div>
        </div>
        <div class="mb-3 col-6">
            <label for="exampleInputPassword1" class="form-label">Reason For Payment</label>
            <select class="form-select" aria-label="Default select example">
                <?php foreach ($paymentReasons as $reason ): ?>
                <option value="<?=$reason['id']?>"><?=$reason['reason']?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class=" row">
        <div class="col-12">
            <div class="mb-3">
                <label for="extraNote" class="form-label">Extra Note</label>
                <textarea class="form-control" name="extraNote" id="extraNote"
                    placeholder="Enter Extra Note"></textarea>
            </div>

        </div>
        <div class="col-6">
            <div class="mb-3">
                <label for="referenceNumber" class="form-label">Reference Number</label>
                <input type="text" class="form-control" id="referenceNumber" required
                    placeholder="Enter Reference Number">
            </div>

        </div>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>