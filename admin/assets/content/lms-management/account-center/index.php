<?php
require_once('../../../../include/config.php');
include '../../../../include/function-update.php';
include '../../../../include/lms-functions.php';
require __DIR__ . '/../../../../vendor/autoload.php';

//for use env file data
use Dotenv\Dotenv;
use Symfony\Component\HttpClient\HttpClient;

$dotenv = Dotenv::createImmutable(dirname(__DIR__, 4)); // Go up 5 directories
$dotenv->load();

$client = HttpClient::create();
// $response = $client->request('GET', $_ENV["SERVER_URL"] . '/users/');
// $userList = $response->toArray();
// gayanrewatha96

$LoggedUser = $_POST['LoggedUser'];
$batchCode = $_POST['batchCode'];

$accountDetails = GetAccounts($link);
$Locations = GetLocations($link);
$selectedBatch = getLmsBatches()[$batchCode];
$studentEnrollCounts = GetStudentEnrollCounts();
$userEnrollments = getAllUserEnrollmentsByCourse($batchCode);
$batchStudents =  GetLmsStudentsByUserId();
?>
<div class="row mt-5">
    <div class="col-md-3">
        <div class="card border item-card">
            <div class="overlay-box">
                <i class="fa-solid fa-users icon-card"></i>
            </div>
            <div class="card-body">
                <p>No of Students</p>
                <h1><?= count($userEnrollments) ?></h1>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <h5 class="table-title">Accounts</h5>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="userTable" class="table table-striped" style="width:100%">
                        <thead>
                            <th>#</th>
                            <th>Index Number</th>
                            <th>Actions</th>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($userEnrollments)) {
                                foreach ($userEnrollments as $selectedArray) {
                                    $studentId = $selectedArray['student_id'];
                                    if (!isset($batchStudents[$studentId])) {
                                        continue;
                                    }
                                    $studentDetailsArray = $batchStudents[$studentId];
                                    $studentNumber = $studentDetailsArray['username'];
                                    $phoneNumber = $studentDetailsArray['telephone_1'];
                            ?>
                                    <tr>
                                        <td><?= $studentDetailsArray['username'] ?></td>
                                        <td><?= $studentDetailsArray['first_name'] ?> <?= $studentDetailsArray['last_name'] ?></td>
                                        <td>
                                            <button class="btn btn-success" type="button" onclick="SendUsernameMessage('<?= $studentNumber ?>', '<?= $phoneNumber ?>', '<?= $batchCode ?>')">Send Username</button>
                                            <!-- <button class="btn btn-warning" type="button">Send Reset Link</button> -->
                                        </td>
                                    </tr>
                            <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        $('#userTable').DataTable({
            responsive: true,
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf'
                // 'colvis'
            ],
            ordering: false
        });
    });
</script>