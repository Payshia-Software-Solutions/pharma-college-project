<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../include/configuration.php"; // Include config file   



$finalgrade = $assignment_count = $final_percentage_value = 0;
$final_percentage = "Not Graded";
$index_no = $_GET['UserID'];
$CourseCode = $_GET['CourseCode'];

$sql = "SELECT `id`, `student_id`, `username`, `civil_status`, `first_name`, `last_name`, `gender`, `address_line_1`, `address_line_2`, `city`, `district`, `postal_code`, `telephone_1`, `telephone_2`, `nic`, `e_mail`, `birth_day`, `updated_by`, `updated_at`, `full_name`, `name_with_initials`, `name_on_certificate` FROM `user_full_details` WHERE `username` LIKE '$index_no'  ORDER BY `id` DESC";
$result = $link->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $ArrayResult[$row['username']] = $row;
    }
}

$userDetails =  $ArrayResult[$index_no];


$finalGrade = "Not Graded";

$sql = "SELECT `course_name` FROM `course` WHERE `course_code` LIKE '$CourseCode'";
$result = $link->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $course_name = $row['course_name'];
    }
}

// $sql = "SELECT COUNT(assignment_submittion.assignment_id) AS AssignmentCOunt FROM `assignment_submittion` INNER JOIN assignment ON assignment.assignment_id = assignment_submittion.assignment_id WHERE assignment.course_code = '$CourseCode' AND assignment_submittion.created_by LIKE '$index_no'";
// $sql_result = $link->query($sql);
// if ($sql_result->num_rows > 0) {
//     while ($row = $sql_result->fetch_assoc()) {
//         $assignment_count = $row['AssignmentCOunt'];
//     }
// }
// $sql_inner = "SELECT `result` FROM `certificate_user_result` WHERE `index_number` LIKE '$index_no' AND `course_code` LIKE '$CourseCode' AND `title_id` LIKE 'OverRallGrade'";
// $result_inner = $link->query($sql_inner);
// if ($result_inner->num_rows > 0) {
//     while ($row = $result_inner->fetch_assoc()) {
//         $final_percentage_value = $row['result'];
//     }
// } else {
//     $get_fullname = "SELECT assignment_submittion.assignment_id, assignment_submittion.file_path, assignment_submittion.created_by, assignment_submittion.created_at, assignment_submittion.status, assignment_submittion.grade, assignment.course_code FROM `assignment_submittion` INNER JOIN assignment ON assignment.assignment_id = assignment_submittion.assignment_id WHERE assignment.course_code = '$CourseCode' AND assignment_submittion.created_by LIKE '$index_no'";
//     $get_fullname_result = $link->query($get_fullname);
//     while ($row = $get_fullname_result->fetch_assoc()) {
//         $grade = $row['grade'];
//         if ($grade != "Not Graded") {
//             $grade = (float) $grade;
//         } else {
//             $grade = 0;
//         }
//         $finalgrade = $finalgrade + $grade;
//         $final_percentage_value = ($finalgrade / (100 * $assignment_count)) * 100;
//         $final_percentage = $final_percentage_value . " %";
//     }
// }


function GetAssignmentSubmissionsByUser($studentNumber)
{
    global $link;
    $ArrayResult = array();
    $sql = "SELECT `id`, `assignment_id`, `file_path`, `created_by`, `created_at`, `status`, `grade` FROM `assignment_submittion` WHERE `created_by` = '$studentNumber'";
    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $assignmentId = $row["assignment_id"];
            $ArrayResult[$assignmentId] = $row;
        }
    }
    return $ArrayResult;
}

function GetAssignments($courseCode)
{
    global $link;
    $ArrayResult = array();
    $sql = "SELECT * FROM `assignment` WHERE `course_code` LIKE '$courseCode'";
    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[$row["assignment_id"]] = $row;
        }
    }
    return $ArrayResult;
}

$finalgrade = $assignment_count = $final_percentage_value = 0;
$final_percentage = $grade = 0;

$assignmentSubmissions =  GetAssignmentSubmissionsByUser($index_no);
$CourseAssignments = GetAssignments($CourseCode);
$assignment_count = count($CourseAssignments);

