<?php
require_once './include/configuration.php';
include './include/functions.php';

$Vacancies = GetAdvertisements($link);

// Getting Parameters
if (isset($_GET['id'])) {
	$VacancyID = $_GET['id'];
} else {
	$VacancyID = reset($Vacancies)["quest_id"];
}

$CompanyInfo = GetCompanyInfo($link);
$Courses = GetCourses($link);
$UserDetails = GetUsers($link);
$PageName = "Login";

$Vacancy = $Vacancies[$VacancyID];
$dateTime = new DateTime($Vacancy['date_time']);
$formattedDate = $dateTime->format("M d Y");
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<?php include './include/header.php'; ?>
</head>

<body id="bg">
	<div class="page-wraper">
		<div id="loading-icon-bx"></div>
		<div class="account-form">
			<div class="account-head" style="background-image:url(assets/images/background/bg2.jpg);">
				<a href="index"><img src="assets/images/logo.png" alt="" style="width: 50%;"></a>
			</div>
			<div class="account-form-inner">
				<div class="account-container">
					<div class="heading-bx left">
						<h2 class="title-head">Login to your <span>Account</span></h2>
						<p>Don't have an account? <a href="register.html">Create one here</a></p>
					</div>
					<form class="contact-bx">
						<div class="row placeani">
							<div class="col-lg-12">
								<div class="form-group">
									<div class="input-group">
										<label>Your Name</label>
										<input name="dzName" type="text" required="" class="form-control">
									</div>
								</div>
							</div>
							<div class="col-lg-12">
								<div class="form-group">
									<div class="input-group">
										<label>Your Password</label>
										<input name="dzEmail" type="password" class="form-control" required="">
									</div>
								</div>
							</div>
							<div class="col-lg-12">
								<div class="form-group form-forget">
									<div class="custom-control custom-checkbox">
										<input type="checkbox" class="custom-control-input" id="customControlAutosizing">
										<label class="custom-control-label" for="customControlAutosizing">Remember me</label>
									</div>
									<a href="forget-password.html" class="ml-auto">Forgot Password?</a>
								</div>
							</div>
							<div class="col-lg-12 m-b30">
								<button name="submit" type="submit" value="Submit" class="btn button-md">Login</button>
							</div>
							<div class="col-lg-12">
								<h6>Login with Social media</h6>
								<div class="d-flex">
									<a class="btn flex-fill m-r5 facebook" href="#"><i class="fa fa-facebook"></i>Facebook</a>
									<a class="btn flex-fill m-l5 google-plus" href="#"><i class="fa fa-google-plus"></i>Google Plus</a>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- External JavaScripts -->
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/vendors/bootstrap/js/popper.min.js"></script>
	<script src="assets/vendors/bootstrap/js/bootstrap.min.js"></script>
	<script src="assets/vendors/bootstrap-select/bootstrap-select.min.js"></script>
	<script src="assets/vendors/bootstrap-touchspin/jquery.bootstrap-touchspin.js"></script>
	<script src="assets/vendors/magnific-popup/magnific-popup.js"></script>
	<script src="assets/vendors/counter/waypoints-min.js"></script>
	<script src="assets/vendors/counter/counterup.min.js"></script>
	<script src="assets/vendors/imagesloaded/imagesloaded.js"></script>
	<script src="assets/vendors/masonry/masonry.js"></script>
	<script src="assets/vendors/masonry/filter.js"></script>
	<script src="assets/vendors/owl-carousel/owl.carousel.js"></script>
	<script src="assets/js/functions.js"></script>
	<script src="assets/js/contact.js"></script>
	<script src='assets/vendors/switcher/switcher.js'></script>
</body>

</html>