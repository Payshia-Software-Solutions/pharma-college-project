<!-- <?php
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
</div> -->

<?php
// Define an array of doctors
$doctors = [
    [
        'name' => 'Dr. Hamza Tariq',
        'title' => 'Senior Surgeon',
        'hours' => '10:30 AM - 3:30 PM',
        'fee' => '$12',
        'image' => './assets/images/doctor.jpg'
    ],
    [
      'name' => 'Dr. Hamza Tariq',
      'title' => 'Senior Surgeon',
      'hours' => '10:30 AM - 3:30 PM',
      'fee' => '$12',
      'image' => './assets/images/doctor.jpg'
    ],
  [
    'name' => 'Dr. Hamza Tariq',
    'title' => 'Senior Surgeon',
    'hours' => '10:30 AM - 3:30 PM',
    'fee' => '$12',
    'image' => './assets/images/doctor.jpg'
   ],
    [
      'name' => 'Dr. Hamza Tariq',
      'title' => 'Senior Surgeon',
      'hours' => '10:30 AM - 3:30 PM',
      'fee' => '$12',
      'image' => './assets/images/doctor.jpg'
    ],
    [
      'name' => 'Dr. Hamza Tariq',
      'title' => 'Senior Surgeon',
      'hours' => '10:30 AM - 3:30 PM',
      'fee' => '$12',
      'image' => './assets/images/doctor.jpg'
    ],
    // Add more doctors as needed
];
?>

<head>

    <style>
    .search-bar {
        margin-top: 20px;
    }

    .top-header {
        top: 0;
        left: 0;
        right: 0;
        z-index: 1000;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
    }
    </style>
</head>

<div class="">
    <!-- Schedule Header (Fixed to Top) -->
    <div class="bg-success p-3 position-fixed w-100" style="top: 0; z-index: 999;">
        <!-- Header -->
        <div class="container">
            <div class="text-white mb-3">
                <h3 class="mb-0">Schedule</h3>
            </div>

            <!-- Search Bar -->
            <div class="input-group">
                <!-- Search Icon (Left Corner) -->
                <span class="input-group-text bg-white">
                    <i class="bi bi-search"></i>
                </span>

                <!-- Search Input (Centered) -->
                <input type="text" class="form-control" placeholder="Search" aria-label="Search">

                <!-- Slider Button (Right Corner) -->
                <button class="btn btn-light">
                    <i class="bi bi-sliders"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Doctor Cards (Scrollable Content) -->
    <div class="container mt-5 pt-5" style="height: calc(100vh - 100px); overflow-y: auto;">
        <div class="row g-3 mt-3">
            <?php foreach ($doctors as $doctor): ?>
            <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                <div class="card shadow rounded-4">
                    <div class="card-body d-flex">
                        <img src="<?php echo htmlspecialchars($doctor['image']); ?>" alt="Doctor Image" width="60"
                            height="60">
                        <div class="ms-3">
                            <h5 class="card-title"><?php echo htmlspecialchars($doctor['name']); ?></h5>
                            <p class="card-text">
                                <span class="text-success"><?php echo htmlspecialchars($doctor['title']); ?></span><br>
                                <small><?php echo htmlspecialchars($doctor['hours']); ?></small><br>
                                <small>Fee: <?php echo htmlspecialchars($doctor['fee']); ?></small>
                            </p>
                        </div>
                        <div class="ms-auto align-self-center">
                            <button class="btn btn-success">
                                <i class="bi bi-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Floating Action Button -->
    <a onclick="GetAppointment()" class="btn btn-success position-fixed"
        style="top: 75%; right: 30px; width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; border-radius: 50%; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);">
        <i class="bi bi-plus-lg text-white" style="font-size: 24px;"></i>
    </a>
</div>