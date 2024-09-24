<?php

require '../../../vendor/autoload.php';

use Symfony\Component\HttpClient\HttpClient;

$client = HttpClient::create();

$lectueId = $_POST['lecture_id'];
$LoggedUser = $_POST['LoggedUser'];
$date = $_POST['date'];
$time = $_POST['time'];
$reason = $_POST['reason'];
$category = $_POST['category'];


$response = $client->request('GET', 'http://localhost:8000/userFullDetails/' . $lectueId);

$lectures = $response->toArray();
$name = $lectures['first_name'] . " " . $lectures['last_name'];
$address = $lectures['address_line_1'] . ", " . $lectures['address_line_2'] . ", " . $lectures['city'];

?>


<style>
.back-btn {
    background-color: transparent;
    border: 0;
    color: #333333;
    width: 18px;
    height: 8px;
}

.card {
    border-raduis: 8px;
    background-color: #EBEBEB;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    width: 90%;
    height: auto;
}

.sub-card {
    /* padding: 15px; */
    border-radius: 8px;
    background-color: #ffffff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    width: 90%;
    /* height: 160px; */
}

.doc-img {
    width: 71px;
    height: 68px;
    border-radius: 4px;
}

.doc-name {
    font-family: 'Rubik', sans-serif;
    font-weight: 500;
    font-size: 16px;
    color: #333333;
    margin-left: 10px;
}

.adress {
    font-family: 'Rubik', sans-serif;
    font-weight: 300;
    font-size: 12px;
    color: #677294;
    margin-left: 10px;
}

.specialist {
    font-family: 'PT Sans', sans-serif;
    font-weight: 400;
    font-size: 13px;
    color: #0EBE7F;
}

.experience {
    font-family: 'Rubik', sans-serif;
    font-weight: 300;
    font-size: 12px;
    color: #677294;
}

.status-container {
    display: flex;
    align-items: center;
}

.status-dot {
    width: 10px;
    height: 10px;
    background-color: #0EBE7F;
    /* Green color */
    border-radius: 50%;
    margin-right: 8px;
}

.status-text {
    font-family: 'Rubik', sans-serif;
    font-size: 11px;
    font-weight: 300;
    color: #677294;
}

.available {
    font-family: 'Rubik', sans-serif;
    font-size: 13px;
    font-weight: 500;
    color: #0EBE7F;

}

.available-time {
    font-family: 'Rubik', sans-serif;
    font-size: 12px;
    font-weight: 300;
    color: #677294;

}

.book-btn {
    width: 116px;
    height: 35px;
    background-color: #0EBE7F;
    color: #FFFFFF;
    border: 1px solid #0EBE7F;
    border-radius: 4px;
    /* padding: 10px 20px 10px 20px; */
    font-size: 15px;
    font-weight: 600;
}

.checked {
    color: orange;
}

.fa-star {
    width: 9px;
    height: 9px;
    margin-right: 10px;
}

.fa-heart {
    width: 15px;
    height: 13px;
}

.start-container {
    margin-left: 10px;
}

.appointment-date {
    font-family: 'Rubik', sans-serif;
    font-weight: 500;
    font-size: 16px;
    color: #222222;
}

.slot-text {
    font-family: 'Rubik', sans-serif;
    font-weight: 400;
    font-size: 14px;
    color: #677294;
}

.session-div {
    width: 90%;
    height: 49px;
    border-radius: 6px;
    background-color: #0EBE7F;
}

.lesson-div {
    width: 90%;
    height: 49px;
    border-radius: 6px;
    border: 1px solid #0EBE7F80;
    background-color: #FFFFFF;
    color: #0EBE7F;
}

.confirm-btn {
    width: 90%;
    height: 52px;
    border: 1px solid #CBCBCB;
    border-radius: 10px;
    padding: 13px 20px 13px 20px;
    background-color: #0EBE7F;
    color: #ffffff;
    font-size: 17px;
    font-weight: 600;
}

