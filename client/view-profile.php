<?php
require_once './include/configuration.php';
include './include/functions.php';

$CompanyInfo = GetCompanyInfo($link);
$UserDetails = GetUsers($link);
$JobProfile = GetJobApplications($link);
$IndexNo = $_GET['id'];

$UserFullDetails = GetFullUserDetails($link, $IndexNo);
$PageName = "Job Profile - " . $UserDetails[$IndexNo]["full_name"];
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<?php include './include/header.php'; ?>
	<style>
		.action-box {
			min-height: 265px;
		}

		.info-bx {
			min-height: 130px;
		}
	</style>
</head>

<body id="bg">
	<div class="page-wraper">
		<div id="loading-icon-bx"></div>
		<!-- Header Top ==== -->
		<?php include './component/header.php'; ?>
		<!-- header END ==== -->
		<!-- Content -->
		<div class="page-content bg-white">
			<!-- inner page banner -->
			<div class="page-banner ovbl-dark" style="background-image:url(<?= $breadcrumbs_bg ?>);">
				<div class="container">
					<div class="page-banner-entry">
						<h1 class="text-white">Profile - <?= $UserDetails[$IndexNo]["full_name"] ?></h1>
					</div>
				</div>
			</div>
			<!-- Breadcrumb row -->
			<div class="breadcrumb-row">
				<div class="container">
					<ul class="list-inline">
						<li><a href="#">Home</a></li>
						<li>Profile</li>
						<li><?= $UserDetails[$IndexNo]["full_name"] ?></li>
					</ul>
				</div>
			</div>
			<!-- Breadcrumb row END -->
			<!-- inner page banner END -->
			<div class="content-block">
				<!-- About Us -->
				<div class="section-area section-sp1">
					<div class="container">
						<div class="row">
							<div class="col-lg-3 col-md-4 col-sm-12 m-b30">
								<div class="profile-bx text-center">
									<div class="user-profile-thumb">
										<img src="assets/images/testimonials/no-profile.png" alt="" />
									</div>
									<div class="profile-info">
										<h4><?= $UserDetails[$IndexNo]["full_name"] ?></h4>
										<span><?= $UserDetails[$IndexNo]["email"] ?></span>
									</div>
									<div class="profile-social">
										<ul class="list-inline m-a0">
											<li><a href="#"><i class="fa fa-facebook"></i></a></li>
											<li><a href="#"><i class="fa fa-twitter"></i></a></li>
											<li><a href="#"><i class="fa fa-linkedin"></i></a></li>
											<li><a href="#"><i class="fa fa-google-plus"></i></a></li>
										</ul>
									</div>

									<div class="profile-tabnav">
										<ul class="nav nav-tabs">
											<li class="nav-item">
												<a class="nav-link active" data-toggle="tab" href="#overview"><i class="ti-info-alt"></i>Overview</a>
											</li>
											<li class="nav-item">
												<a class="nav-link" href="#courses"><i class="ti-book"></i>Courses</a>
											</li>
											<li class="nav-item">
												<a class="nav-link" href="#education"><i class="ti-bookmark-alt"></i>Education </a>
											</li>
											<li class="nav-item">
												<a class="nav-link" href="#contact"><i class="ti-user"></i>Contact </a>
											</li>
											<li class="nav-item">
												<a class="nav-link" href="#download"><i class="ti-save"></i>Download </a>
											</li>

										</ul>
									</div>
								</div>
							</div>
							<div class="col-lg-9 col-md-8 col-sm-12 m-b30">
								<div class="profile-content-bx">
									<div class="tab-content">
										<div class="tab-pane active" id="overview">
											<div class="profile-head">
												<h3>Overview</h3>
											</div>
											<div class="courses-filter">
												<div class="">

													<div class="row pb-3">
														<div class="col-md-2">
															<p>Name : </p>
														</div>
														<div class="col-md-10">
															<h5><?= ucwords(str_replace('.', '. ', strtolower($UserDetails[$IndexNo]["full_name"]))) ?></h5>
														</div>

														<div class="col-md-2">
															<p>Address : </p>
														</div>
														<div class="col-md-10">
															<h5><?= $UserFullDetails["address_line_1"] ?>, <?= $UserFullDetails["address_line_2"] ?>, <?= GetCityName($link, $UserFullDetails["city"])['name_en'] ?>, <?= GetDistrictName($link, $UserFullDetails["district"])['name_en'] ?></h5>
														</div>

														<div class="col-md-2">
															<p>Email : </p>
														</div>
														<div class="col-md-10">
															<h5><?= strtolower($UserDetails[$IndexNo]["email"]) ?></h5>
														</div>

														<div class="col-md-2">
															<p>NIC : </p>
														</div>
														<div class="col-md-10">
															<h5><?= strtoupper($UserFullDetails["nic"]) ?></h5>
														</div>

														<div class="col-md-2">
															<p>Date of Birth : </p>
														</div>
														<div class="col-md-10">
															<h5><?= $UserFullDetails["birth_day"] ?></h5>
														</div>

														<div class="col-md-2">
															<p>Gender : </p>
														</div>
														<div class="col-md-10">
															<h5><?= $UserFullDetails["gender"] ?></h5>
														</div>
													</div>

												</div>

												<div class="border-top pt-3" id="contact">
													<h4>Contact Details</h4>
													<div class="row pb-3">
														<div class="col-md-2">
															<p>Phone : </p>
														</div>
														<div class="col-md-10">
															<a href="tel:<?= $UserDetails[$IndexNo]["phone"] ?>">
																<h5><?= FormatPhone($UserDetails[$IndexNo]["phone"]) ?></h5>
															</a>
														</div>

														<div class="col-md-2">
															<p>Email : </p>
														</div>
														<div class="col-md-10">
															<a href="mailto:<?= $UserDetails[$IndexNo]["email"] ?>">
																<h5><?= strtolower($UserDetails[$IndexNo]["email"]) ?></h5>
															</a>
														</div>
													</div>
												</div>

												<div class="border-top pt-3" id="education">
													<h4>Education</h4>
													<div class="row">
														<div class="col-md-12 col-lg-12">
															<ul class="course-features">
																<li><i class="ti-check-box"></i> R/Dharmaloka Maha Vidyalaya</li>
															</ul>
														</div>
													</div>
												</div>


												<div class="border-top pt-3" id="courses">
													<h4 class="mb-4">Ceylon Pharma College Certification</h4>
													<div class="clearfix">
														<ul id="masonry" style="min-height:400px" class="ttr-gallery-listing magnific-image row">
															<?php
															$selected_id = $UserDetails[$IndexNo]["userid"];
															$sql = "SELECT `course_code` FROM `student_course` WHERE `student_id` LIKE '$selected_id'";
															$result = $link->query($sql);
															if ($result->num_rows > 0) {
																while ($row = $result->fetch_assoc()) {
																	$paid_amount = $discount_amount = $base_amount = 0;
																	$payment_status = "Not Paid";
																	$course_code = $row['course_code'];

																	$sql_inner = "SELECT `course_name`, `course_code`, `course_description`, `course_fee`, `registration_fee` FROM `course` WHERE `course_code` LIKE '$course_code'";
																	$result_inner = $link->query($sql_inner);
																	while ($row = $result_inner->fetch_assoc()) {
																		$course_name = $row['course_name'];
																		$course_fee = $row['course_fee'];
																		$registration_fee = $row['registration_fee'];
																		$base_amount = $registration_fee + $course_fee;
																		$due_amount = $course_fee + $registration_fee;
																	}

																	$sql_inner = "SELECT `payment_status`, `paid_amount`, `discount_amount` FROM `student_payment` WHERE `student_id` LIKE '$selected_id' AND `course_code` LIKE '$course_code'";
																	$result_inner = $link->query($sql_inner);
																	while ($row = $result_inner->fetch_assoc()) {
																		$payment_status = $row['payment_status'];
																		$paid_amount += $row['paid_amount'];
																		$discount_amount += $row['discount_amount'];
																		$due_amount -= ($paid_amount + $discount_amount);
																	}

																	$sql_inner = "SELECT `img_path` FROM `img_course` WHERE `course_code` LIKE '$course_code'";
																	$result_inner = $link->query($sql_inner);
																	while ($row = $result_inner->fetch_assoc()) {
																		$img_path = $row["img_path"];
																	}

															?>
																	<li class="action-card col-xl-4 col-lg-6 col-md-12 col-sm-6 publish" style="min-height: 265px;">
																		<div class="cours-bx">
																			<div class="action-box">
																				<img src="https://lms.pharmacollege.lk/<?php echo $img_path; ?>" alt="">
																				<a target="_blank" href="./courses-details?id=<?= $course_code ?>" class="btn">Read More</a>
																			</div>
																			<div class="info-bx text-center">
																				<h5><a target="_blank" href="./courses-details?id=<?= $course_code ?>"><?php echo $course_name; ?></a></h5>
																				<span class="rounded bg-success text-white p-1 px-2"> Result - <?= GetUserResults($link, $course_code, $IndexNo) ?></span>
																			</div>
																		</div>
																	</li>

																<?php
																}
															} else { ?>
																<div class="col-12">
																	<div class="alert alert-warning" role="alert">Not Enrolled to Ceylon Pharma College Courses</div>
																</div>
															<?php
															}
															?>
														</ul>
													</div>
												</div>


											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-12 text-right">
								<a href="#" class="btn mt-3">Contact</a>
								<a href="#" class="btn mt-3">Download CV</a>

							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- contact area END -->
		</div>
		<img src="assets/images/slider/ad2.jpg" alt="" style="width: 100%;" />
		<!-- Content END-->
		<!-- Footer ==== -->
		<footer>
			<div class="footer-top">
				<div class="pt-exebar">
					<div class="container">
						<div class="d-flex align-items-stretch">
							<div class="pt-logo mr-auto">
								<a href="index.html"><img src="assets/images/logo-white.png" alt="" /></a>
							</div>
							<div class="pt-social-link">
								<ul class="list-inline m-a0">
									<li><a href="#" class="btn-link"><i class="fa fa-facebook"></i></a></li>
									<li><a href="#" class="btn-link"><i class="fa fa-twitter"></i></a></li>
									<li><a href="#" class="btn-link"><i class="fa fa-linkedin"></i></a></li>
									<li><a href="#" class="btn-link"><i class="fa fa-google-plus"></i></a></li>
								</ul>
							</div>
							<div class="pt-btn-join">
								<a href="#" class="btn ">Join Now</a>
							</div>
						</div>
					</div>
				</div>
				<div class="container">
					<div class="row">
						<div class="col-lg-4 col-md-12 col-sm-12 footer-col-4">
							<div class="widget">
								<h5 class="footer-title">Sign Up For A Newsletter</h5>
								<p class="text-capitalize m-b20">Weekly Breaking news analysis and cutting edge advices on job searching.</p>
								<div class="subscribe-form m-b20">
									<form class="subscription-form" action="http://educhamp.themetrades.com/demo/assets/script/mailchamp.php" method="post">
										<div class="ajax-message"></div>
										<div class="input-group">
											<input name="email" required="required" class="form-control" placeholder="Your Email Address" type="email">
											<span class="input-group-btn">
												<button name="submit" value="Submit" type="submit" class="btn"><i class="fa fa-arrow-right"></i></button>
											</span>
										</div>
									</form>
								</div>
							</div>
						</div>
						<div class="col-12 col-lg-5 col-md-7 col-sm-12">
							<div class="row">
								<div class="col-4 col-lg-4 col-md-4 col-sm-4">
									<div class="widget footer_widget">
										<h5 class="footer-title">Company</h5>
										<ul>
											<li><a href="index.html">Home</a></li>
											<li><a href="about-1.html">About</a></li>
											<li><a href="faq-1.html">FAQs</a></li>
											<li><a href="contact-1.html">Contact</a></li>
										</ul>
									</div>
								</div>
								<div class="col-4 col-lg-4 col-md-4 col-sm-4">
									<div class="widget footer_widget">
										<h5 class="footer-title">Get In Touch</h5>
										<ul>
											<li><a href="http://educhamp.themetrades.com/admin/index.html">Dashboard</a></li>
											<li><a href="blog-classic-grid.html">Blog</a></li>
											<li><a href="portfolio.html">Portfolio</a></li>
											<li><a href="event.html">Event</a></li>
										</ul>
									</div>
								</div>
								<div class="col-4 col-lg-4 col-md-4 col-sm-4">
									<div class="widget footer_widget">
										<h5 class="footer-title">Courses</h5>
										<ul>
											<li><a href="courses.html">Courses</a></li>
											<li><a href="courses-details.html">Details</a></li>
											<li><a href="membership.html">Membership</a></li>
											<li><a href="profile.html">Profile</a></li>
										</ul>
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 col-lg-3 col-md-5 col-sm-12 footer-col-4">
							<div class="widget widget_gallery gallery-grid-4">
								<h5 class="footer-title">Our Gallery</h5>
								<ul class="magnific-image">
									<li><a href="assets/images/gallery/pic1.jpg" class="magnific-anchor"><img src="assets/images/gallery/pic1.jpg" alt=""></a></li>
									<li><a href="assets/images/gallery/pic2.jpg" class="magnific-anchor"><img src="assets/images/gallery/pic2.jpg" alt=""></a></li>
									<li><a href="assets/images/gallery/pic3.jpg" class="magnific-anchor"><img src="assets/images/gallery/pic3.jpg" alt=""></a></li>
									<li><a href="assets/images/gallery/pic4.jpg" class="magnific-anchor"><img src="assets/images/gallery/pic4.jpg" alt=""></a></li>
									<li><a href="assets/images/gallery/pic5.jpg" class="magnific-anchor"><img src="assets/images/gallery/pic5.jpg" alt=""></a></li>
									<li><a href="assets/images/gallery/pic6.jpg" class="magnific-anchor"><img src="assets/images/gallery/pic6.jpg" alt=""></a></li>
									<li><a href="assets/images/gallery/pic7.jpg" class="magnific-anchor"><img src="assets/images/gallery/pic7.jpg" alt=""></a></li>
									<li><a href="assets/images/gallery/pic8.jpg" class="magnific-anchor"><img src="assets/images/gallery/pic8.jpg" alt=""></a></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="footer-bottom">
				<div class="container">
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 text-center"> <a target="_blank" href="https://www.templateshub.net">Templates Hub</a></div>
					</div>
				</div>
			</div>
		</footer>
		<!-- Footer END ==== -->
		<button class="back-to-top fa fa-chevron-up"></button>
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