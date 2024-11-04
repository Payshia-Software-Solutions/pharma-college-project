<?php

require_once '../../../../../vendor/autoload.php';
use Symfony\Component\HttpClient\HttpClient;

$paymentId = $_POST['paymentId'];
$LoggedUser = $_POST['LoggedUser'];
$courseCode = $_POST['courseCode'];
$contentURL = 'https://content-provider.pharmacollege.lk/content-provider/payments/payment-slips/' . $LoggedUser . '/';

$dotenv = Dotenv\Dotenv::createImmutable('../../../../../');
$dotenv->load();

$client = HttpClient::create();
$response = $client->request('GET', $_ENV["SERVER_URL"] .'/payment-request/getById/' . $paymentId);
$paymentDetails = $response->toArray();

//only show date
$uploadedDate = date('d-m-Y', strtotime($paymentDetails['created_at']));

// get file extension 
$extension = pathinfo($paymentDetails['image'], PATHINFO_EXTENSION);
if (strtolower($extension) == 'pdf') {
    $pdfViewer = true;
}else{
    $pdfViewer = false;
}

?>


<div class="loading-popup-content-right <?= htmlspecialchars($userTheme) ?> ">
    <div class="row">
        <div class="col-6">
            <h3 class="mb-0">Payment Details</h3>
        </div>
        <div class="col-6 text-end">
            <button class="btn btn-dark btn-sm" onclick="OpenSubmission()" type="button"><i
                    class="fa solid fa-rotate-left"></i> Reload</button>
            <button class="btn btn-light btn-sm" onclick="ClosePopUPRight(1)" type="button"><i
                    class="fa solid fa-xmark"></i> Close</button>
        </div>
        <div class="col-12">
            <div class="border-bottom border-5 my-2"></div>
        </div>
    </div>

    <div class="row g-3">

        <div class="col-md-6">

            <!-- Preview Submitted File -->
            <?php if ($pdfViewer) : ?>
            <iframe src="<?= $contentURL . $paymentDetails['image'] ?>" width="100%" height="400px"></iframe>
            <?php else : ?>
            <img class="rounded-4 shadow-sm w-100" id="myImage" src="<?= $contentURL . $paymentDetails['image'] ?>"
                alt="image 01">
            <?php endif ?>

            <!-- Download Button -->
            <a class="d-block text-center mb-3" target="_blank" href="<?= $contentURL . $paymentDetails['image'] ?>">
                <button class="btn btn-warning rounded-2 mt-3 w-50">Download Slip</button>
            </a>

        </div>

        <div class="col-md-6">
            <h5 class="">Payment ID <?= $paymentId ?></h5>

            <form id="approvePaymentForm" enctype="multipart/form-data">
                <!-- <h4 class="card-title border-bottom pb-2 mb-2">Grading</h4> -->
                <div class="row g-2">

                    <div class="col-12">
                        <label>Current Payment Status: </label>
                        <?php if ($paymentDetails['status'] == 0) : ?>
                        <div class="badge bg-warning rounded-2">Pending</div>
                        <?php else : ?>
                        <div class="badge bg-success rounded-2">Approved</div>
                        <?php endif ?>
                    </div>

                    <div class="col-12">
                        <label>Student Name</label>
                        <input readonly type="text" name="student_name" class="form-control form-control-sm"
                            value="<?= $paymentDetails['created_by'] ?>">
                    </div>

                    <div class="col-12">
                        <label>Reason</label>
                        <input readonly type="text" name="reason" class="form-control form-control-sm"
                            value="<?= $paymentDetails['reason'] ?>">
                    </div>

                    <div class="col-12">
                        <label>Ref. No</label>
                        <input readonly type="text" class="form-control form-control-sm"
                            value="<?= $paymentDetails['reference_number'] ?>">
                    </div>
                    <div class="col-12">
                        <label>Uploaded Date</label>
                        <input readonly type="text" class="form-control form-control-sm" name="uploaded_date"
                            value="<?= $uploadedDate ?>">
                    </div>

                    <div class="col-12">
                        <label>Extra Note</label>
                        <textarea readonly type="text" name="extra_note"
                            class="form-control form-control-sm"><?= $paymentDetails['extra_note'] ?></textarea>
                    </div>


                    <div class="col-md-6">
                        <label>Payment Amount</label>
                        <input name="paid_amount" type="number" class="form-control form-control-sm" placeholder="0.00"
                            required value="<?= $paymentDetails['amount'] ?>">
                    </div>
                    <div class="col-md-6">
                        <label>Select A Payment Type</label>
                        <select name="payment_type" class="form-control form-control-sm" required>
                            <option value="Cash">Cash</option>
                            <option value="Bank Transfer">Bank Transfer</option>
                            <option value="Online Payment">Online Payment</option>
                        </select>
                    </div>


                    <div class="col-12 text-end mt-3 d-flex">
                        <button type="button" class="btn btn-lg btn-dark rounded-2 text-white flex-fill w-100"
                            onclick="SavePayment(<?= $paymentId ?>, '<?= $courseCode ?>')"><i
                                class="fa-solid fa-floppy-disk"></i> Save
                            Payment</button>
                    </div>

                </div>
            </form>




        </div>
    </div>
</div>