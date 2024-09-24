<?php
function GetCompanyInfo($link)
{
    $ArrayResult = array();
    $sql = "SELECT `id`, `company_name`, `company_address`, `company_address2`, `company_city`, `company_postalcode`, `company_email`, `company_telephone`, `company_telephone2`, `owner_name`, `job_position` FROM `company`";

    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[] = $row;
        }
    }
    return $ArrayResult;
}

function GetCourses($link)
{

    $ArrayResult = array();
    $sql = "SELECT `id`, `course_name`, `course_code`, `instructor_id`, `course_description`, `course_duration`, `course_fee`, `registration_fee`, `other`, `created_at`, `created_by`, `update_by`, `update_at`, `enroll_key`, `display`, `CertificateImagePath`, `course_img`, `certification`, `mini_description` FROM `course` ORDER BY `id` DESC";

    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[$row['course_code']] = $row;
        }
    }
    return $ArrayResult;
}


function GetCourseImage($link, $CourseCode)
{
    $img_path = "";
    $get_course_img = "SELECT `img_path` FROM `img_course` WHERE `course_code` LIKE '$CourseCode'";
    $get_course_img_result = $link->query($get_course_img);
    while ($row = $get_course_img_result->fetch_assoc()) {
        $img_path = $row["img_path"];
    }

    return $img_path;
}

function GetCityName($link, $CityID)
{

    $ArrayResult = array();
    $sql = "SELECT `id`, `district_id`, `name_en`, `name_si`, `name_ta`, `sub_name_en`, `sub_name_si`, `sub_name_ta`, `postcode`, `latitude`, `longitude` FROM `cities` WHERE `id` LIKE '$CityID'";
    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $ArrayResult = $row;
    }
    return $ArrayResult;
}

function GetDistrictName($link, $DistrictID)
{

    $ArrayResult = array();
    $sql = "SELECT `id`, `district_id`, `name_en`, `name_si`, `name_ta`, `sub_name_en`, `sub_name_si`, `sub_name_ta`, `postcode`, `latitude`, `longitude` FROM `cities` WHERE `id` LIKE '$DistrictID'";

    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $ArrayResult = $row;
    }
    return $ArrayResult;
}


function FormatPhone($number)
{
    return "(+94) " . substr($number, 0, 2) . " " . substr($number, 2, 1) . " " . substr($number, 3, 3) . " " . substr($number, 6);
}
function GetUsers($link)
{

    $ArrayResult = array();
    $sql = "SELECT `id`, `status_id`, `userid`, `fname`, `lname`, `batch_id`, `username`, `phone`, `email`, `password`, `userlevel`, `status`, `created_by`, `created_at`, `batch_lock`, CONCAT(`fname`, ' ', `lname`) AS `full_name` FROM `users`";


    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[$row['username']] = $row;
        }
    }
    return $ArrayResult;
}


function GetFullUserDetails($link, $Username)
{

    $ArrayResult = array();
    $sql = "SELECT `id`, `student_id`, `username`, `civil_status`, `first_name`, `last_name`, `gender`, `address_line_1`, `address_line_2`, `city`, `district`, `postal_code`, `telephone_1`, `telephone_2`, `nic`, `e_mail`, `birth_day`, `updated_by`, `updated_at` FROM `user_full_details` WHERE `username` LIKE '$Username'";


    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $ArrayResult = $row;
    }
    return $ArrayResult;
}

function ThousandDivider($Number)
{
    $ReturnValue = $Number;
    if ($Number >= 1000) {
        $ReturnValue = intdiv($Number, 1000);
    }
    return $ReturnValue;
}


function GetEvents($link)
{
    $ArrayResult = array();
    $sql = "SELECT `id`, `event_type`, `event_name`, `event_date`, `event_photo_name`, `event_location`, `event_heading`, `event_description`, `event_tags`, `added_date`, `log_user`, `fb_likes`, `youtube_views`, `is_active`, `ref` FROM `tbl_events` ORDER BY `id` DESC";
    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[$row["ref"]] = $row;
        }
    }
    return $ArrayResult;
}

function GetInstructors($link)
{

    $ArrayResult = array();
    $sql = "SELECT `id`, `status_id`, `userid`, `fname`, `lname`, `batch_id`, `username`, `phone`, `email`, `password`, `userlevel`, `status`, `created_by`, `created_at`, `batch_lock`, CONCAT(`fname`, ' ', `lname`) AS `full_name` FROM `users` WHERE `userlevel` != 'Student' ORDER BY  `id` DESC";

    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[$row['username']] = $row;
        }
    }
    return $ArrayResult;
}