if (!empty($CourseAssignments)) {
    foreach ($CourseAssignments as $selectedArray) {
        $assignment_id = $selectedArray['assignment_id'];
        if (isset($assignmentSubmissions[$assignment_id])) {
            $grade = $assignmentSubmissions[$assignment_id]['grade'];
        }

        if ($grade != "Not Graded") {
            $grade = (float) $grade;
        } else {
            $grade = 0;
        }
        $finalgrade = $finalgrade + $grade;
        $final_percentage_value = ($finalgrade / (100 * $assignment_count)) * 100;
        $final_percentage = $final_percentage_value . " %";
    }
}




$sql_inner = "SELECT `result` FROM `certificate_user_result` WHERE `index_number` LIKE '$index_no' AND `course_code` LIKE '$CourseCode' AND `title_id` LIKE 'OverRallGrade'";
$result_inner = $link->query($sql_inner);
if ($result_inner->num_rows > 0) {
    while ($row = $result_inner->fetch_assoc()) {
        $final_percentage_value = $row['result'];
    }
}



if ($final_percentage_value == "Not Graded") {
    $finalGrade = "Not Graded";
} elseif ($final_percentage_value >= 90) {
    $finalGrade = "A+";
} elseif ($final_percentage_value >= 80) {
    $finalGrade = "A";
} elseif ($final_percentage_value >= 75) {
    $finalGrade = "A-";
} elseif ($final_percentage_value >= 70) {
    $finalGrade = "B+";
} elseif ($final_percentage_value >= 65) {
    $finalGrade = "B";
} elseif ($final_percentage_value >= 60) {
    $finalGrade = "B-";
} elseif ($final_percentage_value >= 55) {
    $finalGrade = "C+";
} elseif ($final_percentage_value >= 45) {
    $finalGrade = "C";
} elseif ($final_percentage_value >= 40) {
    $finalGrade = "C-";
} elseif ($final_percentage_value >= 35) {
    $finalGrade = "D+";
} elseif ($final_percentage_value >= 30) {
    $finalGrade = "D";
} elseif ($final_percentage_value >= 0) {
    $finalGrade = "E";
}

if ($final_percentage_value >= 80) {
    $grade_result = "Excellent";
    $star_count = 5;
} elseif ($final_percentage_value >= 75) {
    $grade_result = "Good";
    $star_count = 4;
} elseif ($final_percentage_value >= 60) {
    $grade_result = "Pretty Good";
    $star_count = 3;
} elseif ($final_percentage_value >= 40) {
    $grade_result = "Poor";
    $star_count = 2;
} else {
    $grade_result = "Weak";
    $star_count = 1;
}

if ($finalGrade == "Not Graded") {
    $grade_result = "Not Graded";
    $star_count = 0;
}



if ($stmt = $link->prepare("SELECT `status_id`, `username`, `fname`, `lname` FROM `users` WHERE `username` LIKE '$index_no'")) {
    $stmt->bind_result($status_id, $username_new, $fname, $lname);
    $OK = $stmt->execute();
    $stmt->fetch();
    $stmt->close();
}

