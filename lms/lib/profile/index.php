<?php
require_once '../../include/configuration.php';
include '../../php_handler/function_handler.php';
include '../../php_handler/course_functions.php';

include '../d-pad/php_methods/d-pad-methods.php';
// include '../pharma-reader/php_methods/pharma-reader-methods.php';
// include '../pharma-hunter/php_methods/pharma-hunter-methods.php';
include '../quiz/php_method/quiz_methods.php';
include '../../php_handler/win-pharma-functions.php';

$userLevel = $_POST['UserLevel'];
$LoggedUser = $_POST['LoggedUser'];
$CourseCode = $_POST['CourseCode'];

$studentBatch = getLmsBatches();
$cityList = GetCities($link);
$districtList = getDistricts($link);
$lmsStudent =  GetLmsStudent()[$LoggedUser];
$userDetails = GetUserDetails($link, $LoggedUser);
$enrolledCourses = getUserEnrollments($LoggedUser);
$studentPayments = getStudentPaymentDetails($LoggedUser);

$recentActivities = array();
$biographyNote = null;
// var_dump($studentPayments);
// var_dump($lmsStudent);


// Winpharma
$batchCode = $CourseCode;
$winPharmaLevels = GetLevels($link, $batchCode);
$getSubmissionLevelCount = GetSubmissionLevelCount($LoggedUser, $batchCode);
$winPharmaLevelCount = count($winPharmaLevels);
if ($winPharmaLevelCount > 0) {
    $winPharmaPercentage = ($getSubmissionLevelCount / $winPharmaLevelCount) * 100;
} else {
    $winPharmaPercentage = 0;
}


$overallGradeDpad =  OverallGradeDpad($LoggedUser)['overallGrade'];
?>