function GetOutcomes($link, $CourseCode)
{
    $ArrayResult = array();
    $sql = "SELECT `id`, `outcome`, `course_code`, `is_active` FROM `course_outcomes` WHERE `course_code` LIKE '$CourseCode'";

    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[$row['id']] = $row;
        }
    }
    return $ArrayResult;
}


function GetCourseOverviews($link, $CourseCode)
{
    $ArrayResult = array();
    $sql = "SELECT `id`, `course_code`, `overview_title`, `overview_key`, `value`, `is_active`, `icon` FROM `course_overview` WHERE `course_code` LIKE '$CourseCode'";

    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[$row['id']] = $row;
        }
    }
    return $ArrayResult;
}

function GetCourseModule($link, $CourseCode)
{
    $ArrayResult = array();
    $sql = "SELECT `id`, `module_code`, `credit`, `module_name`, `duration`, `level`, `course_code`, `is_active` FROM `course_modules` WHERE `course_code` LIKE '$CourseCode'";

    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[$row['id']] = $row;
        }
    }
    return $ArrayResult;
}

function GetJobApplications($link)
{
    $ArrayResult = array();
    $sql = "SELECT `job_id_phamacist`, `job_id_assistant`, `job_id_assistant_trainee`, `user_id`, `index_number`, `index_approval` from `job_application_user`";

    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[$row['index_number']] = $row;
        }
    }
    return $ArrayResult;
}

function GetUserResults($link, $CourseCode, $index_no)
{

    $finalgrade = $assignment_count = $final_percentage_value = 0;
    $final_percentage = "Not Graded";
    $sql = "SELECT COUNT(assignment_submittion.assignment_id) AS AssignmentCOunt FROM `assignment_submittion` INNER JOIN assignment ON assignment.assignment_id = assignment_submittion.assignment_id WHERE assignment.course_code = '$CourseCode' AND assignment_submittion.created_by LIKE '$index_no'";
    $sql_result = $link->query($sql);
    if ($sql_result->num_rows > 0) {
        while ($row = $sql_result->fetch_assoc()) {
            $assignment_count = $row['AssignmentCOunt'];
        }
    }
    $sql_inner = "SELECT `result` FROM `certificate_user_result` WHERE `index_number` LIKE '$index_no' AND `course_code` LIKE '$CourseCode' AND `title_id` LIKE 'OverRallGrade'";
    $result_inner = $link->query($sql_inner);
    if ($result_inner->num_rows > 0) {
        while ($row = $result_inner->fetch_assoc()) {
            $final_percentage_value = $row['result'];
        }
    } else {
        $get_fullname = "SELECT assignment_submittion.assignment_id, assignment_submittion.file_path, assignment_submittion.created_by, assignment_submittion.created_at, assignment_submittion.status, assignment_submittion.grade, assignment.course_code FROM `assignment_submittion` INNER JOIN assignment ON assignment.assignment_id = assignment_submittion.assignment_id WHERE assignment.course_code = '$CourseCode' AND assignment_submittion.created_by LIKE '$index_no'";
        $get_fullname_result = $link->query($get_fullname);
        while ($row = $get_fullname_result->fetch_assoc()) {
            $grade = $row['grade'];
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

    return $finalGrade;
}


function Vacancies($link)
{
    $ArrayResult = array();
    $sql = "SELECT `id`, `quest_id`, `type`, `f_name`, `l_name`, `display_name`, `description`, `date_time`, `whatsapp_number`, `email_address`, `status_active`, `city`, `district`, `index_number`, `add_for` FROM `addvertisements` ORDER BY `id` DESC";

    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[$row['quest_id']] = $row;
        }
    }
    return $ArrayResult;
}

function VacanciesCountByCity($link)
{
    $ArrayResult = array();
    $sql = "SELECT COUNT(id) AS `VacancyCount`, `city`, `district` FROM `addvertisements` GROUP BY `city` ORDER BY `VacancyCount` DESC";

    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[$row['city']] = $row;
        }
    }
    return $ArrayResult;
}


function GetAdvertisements($link)
{
    $ArrayResult = array();
    $sql = "SELECT `id`, `quest_id`, `type`, `f_name`, `l_name`, CONCAT(`f_name`+ ' ' + `l_name`) AS `full_name`, `display_name`, `description`, `date_time`, `whatsapp_number`, `email_address`, `status_active`, `city`, `district`, `index_number`, `add_for`, `img_url` FROM `addvertisements`";
    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[$row['quest_id']] = $row;
        }
    }
    return $ArrayResult;
}



