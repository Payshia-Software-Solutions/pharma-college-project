<?php
require_once './include/configuration.php';
include './include/functions.php';

$CompanyInfo = GetCompanyInfo($link);
$UserDetails = GetUsers($link);


$CourseCode = $_GET["CourseCode"];
$LoggedUser = $_GET["LoggedUser"];
$final_percentage_value = "Result Not Submitted";

$completeDate = "Not Set";

$sql_inner = "SELECT `CourseCode`, `CompleteDate` FROM `certificate_course_end_date` WHERE `CourseCode` LIKE '$CourseCode'";
$result_inner = $link->query($sql_inner);
if ($result_inner->num_rows > 0) {
	while ($row = $result_inner->fetch_assoc()) {
		$completeDate = $row["CompleteDate"];
	}
}
$PageName = "Academic Report - " . $LoggedUser;

$getSQL = "SELECT `id`, `company_name`, `company_address`, `company_address2`, `company_city`, `company_postalcode`, `company_email`, `company_telephone`, `company_telephone2`, `job_position` , `owner_name` FROM `company`";
$result = $link->query($getSQL);
if ($result->num_rows > 0) {
	while ($row = $result->fetch_assoc()) {
		$company_name = $row["company_name"];
		$company_address = $row["company_address"];
		$company_address2 = $row["company_address2"];
		$company_city = $row["company_city"];
		$company_postalcode = $row["company_postalcode"];
		$company_email = $row["company_email"];
		$company_telephone = $row["company_telephone"];
		$company_telephone2 = $row["company_telephone2"];
		$owner_name = $row["owner_name"];
		$job_position = $row["job_position"];
	}
}

$sql_inner = "SELECT `result` FROM `certificate_user_result` WHERE `index_number` LIKE '$LoggedUser' AND `course_code` LIKE '$CourseCode' AND `title_id` LIKE 'OverRallGrade'";
$result_inner = $link->query($sql_inner);
if ($result_inner->num_rows > 0) {
	while ($row = $result_inner->fetch_assoc()) {
		$final_percentage_value = $row['result'];
	}
}

$sql = "SELECT `course_name` FROM `course` WHERE `course_code` LIKE '$CourseCode'";
$result = $link->query($sql);
if ($result->num_rows > 0) {
	while ($row = $result->fetch_assoc()) {
		$course_name = $row['course_name'];
	}
}

if ($final_percentage_value == "Result Not Submitted") {
	$finalGrade = "Result Not Submitted";
} else {
	switch (true) {
		case $final_percentage_value >= 90:
			$finalGrade = "A+";
			break;
		case $final_percentage_value >= 80:
			$finalGrade = "A";
			break;
		case $final_percentage_value >= 75:
			$finalGrade = "A-";
			break;
		case $final_percentage_value >= 70:
			$finalGrade = "B+";
			break;
		case $final_percentage_value >= 65:
			$finalGrade = "B";
			break;
		case $final_percentage_value >= 60:
			$finalGrade = "B-";
			break;
		case $final_percentage_value >= 55:
			$finalGrade = "C+";
			break;
		case $final_percentage_value >= 45:
			$finalGrade = "C";
			break;
		case $final_percentage_value >= 40:
			$finalGrade = "C-";
			break;
		case $final_percentage_value >= 35:
			$finalGrade = "D+";
			break;
		case $final_percentage_value >= 30:
			$finalGrade = "D";
			break;
		case $final_percentage_value >= 0:
			$finalGrade = "E";
			break;
		default:
			$finalGrade = "Invalid input";
	}
}


$sql = "SELECT `id`, `student_id`, `username`, `civil_status`, `first_name`, `last_name`, `gender`, `address_line_1`, `address_line_2`, `city`, `postal_code`, `telephone_1`, `telephone_2`, `nic`, `e_mail`, `birth_day`, `updated_by`, `updated_at` FROM `user_full_details` WHERE `username` LIKE '$LoggedUser'";
$result = $link->query($sql);
while ($row = $result->fetch_assoc()) {
	$first_name = $row['first_name'];
	$last_name = $row['last_name'];
	$address_line_1 = $row['address_line_1'];
	$address_line_2 = $row['address_line_2'];
	$city = $row['city'];
	$postal_code = $row['postal_code'];
	$telephone_1 = $row['telephone_1'];
	$nic = $row['nic'];
	$e_mail = $row['e_mail'];
	$birth_day = $row['birth_day'];
	$user_name = $row['username'];
}

// Get City Name
$sql = "SELECT `id`, `district_id`, `name_en`, `name_si`, `name_ta`, `sub_name_en`, `sub_name_si`, `sub_name_ta`, `postcode`, `latitude`, `longitude` FROM `cities` WHERE `id` LIKE '$city'";
$result = $link->query($sql);
while ($row = $result->fetch_assoc()) {
	$city_name_en = $row['name_en'];
	$postcode = $row['postcode'];
}

$sql = "SELECT `id`, `student_id`, `username`, `civil_status`, `first_name`, `last_name`, `gender`, `address_line_1`, `address_line_2`, `city`, `district`, `postal_code`, `telephone_1`, `telephone_2`, `nic`, `e_mail`, `birth_day`, `updated_by`, `updated_at`, `full_name`, `name_with_initials`, `name_on_certificate` FROM `user_full_details` WHERE `username` LIKE '$LoggedUser'  ORDER BY `id` DESC";
$result = $link->query($sql);
if ($result->num_rows > 0) {
	while ($row = $result->fetch_assoc()) {
		$ArrayResult[$row['username']] = $row;
	}
}

$userDetails =  $ArrayResult[$LoggedUser];

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<?php include './include/header.php'; ?>
</head>

<body id="bg">
	<div class="page-wraper">
		<div id="loading-icon-bx"></div>
		<!-- Header Top ==== -->
		<?php include './component/header.php'; ?>
		<!-- Header Top END ==== -->
		<!-- Content -->
		<div class="page-content bg-white">
			<?php include './component/breadcrumbs.php'; ?>

			<div class="content-block">

				<!-- Popular Courses -->
				<?php include './component/result.php'; ?>
				<!-- Popular Courses END -->


				<!-- Testimonials -->
				<?php include './component/reviews.php'; ?>
				<!-- Testimonials END -->

				<!-- Popular Courses -->
				<?php include './component/cources.php'; ?>
				<!-- Popular Courses END -->


			</div>
			<!-- contact area END -->
		</div>
		<!-- Content END-->
		<!-- Footer ==== -->
		<?php include './include/footer.php'; ?>
		<!-- Footer END ==== -->
		<button class="back-to-top fa fa-chevron-up"></button>
	</div>

	<?php include './include/footer-scripts.php'; ?>
</body>

</html>