<div class="row mt-2 mt-md-5">
    <div class="col-md-8">
        <div class="profile-cover" style="background-image: url('./lib/profile/assets/images/cover.jpg');">
            <img src="./lib/profile/assets/images/profile.png" alt="Profile Picture" class="profile-picture">

        </div>
        <h2 class="profile-name text-center"><?= $userDetails['first_name'] ?> <?= $userDetails['last_name'] ?></h2>
        <div class="profile-description text-secondary">
            <p class="text-center"><?= $lmsStudent['userlevel'] ?></p>
        </div>


        <div class="row g-2">
            <div class="col-6">
                <!-- Edit Profile Button -->
                <button type="button" onclick="EditProfilePopup()" class="btn btn-primary btn-edit-profile w-100"><i class="fa-solid fa-user-pen px-2 d-block mb-1"></i> Edit Profile</button>
            </div>

            <div class="col-6">
                <!-- Logout Button -->
                <button type="button" onclick="redirectToURL('logout')" class="btn btn-danger btn-logout w-100"><i class="fa-solid fa-arrow-right-from-bracket px-2 d-block mb-1"></i> Logout</button>
            </div>

        </div>


        <div class="enrollments">
            <h3 class="section-title">Enrollments</h3>
            <ul class="enrollment-list">
                <?php
                if (!empty($enrolledCourses)) {
                    foreach ($enrolledCourses as $selectedArray) {
                ?>
                        <li class="enrollment-item">
                            <span class="course-title"><?= $studentBatch[$selectedArray['course_code']]['course_name'] ?></span>
                            <span class="course-status"><?= $selectedArray['course_code'] ?></span>
                        </li>
                <?php
                    }
                }
                ?>

            </ul>
        </div>

        <div class="mt-2">
            <!-- Recent Activities -->

            <div class="game-results">
                <h3>Game Results</h3>
                <div class="card-deck" id="scrollable-cards">
                    <div class="card shadow">
                        <div class="card-body text-center">
                            <img src="./lib/home/assets/images/drugs.gif" class="card-img-top" alt="Game 1">
                            <h5 class="card-title">WinPharma</h5>
                            <p class="card-text"><?= number_format($winPharmaPercentage, 2) ?></p>
                        </div>
                    </div>
                    <div class="card shadow">
                        <div class="card-body text-center">
                            <img src="./lib/home/assets/images/question.gif" class="card-img-top" alt="Game 1">
                            <h5 class="card-title">Quiz</h5>
                            <p class="card-text"><?= number_format(GetOverallGrade($LoggedUser, $CourseCode), 2) ?></p>
                        </div>
                    </div>


                    <div class="card  shadow">
                        <div class="card-body text-center">
                            <img src="./lib/home/assets/images/pill.gif" class="card-img-top" alt="Game 1">
                            <h5 class="card-title">D-Pad</h5>
                            <p class="card-text"><?= number_format($overallGradeDpad, 2) ?></p>
                        </div>
                    </div>
                    <?php
                    $RecoveredPatientsCount =  GetRecoveredPatientsByCourse($link, $CourseCode, $LoggedUser);
                    $CoursePatientsCount = count(GetCoursePatients($link, $CourseCode));

                    if ($CoursePatientsCount != 0) {
                        $ProgressValue = number_format(($RecoveredPatientsCount / $CoursePatientsCount) * 100);
                    } else {
                        $ProgressValue = 0;
                    }
                    ?>

                    <div class="card shadow">
                        <div class="card-body text-center">
                            <img src="./lib/ceylon-pharmacy/assets/images/pharmacy.gif" class="card-img-top" alt="Game 1">
                            <h5 class="card-title">Ceylon Pharmacy</h5>
                            <p class="card-text"><?= number_format($ProgressValue, 2) ?></p>
                        </div>
                    </div>
                    <div class="card shadow">
                        <div class="card-body text-center">
                            <img src="./lib/home/assets/images/medicine.gif" class="card-img-top" alt="Game 1">
                            <h5 class="card-title">Pharma Hunter</h5>
                            <p class="card-text">0</p>
                        </div>
                    </div>
                    <div class="card shadow">
                        <div class="card-body text-center">
                            <img src="./lib/home/assets/images/alternative-medicine.gif" class="card-img-top" alt="Game 1">
                            <h5 class="card-title">Pharma Reader</h5>
                            <p class="card-text">0</p>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
    <div class="col-md-4">

        <div class="user-details mt-0">
            <h3 class="section-title">User Details</h3>
            <div class="details-list">
                <div class="detail-item">
                    <div class="detail-label">Full Name:</div>
                    <div class="detail-value"><?= $userDetails['civil_status'] ?> <?= $userDetails['first_name'] ?> <?= $userDetails['last_name'] ?></div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Phone:</div>
                    <div class="detail-value"><?= $lmsStudent['phone'] ?></div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Email:</div>
                    <div class="detail-value"><?= $lmsStudent['email'] ?></div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Username:</div>
                    <div class="detail-value"><?= $lmsStudent['username'] ?></div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Birth Day:</div>
                    <div class="detail-value"><?= $userDetails['birth_day'] ?></div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Gender:</div>
                    <div class="detail-value"><?= $userDetails['gender'] ?></div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Address:</div>
                    <div class="detail-value"><?= $userDetails['address_line_1'] ?>, <?= $userDetails['address_line_2'] ?></div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">City:</div>
                    <div class="detail-value"><?= $cityList[$userDetails['city']]['name_en'] ?>, <?= $userDetails['postal_code'] ?></div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">District:</div>
                    <div class="detail-value"><?= $districtList[$cityList[$userDetails['city']]['district_id']]['name_en'] ?></div>
                </div>

            </div>
        </div>

        <div class="biography">
            <h3 class="section-title">Biography</h3>
            <div class="biography-content bg-light">
                <p><?= ($biographyNote != null) ? $biographyNote : 'No Biography Note' ?></p>
            </div>
        </div>

        <div class="payment-history">
            <h3 class="section-title">Payment History</h3>
            <div class="payment-list">
                <?php
                if (!empty($studentPayments)) {
                    foreach ($studentPayments as $selectedArray) {

                ?>
                        <div class="payment-item mb-2">
                            <div class="payment-date"><?= $selectedArray['receipt_number'] ?> - <?= date('M d, Y', strtotime($selectedArray['paid_date'])) ?></div>
                            <div class="payment-amount">Rs. <?= $selectedArray['paid_amount'] ?></div>
                        </div>

                <?php
                    }
                }
                ?>

                <!-- Additional payment items go here -->
            </div>
        </div>



        <div class="recent-activities">
            <h3>Recent Activities</h3>
            <ul>
                <?php
                if (!empty($recentActivities)) {
                    foreach ($recentActivities as $selectedArray) {
                ?>
                        <li>
                            <span class="activity-date">Feb 20, 2024</span>
                            <span class="activity-description">Posted a new article</span>
                        </li>
                    <?php
                    }
                } else {
                    ?>
                    <p>No Recent Activities</p>
                <?php
                }
                ?>
            </ul>
        </div>




    </div>