body {
    font-family: 'Arial', sans-serif;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background-color: #f4f4f9;
}

.appointment-card {
    width: 350px;
    padding: 20px;
    background-color: white;
    border-radius: 12px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    text-align: center;
}

.icon-container {
    background-color: #E6FAF0;
    width: 80px;
    height: 80px;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 0 auto;
}

.thumbs-up-icon {
    color: #0EBE7F;
    font-size: 40px;
}

.thank-you {
    font-size: 24px;
    font-weight: bold;
    color: #333333;
    margin: 20px 0 10px;
}

.subtext {
    font-size: 16px;
    color: #677294;
    margin-bottom: 20px;
}

.appointment-details {
    font-size: 14px;
    color: #677294;
    margin-bottom: 30px;
}

.done-btn {
    background-color: #0EBE7F;
    color: white;
    font-size: 16px;
    font-weight: bold;
    border: none;
    border-radius: 8px;
    padding: 12px 0;
    width: 100%;
    cursor: pointer;
}

.done-btn:hover {
    background-color: #0aa06c;
}


.fix-bottom {
    height: 20px;
}
</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<div class="container-fluid">
    <!-- back btn section -->
    <div class="row row-one mb-3" onclick="goToAppointments()">
        <div class="col-12 p-4 d-flex justify-content-start">
            <button onclick="" class="back-btn"><i class="fa-solid fa-less-than"></i></button>
        </div>
    </div>

    <!-- image section -->
    <div class="row row-two">
        <div class="col-12 p-0">
            <!-- card start -->

            <div hidden class="data-container">
                <span id="LectueId"><?= $lectueId; ?></span>
                <span id="loggedUser"><?= $LoggedUser; ?></span>
                <span id="appointmentDate"><?= $date; ?></span>
                <span id="appointmentCategory"><?= $category; ?></span>
                <span id="appointmentReason"><?= $reason; ?></span>
                <span id="appointmentTime"><?= $time; ?></span>

            </div>

            <div class="col mb-3 card p-1 mx-auto">

                <div class="sub-card mt-3 mx-auto p-2 d-flex justify-content-between">
                    <div class="col-11">
                        <div class="row">
                            <div class="col-3">
                                <img class="doc-img" src="./assets/images/doctor.png" alt="">
                            </div>
                            <div class="col d-flex justify-content-start">
                                <div class="row">

                                    <h6 class="doc-name mt-2 mb-0 pb-0">
                                        <?php echo $name; ?>
                                    </h6>


                                    <p class="adress pb-0 mb-0"><?php echo $address; ?></p>

                                    <div class="start-container">
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star"></span>
                                        <span class="fa fa-star"></span>
                                    </div>

                                </div>

                            </div>
                        </div>

                    </div>
                    <div class="col">
                        <i class="fa-solid fa-heart" style="color: red;"></i>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <h4 class="appointment-date">Appointment Date</h4>
                    <p class="slot-text mt-3">Slot Available</p>

                    <button class="session-div text-light mt-4">Session on wed 24 feb</button>
                    <button class="lesson-div mt-3 mb-3">Lesson</button>
                </div>


            </div>

            <!-- card end -->
            <div class="text-center">
                <button onclick="submitAppointment()" class="confirm-btn mt-2">Confirm
                    Appointment</button>
            </div>
        </div>
    </div>

    <!-- succuss pop up -->

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="appointment-card">
                <div class="icon-container">
                    <i class="fa fa-thumbs-up thumbs-up-icon"></i>
                </div>
                <h1 class="thank-you">Thank You!</h1>
                <p class="subtext">Your Appointment Successful</p>
                <p class="appointment-details">
                    You booked an appointment with <strong>Dr. Pediatrician Purpieson</strong> on February 21, at
                    02:00 PM
                </p>
                <button onclick="closeModal" type="button" data-bs-dismiss="modal" class="done-btn">Done</button>
            </div>

        </div>
    </div>

</div>
<!-- Fix-bottom should be after the foreach loop ends -->
<div class="fix-bottom"></div>