<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../../include/configuration.php';
include '../../php_handler/function_handler.php';

// Include Classes
include_once './Classes/Database.php';

$config_file = '../../include/env.txt';
$database = new Database($config_file);
$db = $database->getConnection();

$userLevel = $_POST['UserLevel'];
$loggedUser = $_POST['LoggedUser'];
$courseCode = $_POST['CourseCode']; ?>

<div class="row mt-2 mb-5">
    <div class="col-12 mt-3">
        <div class="card mt-5 border-0">
            <div class="card-body">
                <div class="quiz-img-box sha">
                    <img src="./lib/appointments/assets/images/appointment.gif" class="quiz-img shadow rounded-4">
                </div>
                <h1 class="card-title text-center mt-2 fw-bold bg-light p-3 rounded-5 mb-0">Appointments</h1>
            </div>
        </div>
    </div>
</div>
<div class="row ">
    <div class="col-12 col-md-6 offset-md-3 d-flex items-center">
        <img src="./lib/appointments/assets/images/get-started.jpg" class="w-100" alt="">
    </div>
    <div class="col-12 col-md-6 offset-md-3">
        <button onclick="GetStared()" class="btn btn-primary btn-lg w-100 mb-2"><i class="fa-solid fa-arrow-right"></i> Get Stared</button>
        <button class="btn btn-dark btn-lg w-100"><i class="fa-solid fa-bookmark"></i> Book Now</button>
    </div>
</div>