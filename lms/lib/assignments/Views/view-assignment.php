<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../../../include/configuration.php';
include '../../../php_handler/function_handler.php';

// Include Classes
include_once '../Classes/Database.php';
include_once '../Classes/Assignments.php';
include_once '../Classes/AssignmentSubmissions.php';

$config_file = '../../../include/env.txt';
$database = new Database($config_file);
$db = $database->getConnection();

$userLevel = $_POST['UserLevel'];
$loggedUser = $_POST['LoggedUser'];
$assignmentId = $_POST['assignmentId'];

$submissionTag = "1stAttempt";

$assignments = new Assignments($database);
$submissions = new AssignmentSubmissions($database);
$assignmentArray = $assignments->fetchById($assignmentId);
$submissionArray = $submissions->fetchAllByAssignmentIdAndUser($assignmentId, $loggedUser);
$resubmissionArray = $submissions->fetchAllByAssignmentIdAndUserDeleted($assignmentId, $loggedUser);

// Function to display assignment content based on file type
function displayAssignmentContent($file_name)
{
    $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    $file_path = "https://admin.pharmacollege.lk//uploads/assignments/" . $file_name; // Update this path as needed
    // $file_path = "http://localhost/payshia-erp/uploads/assignments/" . $file_name; // Update this path as needed


    switch ($file_extension) {
        case 'pdf':
            return "<embed src='$file_path' width='100%' height='800px' type='application/pdf'>";
        case 'jpg':
        case 'jpeg':
        case 'jpeg':
        case 'png':
        case 'webp':
        case 'gif':
            return "<img src='$file_path' alt='Assignment Image' class='w-100 rounded-4'>";
        case 'mp4':
            return "<video width='100%' controls><source src='$file_path' type='video/mp4'>Your browser does not support the video tag.</video>";
        default:
            return "<a href='$file_path' download>Download Assignment</a>";
    }
}

function displaySubmissionContent($file_name, $assignmentId, $username)
{
    $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    $file_path = "./uploads/assignment-submissions/" . $assignmentId . "/" . $username . "/" . $file_name; // Update this path as needed

    switch ($file_extension) {
        case 'pdf':
            return "<embed src='$file_path' width='100%' height='800px' type='application/pdf'>";
        case 'jpg':
        case 'jpeg':
        case 'png':
        case 'gif':
        case 'webp':
            return "<img src='$file_path' alt='Assignment Image' class='w-100 rounded-4'>";
        case 'mp4':
            return "<video width='100%' controls><source src='$file_path' type='video/mp4'>Your browser does not support the video tag.</video>";
        default:
            return "<a href='$file_path' download>Download Assignment</a>";
    }
}

$file_name = $assignmentArray['file_path'];

require_once '../../../vendor/autoload.php';

use GuzzleHttp\Client;

$client = new Client();
$response = $client->request('GET', 'https://api.pharmacollege.lk/submissions/assignment/' . $loggedUser . '/' . $assignmentId, [
    'headers' => [
        'Accept'        => 'application/json',
    ]
]);

$data = json_decode($response->getBody(), true);
// var_dump($data);
?>
<style>
    .thumbnail {
        width: 100px;
        height: 100px;
        margin: 10px;
        object-fit: cover;
    }
</style>

<div class="row mt-2 mb-5 g-3">
    <div class="col-12 mt-3">
        <div class="card shadow mt-5 border-0">
            <div class="card-body">
                <div class="quiz-img-box sha">
                    <img src="./lib/assignments/assets/images/homework.gif" class="quiz-img shadow rounded-4">
                </div>
                <h1 class="card-title text-center mt-2 fw-bold bg-light p-3 rounded-5 mb-0">Assignments</h1>
            </div>
        </div>
    </div>

    <div class="col-12 d-none d-md-block text-end">
        <button class="btn btn-warning" type="button" onclick="ViewAssignment('<?= $assignmentId ?>')"><i class="fa-solid fa-rotate-back"></i> Reload</button>
        <button class="btn btn-dark" type="button" onclick="OpenIndex()"><i class="fa-solid fa-arrow-left"></i> Back</button>
    </div>

    <div class="col-12 d-block d-md-none">
        <div class="row g-2">
            <div class="col-6">
                <button class="btn btn-warning w-100" type="button" onclick="ViewAssignment('<?= $assignmentId ?>')"><i class="fa-solid fa-rotate-back"></i> Reload</button>
            </div>
            <div class="col-6">
                <button class="btn btn-dark w-100" type="button" onclick="OpenIndex()"><i class="fa-solid fa-arrow-left"></i> Back</button>
            </div>
        </div>
    </div>