if ($stmt = $link->prepare("SELECT `civil_status` FROM `user_full_details` WHERE `username` LIKE '$index_no'")) {
    $stmt->bind_result($civil_status);
    $OK = $stmt->execute();
    $stmt->fetch();
    $stmt->close();
}
if (isset($username_new)) {

?>
    <style>
        .star-rating {
            line-height: 32px;
            font-size: 1.25em;
        }

        .star-rating .fa-star {
            color: yellow;
        }

        .fa-star {
            text-shadow: 0 0 3px #FF0000;
        }

        .results-out {
            background-color: #fff !important;
            border-radius: 15px;
            color: #24b783;
            padding: 20px;
        }

        .results-out h3 {
            color: #24b783;
        }
    </style>
    <div class="results-out">
        <div class="text-center">
            <img src="assets/images/logo.png" class="mb-3" alt="" style="height: 40px;">
        </div>
        <h3 class="font-weight-bolder mb-4 text-center">Certificate Confirmation</h3>
        <table class="table table-hover">
            <tbody>
                <tr>
                    <th scope="row">Student Name</th>
                    <td><?php echo $civil_status . " " . $fname . " " . $lname; ?></td>
                </tr>
                <tr>
                    <th scope="row">Name on Certificate</th>
                    <td><?= $userDetails['name_on_certificate']; ?></td>
                </tr>
                <tr>
                    <th scope="row">Index No</th>
                    <td><?php echo $username_new; ?></td>
                </tr>
                <tr>
                    <th scope="row">Overall Grade</th>
                    <td><?php echo $finalGrade; ?></td>
                </tr>
                <th scope="row">Rating</th>
                <td>
                    <p class="text-success mb-0"><span class="badge bg-success text-white"><?php echo $grade_result; ?></span></p>
                    <div class="star-rating pt-0">
                        <?php if ($star_count == 0) { ?>
                            <span class="fa fa-star-o" data-rating="<?php echo $star_count; ?>"></span>
                            <span class="fa fa-star-o" data-rating="<?php echo $star_count; ?>"></span>
                            <span class="fa fa-star-o" data-rating="<?php echo $star_count; ?>"></span>
                            <span class="fa fa-star-o" data-rating="<?php echo $star_count; ?>"></span>
                            <span class="fa fa-star-o" data-rating="<?php echo $star_count; ?>"></span>
                        <?php
                        }
                        ?>

                        <?php if ($star_count == 5) {
                            while ($star_count > 0) { ?>
                                <span class="fa fa-star" data-rating="<?php echo $star_count; ?>"></span>
                        <?php
                                $star_count -= 1;
                            }
                        }
                        ?>

                        <?php if ($star_count == 4) {
                            while ($star_count > 0) { ?>
                                <span class="fa fa-star" data-rating="<?php echo $star_count; ?>"></span>
                            <?php
                                $star_count -= 1;
                            }
                            ?>
                            <span class="fa fa-star-o" data-rating="<?php echo $star_count; ?>"></span>
                        <?php
                        }
                        ?>

                        <?php if ($star_count == 3) {
                            while ($star_count > 0) { ?>
                                <span class="fa fa-star" data-rating="<?php echo $star_count; ?>"></span>
                            <?php
                                $star_count -= 1;
                            }
                            ?>
                            <span class="fa fa-star-o" data-rating="<?php echo $star_count; ?>"></span>
                            <span class="fa fa-star-o" data-rating="<?php echo $star_count; ?>"></span>
                        <?php
                        }
                        ?>

                        <?php if ($star_count == 2) {
                            while ($star_count > 0) { ?>
                                <span class="fa fa-star" data-rating="<?php echo $star_count; ?>"></span>
                            <?php
                                $star_count -= 1;
                            }
                            ?>
                            <span class="fa fa-star-o" data-rating="<?php echo $star_count; ?>"></span>
                            <span class="fa fa-star-o" data-rating="<?php echo $star_count; ?>"></span>
                            <span class="fa fa-star-o" data-rating="<?php echo $star_count; ?>"></span>
                        <?php
                        }
                        ?>

                        <?php if ($star_count == 1) {
                            while ($star_count > 0) { ?>
                                <span class="fa fa-star" data-rating="<?php echo $star_count; ?>"></span>
                            <?php
                                $star_count -= 1;
                            }
                            ?>
                            <span class="fa fa-star-o" data-rating="<?php echo $star_count; ?>"></span>
                            <span class="fa fa-star-o" data-rating="<?php echo $star_count; ?>"></span>
                            <span class="fa fa-star-o" data-rating="<?php echo $star_count; ?>"></span>
                            <span class="fa fa-star-o" data-rating="<?php echo $star_count; ?>"></span>
                        <?php
                        }
                        ?>




                    </div>
                    <input type="hidden" name="whatever1" class="rating-value" value="2.56">
    </div>
    </td>
    </tr>
    </tbody>
    </table>
    <div class="text-center mt-2 border-top pt-2">
        <a href="./result-view.php?CourseCode=<?php echo $CourseCode; ?>&LoggedUser=<?php echo $index_no; ?>" target="_blank"><button class="btn btn-warning" type="button">View Full Report</button></a>
    </div>
    </div>

<?php
} else { ?>
    Invalid Index Number
<?php } ?>