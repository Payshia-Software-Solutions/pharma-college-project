<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once './include/configuration.php';
include './include/functions.php';

$Courses = GetParentCourses($link);

$CompanyInfo = GetCompanyInfo($link);
$UserDetails = GetUsers($link);
$Instructors = GetInstructors($link);
$PageName = "Register";

$CompanyInfo = GetCompanyInfo($link)[0];
$UserCount = count($UserDetails);
$CourseCount = count($Courses);
$LearnValue = 20000;


$cityList = GetCities($link);
$districtList = getDistricts($link);

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<?php include './include/header.php'; ?>


	<link rel="stylesheet" href="./vendor/select2/dist/css/select2.min.css">

	<style>
		.input-group-button {
			width: 100% !important;
		}

		/* Select2 container style */
		.select2-container {
			width: 100%;
		}

		/* Select2 dropdown style */
		.select2-dropdown {
			border: 1px solid #aaa;
			border-radius: 5px;
			box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
		}

		/* Select2 results style */
		.select2-results {
			max-height: 200px;
			overflow-y: auto;
		}

		/* Select2 option style */
		.select2-results__option {
			padding: 10px;
			user-select: none;
			cursor: pointer;
		}

		/* Hover effect on Select2 option */
		.select2-results__option--highlighted {
			background-color: #e1e1e1;
		}

		/* Select2 selection style */
		.select2-selection {
			border: 1px solid #aaa;
			border-radius: 5px;
		}

		/* Placeholder text style */
		.select2-selection__placeholder {
			color: #888;
		}

		/* Arrow icon in the Select2 dropdown */
		.select2-selection__arrow {
			border-color: #888 transparent transparent;
		}

		/* Clear button style in the Select2 */
		.select2-selection__clear {
			color: #888;
		}

		.select2-selection__rendered {

			border: 0px solid #8ca893 !important;
			line-height: 40px !important;
		}

		.select2-container .select2-selection--single {
			border: 1px solid #cedbd1 !important;
			height: 40px !important;
		}

		/* Disabled state style */
		.select2-container--disabled .select2-selection {
			background-color: #f4f4f4;
			cursor: not-allowed;
		}
	</style>
</head>