</div>
<!-- Posts -->

<div class="row mt-3 d-none">
    <div class="col-md-8">
        <h3 class="">Posts</h3>
        <div class="post">
            <h4 class="post-title">Post Title 1</h4>
            <p class="post-content">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus efficitur, risus vel faucibus accumsan, justo magna consectetur libero, non suscipit elit nisl at risus.</p>
            <!-- Images (optional) -->
            <div class="post-images">
                <img src="https://via.placeholder.com/150" class="post-images-set" alt="Post Image 1">
                <img src="https://via.placeholder.com/150" class="post-images-set" alt="Post Image 3">
                <div class="image-container ">
                    <img src="https://via.placeholder.com/150" class="post-images-set" alt="Image 3">
                    <div class="image-overlay text-center">3+</div>
                </div>
            </div>
            <!-- Like Feature -->
            <div class="d-flex align-items-center mt-3">
                <button class="btn btn-sm btn-outline-primary like-button" onclick="likePost(1)">
                    <i class="bi bi-hand-thumbs-up"></i> <!-- Like icon -->
                    Like <span class="react-counter" id="react-counter-1">0</span> <!-- Like counter -->
                </button>
                <button class="btn btn-sm btn-outline-primary like-button mx-2">
                    <i class="bi bi-chat-dots"></i> <!-- Comment icon -->
                    Comment
                </button>
            </div>

        </div>


        <div class="post">
            <h4 class="post-title">Post Title 2</h4>
            <p class="post-content">Sed auctor massa at purus suscipit, nec malesuada libero consequat. Vestibulum at pulvinar nisi, vel dignissim lorem. Fusce vel dapibus velit.</p>
            <!-- Like Feature -->
            <div class="d-flex align-items-center mt-3">
                <button class="btn btn-sm btn-outline-primary like-button" onclick="likePost(1)">
                    <i class="bi bi-hand-thumbs-up"></i> <!-- Like icon -->
                    Like <span class="react-counter" id="react-counter-1">0</span> <!-- Like counter -->
                </button>
                <button class="btn btn-sm btn-outline-primary like-button mx-2">
                    <i class="bi bi-chat-dots"></i> <!-- Comment icon -->
                    Comment
                </button>
            </div>

        </div>

        <div class="post">
            <h4 class="post-title">Post Title 3</h4>
            <p class="post-content">Quisque sit amet elit vitae ligula ullamcorper rhoncus. Morbi tincidunt, justo at interdum faucibus, lacus libero eleifend ante, eu suscipit elit leo a est.</p>
            <!-- Like Feature -->
            <div class="d-flex align-items-center mt-3">
                <button class="btn btn-sm btn-outline-primary like-button" onclick="likePost(1)">
                    <i class="bi bi-hand-thumbs-up"></i> <!-- Like icon -->
                    Like <span class="react-counter" id="react-counter-1">0</span> <!-- Like counter -->
                </button>
                <button class="btn btn-sm btn-outline-primary like-button mx-2">
                    <i class="bi bi-chat-dots"></i> <!-- Comment icon -->
                    Comment
                </button>
            </div>

        </div>
    </div>
    <div class="col-md-4">
        <div class="ads-space-square">
            <iframe src="https://giphy.com/embed/l0HlOrRj8sqK1xiJa" width="100%" height="270" frameBorder="0" class="giphy-embed" allowFullScreen></iframe>
            <img class="mt-2" src="./lib/profile/assets/ads/nina.gif">
        </div>
    </div>
</div>

</body>

</html>