function GetPublicPosts($link)
{
    $ArrayResult = array();
    $sql = "SELECT `post_id`, `post_date`, `post_title`, `post_description`, `post_highlight`, `keywords`, `post_cover`, `created_by`, `updated_at`, `is_active` FROM `public_post` ORDER BY `post_id` DESC";
    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[$row['post_id']] = $row;
        }
    }
    return $ArrayResult;
}


function GetPublicEvents($link)
{
    $ArrayResult = array();
    $sql = "SELECT `post_id`, `post_date`, `post_title`, `post_description`, `post_highlight`, `keywords`, `post_cover`, `created_by`, `updated_at`, `is_active`, `location`  FROM `public_events` ORDER BY `post_id` DESC";
    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[$row['post_id']] = $row;
        }
    }
    return $ArrayResult;
}


function JoinNow($link, $Email, $status_id, $fname, $lname, $password, $NicNumber, $phoneNumber, $whatsAppNumber, $addressL1, $addressL2, $city, $District, $postalCode, $paid_amount, $full_name, $name_with_initials, $name_on_certificate, $gender, $selectedCourse)
{

    date_default_timezone_set("Asia/Colombo");
    $current_time = date("Y-m-d H:i:s");
    $hashPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO `temp_lms_user`(`email_address`, `civil_status`, `first_name`, `last_name`, `password`, `nic_number`, `phone_number`, `whatsapp_number`, `address_l1`, `address_l2`, `city`, `district`, `postal_code`, `paid_amount`, `created_at`, `full_name`, `name_with_initials`, `name_on_certificate`, `gender`, `selected_course`) VALUES  (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    if ($stmt_sql = mysqli_prepare($link, $sql)) {

        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt_sql, "ssssssssssssssssssss", $Email, $status_id, $fname, $lname, $hashPassword, $NicNumber, $phoneNumber, $whatsAppNumber, $addressL1, $addressL2, $city, $District, $postalCode, $paid_amount, $current_time, $full_name, $name_with_initials, $name_on_certificate, $gender, $selectedCourse);

        // Execute the statement
        if (mysqli_stmt_execute($stmt_sql)) {
            $last_inserted_id = mysqli_insert_id($link);
            $affected_rows = mysqli_stmt_affected_rows($stmt_sql);

            $error = array('status' => 'success', 'message' => 'Temporary Account updated successfully', 'affected_rows' => $affected_rows, 'last_inserted_id' => $last_inserted_id, 'username' => 'Not Set');
        } else {
            $error = array('status' => 'error', 'message' => 'Something went wrong. Please try again later. ' . mysqli_error($link), 'username' => "Not Set", 'last_inserted_id' => "Not Set");
        }

        // Close the prepared statement
        mysqli_stmt_close($stmt_sql);
    } else {
        $error = array('status' => 'error', 'message' => 'Something went wrong. Please try again later. ' . mysqli_error($link), 'username' => "Not Set", 'last_inserted_id' => "Not Set");
    }

    // Return the error as a JSON-encoded string
    return json_encode($error);
}


function GetCities($link)
{

    $ArrayResult = array();
    $sql = "SELECT `id`, `district_id`, `name_en`, `name_si`, `name_ta`, `sub_name_en`, `sub_name_si`, `sub_name_ta`, `postcode`, `latitude`, `longitude` FROM `cities` ORDER BY `name_en`";

    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[$row['id']] = $row;
        }
    }
    return $ArrayResult;
}

function getDistricts($link)
{
    $sql = "SELECT `id`, `province_id`, `name_en`, `name_si`, `name_ta` FROM `districts`";
    $ArrayResult = array();
    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[$row['id']] = $row;
        }
    }
    return $ArrayResult;
}


function formatPhoneNumber($phoneNumber)
{
    $length = strlen($phoneNumber);

    // Check if the number has 9 digits
    if ($length === 9) {
        $formattedNumber = 0 . $phoneNumber;
    }

    // If the number doesn't match any of the conditions, use the original number
    else {
        $formattedNumber = $phoneNumber;
    }

    return $formattedNumber;
}


function GetParentCourses($link)
{

    $ArrayResult = array();
    $sql = "SELECT * FROM `parent_main_course` ORDER BY `id` DESC";
    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[$row['course_code']] = $row;
        }
    }
    return $ArrayResult;
}

function GetCourseModules($link)
{

    $ArrayResult = array();
    $sql = "SELECT `id`, `module_code`, `credit`, `module_name`, `duration`, `level`, `course_code`, `is_active` FROM `course_modules`";

    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[$row['module_code']] = $row;
        }
    }
    return $ArrayResult;
}