<body id="bg">
	<div class="page-wraper">
		<div id="loading-icon-bx"></div>

		<!-- Header Top ==== -->
		<?php include './component/header.php'; ?>
		<!-- header END ==== -->
		<!-- Inner Content Box ==== -->
		<div class="page-content bg-white">
			<!-- Page Heading Box ==== -->
			<div class="page-banner ovbl-dark" style="background-image:url(<?= $breadcrumbs_bg ?>);">
				<div class="container">
					<div class="page-banner-entry">
						<h1 class="text-white">Register</h1>
					</div>
				</div>
			</div>
			<div class="breadcrumb-row">
				<div class="container">
					<ul class="list-inline">
						<li><a href="#">Home</a></li>
						<li>Register</li>
					</ul>
				</div>
			</div>
			<!-- Page Heading Box END ==== -->
			<!-- Page Content Box ==== -->
			<div class="content-block">

				<!-- About Us ==== -->
				<div class="section-area section-sp1">
					<div class="container">



						<div class="row mt-5">
							<div class="col-lg-5 col-md-5 m-b30">
								<div class="bg-primary text-white contact-info-bx">
									<h2 class="m-b10 title-head">User <span>Registration</span></h2>

									<p class="d-none d-lg-block">Unlock your Ceylon Pharma College experience! Complete our quick, secure registration for personalized services. Join us now!
									</p>

									<p>ඔබේ Ceylon Pharma College අත්දැකීම විවෘත කරන්න! පුද්ගලාරෝපිත සේවාවන් සඳහා අපගේ ඉක්මන්, ආරක්ෂිත ලියාපදිංචිය සම්පූර්ණ කරන්න. දැන්ම අප හා එක්වන්න!"</p>

									<h5 class="m-t0">How to Register</h5>
									<iframe style="width: 100%; height:250px; border-radius:15px" src="https://www.youtube.com/embed/gvPE_zKPrpg" title="Ceylon Pharmacy" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>


								</div>
							</div>
							<div class="col-lg-7 col-md-7">

								<div class="row">
									<div class="col-12" id="register-form-message"></div>
									<div class="col-lg-12 m-b30" id="register-form">
										<form id="new-user-form" class="contact-bx ajax-form px-4" method="post">

											<div class="heading-bx left">
												<h2 class="title-head">Basic <span>Information</span></h2>
											</div>

											<div class="row placeani">


												<div class="col-lg-2">
													<div class="form-group">
														<div class="input-group">
															<!-- <label>Status (තත්ත්වය)</label> -->
															<select class="form-control w-100" id="status_id" name="status_id" required>
																<option value="Dr.">Dr.</option>
																<option value="Mr." selected>Mr.</option>
																<option value="Miss.">Miss.</option>
																<option value="Mrs.">Mrs.</option>
																<option value="Rev.">Rev.</option>
															</select>
														</div>
													</div>
												</div>

												<div class="col-lg-5">
													<div class="form-group">
														<div class="input-group">
															<label for="email" class="">First Name (මුල නම)</label>
															<input type="text" name="fname" id="fname" class="form-control" required>
														</div>
													</div>
												</div>

												<div class="col-lg-5">
													<div class="form-group">
														<div class="input-group">
															<label for="email" class="">Last Name (අග නම)</label>
															<input type="text" name="lname" id="lname" class="form-control" required>
														</div>
													</div>
												</div>

											</div>

											<div class="row placeani">

												<div class="col-lg-12">
													<div class="form-group">
														<div class="input-group">
															<label>Full Name (සම්පූර්ණ නම)</label>
															<input type="text" name="fullName" id="fullName" class="form-control" required>
														</div>
													</div>
												</div>

												<div class="col-lg-12">
													<div class="form-group">
														<div class="input-group">
															<label>Name with Initials (මුලකුරු සමග නම)</label>
															<input type="text" name="nameWithInitials" id="nameWithInitials" class="form-control" required>
														</div>
													</div>
												</div>


												<div class="col-lg-12">
													<div class="form-group">
														<div class="input-group">
															<label>Name On Certificate (සහතිකයේ සඳහන් විය යුතු නම)</label>
															<input type="text" name="nameOnCertificate" id="nameOnCertificate" class="form-control" required>
														</div>
													</div>
												</div>

												<div class="col-lg-6">
													<div class="form-group">
														<div class="input-group">
															<!-- <label>Gender (ස්‍ත්‍රී පුරුෂ බාවය)</label> -->
															<select class="form-control w-100" id="gender" name="gender" required>
																<option value="">Gender (ස්‍ත්‍රී පුරුෂ බාවය)</option>
																<option value="Male">Male</option>
																<option value="Female">Female</option>
															</select>
														</div>
													</div>
												</div>
												<div class="col-lg-6">
													<div class="form-group">
														<div class="input-group">
															<label>NIC Number (හැඳුනුම්පත් අංකය)</label>
															<input type="text" name="NicNumber" id="NicNumber" class="form-control" required>
														</div>
													</div>
												</div>

												<div class="col-lg-12">
													<div class="form-group">
														<div class="input-group">
															<select class="form-control w-100" id="selectedCourse" name="selectedCourse" required>
																<option value="">Select the Course (ලියාපදිංචි වන පාඨමාලාව)</option>
																<option value="Certificate Course in Pharmacy Practice">Certificate Course in Pharmacy Practice</option>

															</select>
														</div>
													</div>
												</div>

											</div>



											<div class="heading-bx left">
												<h2 class="title-head">Authentication <span>Information</span></h2>
											</div>

											<div class="row placeani">
												<div class="col-lg-6">
													<div class="form-group">
														<div class="input-group">
															<label>Password (මුරපදය)</label>
															<input type="password" name="password" id="password" autocomplete="off" class="form-control" required>
														</div>
													</div>
												</div>

												<div class="col-lg-6">
													<div class="form-group">
														<div class="input-group">
															<label>Confirm Password (නැවතත් මුරපදය)</label>
															<input type="password" name="confirmPassword" autocomplete="off" id="confirmPassword" class="form-control" required>
														</div>
													</div>
												</div>
											</div>

											<div class="heading-bx left">
												<h2 class="title-head">Contact <span>Information</span></h2>
											</div>

											<div class="row placeani">
												<div class="col-lg-12">
													<div class="form-group">
														<div class="input-group">
															<label>Email Address (විද්‍යුත් තැපෑල් ලිපිනය)</label>
															<input type="email" name="email" id="email" class="form-control" required>
														</div>
													</div>
												</div>

												<div class="col-lg-6">
													<div class="form-group">
														<div class="input-group">
															<label>Phone Number (දුරකථන අංකය)</label>
															<input type="number" name="phoneNumber" id="phoneNumber" class="form-control" required>
														</div>
													</div>
												</div>

												<div class="col-lg-6">
													<div class="form-group">
														<div class="input-group">
															<label>WhatsApp Number (වට්ස්ඇප් අංකය)</label>
															<input type="number" name="whatsAppNumber" id="whatsAppNumber" class="form-control" required>
														</div>
													</div>
												</div>


												<div class="col-lg-12">
													<div class="form-group">
														<div class="input-group">
															<label>Address Line 1 (ලිපිනයේ පළමු පේළ)</label>
															<input type="text" name="addressL1" id="addressL1" class="form-control" required>
														</div>
													</div>
												</div>

												<div class="col-lg-7">
													<div class="form-group">
														<div class="input-group">
															<label>Address Line 2 (ලිපිනයේ දෙවන පෙළ)</label>
															<input type="text" name="addressL2" id="addressL2" class="form-control" required>
														</div>
													</div>
												</div>

												<div class="col-lg-5">
													<div class="form-group">
														<div class="input-group">
															<select class="form-control js-example-basic-single" id="city" required name="city">
																<option value="">Choose City (ඔබ සිටින නගරය)</option>
																<?php
																//Get Module List
																$sql = "SELECT `id`, `district_id`, `name_en`, `name_si` FROM `cities` ORDER BY `name_en`";
																$sql_result = $link->query($sql);
																while ($row = $sql_result->fetch_assoc()) { ?>
																	<option value=" <?php echo $row["id"]; ?>"><?php echo $row["name_en"]; ?> - <?php echo $row["name_si"]; ?></option>
																<?php } ?>
															</select>
														</div>
													</div>
												</div>




											</div>

											<div class="row">
												<div class="col-12 text-end">
													<button onclick="JoinNow()" type="button" class="btn btn-warning w-100">
														Join Now
													</button>
												</div>
											</div>




										</form>
									</div>

								</div>
							</div>
						</div>


					</div>
				</div>
			</div>
			<!-- About Us END ==== -->
		</div>
		<!-- Page Content Box END ==== -->
	</div>



	<!-- Page Content Box END ==== -->
	<!-- Footer ==== -->
	<?php include './include/footer.php'; ?>
	<!-- Footer END ==== -->
	<button class="back-to-top fa fa-chevron-up"></button>
	</div>
	<?php include './include/footer-scripts.php'; ?>

	<script src="./vendor/select2/dist/js/select2.min.js"></script>
	<script>
		$('#city').select2()
		$('#status_id').select2()
		$('#gender').select2()
		$('#selectedCourse').select2()
	</script>