</div>

<div class="row mb-5">
    <div class="col-12 col-md-6">
        <?= displayAssignmentContent($file_name) ?>
    </div>
    <div class="col-12 col-md-6">
        <?php if (count($submissionArray) == 0) :
            if(!empty($resubmissionArray)){
                $submissionTag = "resubmission";
                ?>
                <div class="alert alert-warning">Resubmission Link</div>
                <?php
            } ?>
            <div class="card shadow border-0 rounded-4">
                <div class="card-body">
                    <h3 class="border-bottom">Submission Info</h3>
                    <form id="submit-form" action="" method="post" enctype="multipart/form-data">
                        <div class="row g-3 mt-3">
                            <div class="col-12">
                                <label for="file">Choose files: (PDF & Images Only)</label>
                                <input class="form-control" type="file" id="file" name="files[]" multiple>
                                <p class="mt-2 text-muted bg-light p-2">Images එකකට වඩා ඇත්නම් ඒ සියල්ල එකවර තෝරන්න.</p>

                                <div id="preview"></div>
                            </div>
                            <div class="col-12 text-end">
                                <button type="button" class="btn btn-dark w-100 btn-lg" onclick="SaveSubmission('<?= $assignmentId ?>', '<?= $submissionTag ?>')">Submit</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        <?php else : ?>
            <div class="card shadow border-0 rounded-4">
                <div class="card-body">
                    <h3 class="border-bottom">Submission Info</h3>
                    <?php
                    
                    
                    foreach ($submissionArray as $submission) :
                        $fileList = $submission['file_list'];
                        $fileList = explode(',', $fileList);
                    ?>

                        <div class="alert alert-warning">Submitted at <?= $submission['created_at'] ?></div>
                        <div class="row g-2">
                            <?php foreach ($fileList as $file) :
                                $file_extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                                $file_path = "./uploads/assignment-submissions/" . $assignmentId . "/" . $loggedUser . "/" . $file; ?>
                                <?php if ($file_extension == 'pdf') : ?>
                                    <div class="col-12">
                                        <?= displaySubmissionContent($file, $assignmentId, $loggedUser); ?>
                                        <a class="btn btn-light btn-sm w-100 my-2" href="<?= $file_path ?>" target="_blank">Download</a>
                                    </div>
                                <?php else : ?>
                                    <div class="col-4"><?= displaySubmissionContent($file, $assignmentId, $loggedUser); ?>
                                        <a class="btn btn-light btn-sm w-100 my-2" href="<?= $file_path ?>" target="_blank">Download</a>
                                    </div>
                                <?php endif ?>
                            <?php endforeach ?>
                        </div>
                        <div class="card border-0 shadow-lg rounded-4">
                            <div class="card-body">
                                <h5 class="border-bottom">Your Grade</h5>
                                <h3 class="mb-0"><?= $data['grade'] ?></h3>
                                <div class="badge bg-<?= ($data['grade_status'] == 1 ? "primary" : "danger") ?>"><?= ($data['grade_status'] == 1 ? "Graded" : "Not Graded") ?></div>
                            </div>
                        </div>

                    <?php endforeach; ?>
                </div>
            </div>

        <?php endif ?>



    </div>
</div>
<script>
    document.getElementById('file').addEventListener('change', function(event) {
        const files = event.target.files;
        const preview = document.getElementById('preview');
        preview.innerHTML = ''; // Clear the preview

        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'thumbnail';
                    preview.appendChild(img);
                };

                reader.readAsDataURL(file);
            }
        }
    });
</script>