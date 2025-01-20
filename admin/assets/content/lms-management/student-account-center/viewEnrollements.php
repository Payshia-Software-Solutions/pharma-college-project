<?php
// Include required files
require_once('../../../../include/config.php');
include '../../../../include/function-update.php';
include '../../../../include/lms-functions.php';
require __DIR__ . '/../../../../vendor/autoload.php';

// For use env file data
use Dotenv\Dotenv;
use Mpdf\Tag\Br;
use Symfony\Component\HttpClient\HttpClient;

// Load environment variables
$dotenv = Dotenv::createImmutable(dirname(__DIR__, 4)); // Go up 5 directories
$dotenv->load();

// Initialize HTTP client
$client = HttpClient::create();

$userThemeInput = isset($_POST['userTheme']) ? $_POST['userTheme'] : null;
$userTheme = getUserTheme($userThemeInput);

$selectedUsername = $_POST['selectedUsername'];

//get enrolled courses by username
$responseForGetCourses = $client->request('GET', $_ENV["SERVER_URL"] . '/studentEnrollments/user/' . $selectedUsername . '/');
$courseByStudentId = $responseForGetCourses->toArray();
?>

<div class="loading-popup-content-right <?= htmlspecialchars($userTheme) ?>">
    <div class="text-end">
        <button class="btn btn-dark " onclick="ClosePopUPRight(1)" type="button"><i class="fa solid fa-xmark"></i> close</button>
    </div>
    <div class="index-content">
        <!-- Enrollments Table -->
        <div class="row mt-3">
            <div class="card-body">
                <div class="col-12 mb-3">
                    <h5 class="table-title">Enrollments</h5>
                </div>
                <?php if (!empty($courseByStudentId)) { ?>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Course Name</th>
                                <th>Course Code</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($courseByStudentId as $enrollment) {
                                $responseForCertificate = $client->request('GET', $_ENV["SERVER_URL"] . '/course/' . $enrollment['course_code'] . '/');
                                $certificate = $responseForCertificate->toArray();
                            ?>
                                <tr>
                                    <td><?= htmlspecialchars($certificate['course_name']) ?></td>
                                    <td><?= htmlspecialchars($enrollment['course_code']) ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                <?php } else { ?>
                    <p class="text-center">No Course Enrollments.</p>
                <?php } ?>
            </div>
        </div>
    </div>

</div>