<?php

// Get User Theme
// $userThemeInput = isset($_POST['userTheme']) ? $_POST['userTheme'] : null;
// $UserLevel = isset($_POST['UserLevel']) ? $_POST['UserLevel'] : 'Officer';
// $userTheme = getUserTheme($userThemeInput);



$LoggedUser = $_POST['LoggedUser'];

?>


<div class="loading-popup-content-right <?= htmlspecialchars($userTheme) ?> ">
    <div class="row">
        <div class="col-6">
            <h3 class="mb-0">Submission Details</h3>
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
            <a class="d-block" target="_blank" href="https://i.imghippo.com/files/y6gtF1729483242.jpg">
                <button class="btn btn-warning rounded-2 mt-3">Download</button>
            </a>



        </div>

        <div class="col-md-4">
            <h5 class="">Submission for sdsd of
                sdsd</h5>

            <form id="grade-form" method="post">
                <h4 class="card-title border-bottom pb-2 mb-2">Grading</h4>
                <div class="row g-2">

                    <div class="col-12">
                        <label>Current Grade Status: </label>
                        <?php if (true) : ?>
                        <div class="badge bg-primary rounded-2">test</div>
                        <div class="badge bg-success rounded-2">10%</div>
                        <?php else : ?>
                        <div class="badge bg-danger rounded-2">Not Graded</div>
                        <?php endif ?>
                    </div>


                    <div class="col-md-6">
                        <label>Grade Value %</label>
                        <input name="grade" id="grade" type="number" class="form-control form-control-sm"
                            placeholder="85%" required value="fffsdf">
                    </div>

                    <div class="col-md-12">
                        <label>Common Reason</label>
                        <select class="form-control" id="pre-reason" name="pre-reason">
                            <option value="">Select Common Reason</option>
                        </select>

                    </div>

                    <div class="col-md-12">
                        <label>Reason</label>
                        <input name="reason" id="reason" type="text" class="form-control form-control-sm"
                            placeholder="Reason" value="dfdfsdfsdf">
                    </div>
                    <div class="col-6 text-end mt-3 d-flex">
                        <button onclick="ViewResource()" type="button" class="btn btn-success btn-lg w-100 flex-fill"><i
                                class="fa-solid fa-eye"></i> View
                            Resource</button>
                    </div>

                    <div class="col-6 text-end mt-3 d-flex">
                        <button type="button" class="btn btn-lg btn-dark rounded-2 text-white flex-fill w-100"
                            onclick="SaveGrade() "><i class="fa-solid fa-floppy-disk"></i> Save Grade</button>
                    </div>

                </div>
            </form>




        </div>
    </div>
</div>