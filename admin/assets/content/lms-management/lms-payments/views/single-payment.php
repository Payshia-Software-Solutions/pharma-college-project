<?php

$LoggedUser = $_POST['LoggedUser'];
$paymentId = $_POST['paymentId'];

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

        <div class="col-md-8">

            <!-- Preview Submitted File -->
            <img class="rounded-4 shadow-sm w-100" id="myImage" src="https://i.imghippo.com/files/y6gtF1729483242.jpg"
                alt="image 01">

            <!-- Download Button -->
            <a class="d-block text-center mb-3" target="_blank" href="https://i.imghippo.com/files/y6gtF1729483242.jpg">
                <button class="btn btn-warning rounded-2 mt-3 w-50">Download Slip</button>
            </a>

        </div>

        <div class="col-md-4">
            <h5 class="">Payment ID 588</h5>

            <form id="grade-form" method="post">
                <!-- <h4 class="card-title border-bottom pb-2 mb-2">Grading</h4> -->
                <div class="row g-2">

                    <div class="col-12">
                        <label>Current Payment Status: </label>
                        <?php if (true) : ?>
                        <div class="badge bg-warning rounded-2">Pending</div>
                        <!-- <div class="badge bg-success rounded-2">10%</div> -->
                        <?php else : ?>
                        <div class="badge bg-danger rounded-2">Not Graded</div>
                        <?php endif ?>
                    </div>

                    <div class="col-12">
                        <label>Student Name</label>
                        <input readonly type="text" value="Class Fee" name="student_name"
                            class="form-control form-control-sm" placeholder="Dasun Kumara">
                    </div>

                    <div class="col-12">
                        <label>Reason</label>
                        <input readonly type="text" name="reason" class="form-control form-control-sm"
                            placeholder="Course Fee">
                    </div>

                    <div class="col-12">
                        <label>Ref. No</label>
                        <input readonly type="text" name="ref_no" class="form-control form-control-sm"
                            placeholder="REf-25785787">
                    </div>
                    <div class="col-12">
                        <label>Uploaded Date</label>
                        <input readonly type="text" name="uploaded_date" class="form-control form-control-sm"
                            placeholder="2024-10-12">
                    </div>

                    <div class="col-12">
                        <label>Extra Note</label>
                        <textarea readonly type="text" name="extra_note" class="form-control form-control-sm">this is my first payment
                        </textarea>
                    </div>

                    <div class="col-md-6">
                        <label>Payment Amount</label>
                        <input name="grade" id="grade" type="number" class="form-control form-control-sm"
                            placeholder="0.00" required value="">
                    </div>

                    <div class="col-md-6">
                        <label>Discount</label>
                        <input name="grade" id="grade" type="number" class="form-control form-control-sm"
                            placeholder="0.00" required value="">
                    </div>

                    <div class="col-12 text-end mt-3 d-flex">
                        <button type="button" class="btn btn-lg btn-dark rounded-2 text-white flex-fill w-100"
                            onclick="SavePayment() "><i class="fa-solid fa-floppy-disk"></i> Save Payment</button>
                    </div>

                </div>
            </form>




        </div>
    </div>
</div>