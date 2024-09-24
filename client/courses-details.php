<?php
require_once './include/configuration.php';
include './include/functions.php';


$CompanyInfo = GetCompanyInfo($link);

$Courses = GetParentCourses($link);
if (isset($_GET['id'])) {
	$CourseCode = $_GET['id'];
} else {
	$CourseCode = reset($Courses)["course_code"];
}

$UserDetails = GetUsers($link);
$Instructors = GetInstructors($link);
$Outcomes = GetOutcomes($link, $CourseCode);
$courseModules = GetCourseModules($link);
// $Instructor = $Instructors[$Courses[$CourseCode]['instructor_id']];
$PageName = "Course Details | " . $Courses[$CourseCode]["course_name"];

$module_list = explode(",", $Courses[$CourseCode]['module_list']);
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
			<!-- inner page banner -->
			<div class="page-banner ovbl-dark" style="background-image:url(<?= $breadcrumbs_bg ?>);">
				<div class="container">
					<div class="page-banner-entry">
						<h1 class="text-white">Courses Details - <?= $Courses[$CourseCode]["course_name"] ?></h1>
					</div>
				</div>
			</div>
			<!-- Breadcrumb row -->
			<div class="breadcrumb-row">
				<div class="container">
					<ul class="list-inline">
						<li><a href="#">Home</a></li>
						<li><a href="./courses">Courses</a></li>
						<li>Courses Details - <?= $Courses[$CourseCode]["course_name"] ?></li>
					</ul>
				</div>
			</div>


			<!-- Breadcrumb row END -->
			<!-- inner page banner END -->
			<div class="content-block">
				<!-- About Us -->
				<div class="section-area section-sp1">
					<div class="container">
						<div class="row d-flex flex-row-reverse">
							<div class="col-lg-3 col-md-4 col-sm-12 m-b30">
								<div class="course-detail-bx">
									<div class="course-price">
										<del>Rs. <?= $Courses[$CourseCode]["course_fee"] + 10000 ?></del>
										<h4 class="price">Rs <?= number_format($Courses[$CourseCode]["course_fee"], 2) ?></h4>
									</div>
									<div class="course-buy-now text-center">
										<a href="./register" class="btn radius-xl text-uppercase">Enroll to This Courses</a>
									</div>
									<div class="teacher-bx">
										<div class="teacher-info">
											<div class="teacher-thumb">
												<img src="assets/images/testimonials/no-profile.png" alt="" />
											</div>
											<div class="teacher-name">
												<h5><?= $Courses[$CourseCode]['instructor_id'] ?></h5>
												<span>Instructor</span>
											</div>
										</div>
									</div>
									<div class="cours-more-info">
										<div class="review">
											<span>21 Review</span>
											<ul class="cours-star">
												<li class="active"><i class="fa fa-star"></i></li>
												<li class="active"><i class="fa fa-star"></i></li>
												<li class="active"><i class="fa fa-star"></i></li>
												<li class="active"><i class="fa fa-star"></i></li>
												<li class="active"><i class="fa fa-star"></i></li>
											</ul>
										</div>
										<div class="price categories">
											<span>Categories</span>
											<h5 class="text-primary">Pharmacist</h5>
										</div>
									</div>
									<div class="course-info-list scroll-page">
										<ul class="navbar">
											<li><a class="nav-link" href="#overview"><i class="ti-zip"></i>Overview</a></li>
											<li><a class="nav-link" href="#curriculum"><i class="ti-bookmark-alt"></i>Curriculum</a></li>
											<li><a class="nav-link" href="#instructor"><i class="ti-user"></i>Instructor</a></li>
											<li><a class="nav-link" href="#reviews"><i class="ti-comments"></i>Reviews</a></li>
										</ul>
									</div>
								</div>
							</div>

							<div class="col-lg-9 col-md-8 col-sm-12">
								<div class="courses-post">
									<div class="ttr-post-media media-effect">

										<a href="#"><img src="<?= $baseUrl ?>/assets/content/lms-management/assets/images/course-img/<?= $CourseCode ?>/<?= $Courses[$CourseCode]['course_img'] ?>" alt="Course Img - <?= $CourseCode ?>"></a>
									</div>
									<div class="ttr-post-info">
										<div class="ttr-post-title ">
											<h2 class="post-title"><?= $Courses[$CourseCode]["course_name"] ?></h2>
										</div>
										<div class="ttr-post-text">
											<p><?= $Courses[$CourseCode]["mini_description"] ?></p>
										</div>
									</div>
								</div>
								<div class="courese-overview" id="overview">
									<h4>Overview</h4>
									<div class="row">
										<div class="col-md-12 col-lg-4">
											<ul class="course-features">
												<li>
													<i class="ti-book"></i> <span class="label">Lectures</span>
													<span class="value"><?= $Courses[$CourseCode]["lecture_count"] ?></span>
												</li>

												<li>
													<i class="ti-time"></i> <span class="label">Duration</span>
													<span class="value"><?= $Courses[$CourseCode]["hours_per_lecture"] ?></span>
												</li>

												<li>
													<i class="ti-check-box"></i> <span class="label">Assessments</span>
													<span class="value"><?= $Courses[$CourseCode]["assessments"] ?></span>
												</li>

												<li>
													<i class="ti-smallcap"></i> <span class="label">Language</span>
													<span class="value"><?= $Courses[$CourseCode]["language"] ?></span>
												</li>

												<li>
													<i class="ti-help-alt"></i> <span class="label">Quizzes</span>
													<span class="value"><?= $Courses[$CourseCode]["quizzes"] ?></span>
												</li>

												<li>
													<i class="ti-stats-up"></i> <span class="label">Skill Level</span>
													<span class="value"><?= $Courses[$CourseCode]["skill_level"] ?></span>
												</li>

												<li>
													<i class="ti-user"></i> <span class="label">Students</span>
													<span class="value"><?= $Courses[$CourseCode]["head_count"] ?></span>
												</li>
											</ul>
										</div>
										<div class="col-md-12 col-lg-8">
											<h5 class="m-b5">Course Description</h5>
											<p><?= $Courses[$CourseCode]["course_description"] ?></p>

											<h5 class="m-b5">Certification</h5>
											<p><?= $Courses[$CourseCode]["certification"] ?></p>
											<h5 class="m-b5">Learning Outcomes</h5>
											<ul class="list-checked primary">
												<?php
												if (!empty($Outcomes)) {
													foreach ($Outcomes as $Outcome) {
												?>
														<li><?= $Outcome['outcome']; ?></li>
												<?php
													}
												}
												?>

											</ul>
										</div>
									</div>
								</div>
								<div class="m-b30" id="curriculum">
									<h4>Curriculum</h4>
									<ul class="curriculum-list">

										<li>
											<h5>First Level</h5>
											<ul>
												<?php
												if (!empty($module_list)) {
													foreach ($module_list as $moduleCode) {
														$Module = $courseModules[$moduleCode];

														if ($Module['level'] != 1) {
															continue;
														}
												?>
														<li>
															<div class="curriculum-list-box">
																<?= $Module['module_name'] ?>
															</div>
															<span><?= $Module['duration'] ?> Minutes</span>
														</li>
												<?php
													}
												}
												?>
											</ul>
										</li>
										<li>
											<h5>Second Level</h5>
											<ul>
												<?php
												if (!empty($module_list)) {
													foreach ($module_list as $moduleCode) {
														$Module = $courseModules[$moduleCode];

														if ($Module['level'] != 2) {
															continue;
														}
												?>
														<li>
															<div class="curriculum-list-box">
																<?= $Module['module_name'] ?>
															</div>
															<span><?= $Module['duration'] ?> Minutes</span>
														</li>
												<?php
													}
												}
												?>
											</ul>
										</li>
										<li>
											<h5>Final</h5>
											<ul>
												<?php
												if (!empty($module_list)) {
													foreach ($module_list as $moduleCode) {
														$Module = $courseModules[$moduleCode];

														if ($Module['level'] != 4) {
															continue;
														}
												?>
														<li>
															<div class="curriculum-list-box">
																<?= $Module['module_name'] ?>
															</div>
															<span><?= $Module['duration'] ?> Minutes</span>
														</li>
												<?php
													}
												}
												?>
											</ul>
										</li>
									</ul>
								</div>
								<div class="" id="instructor">
									<h4>Instructor</h4>
									<div class="instructor-bx">
										<div class="instructor-author">
											<img src="assets/images/testimonials/no-profile.png" alt="">
										</div>
										<div class="instructor-info">
											<h6><?= $Courses[$CourseCode]['instructor_id'] ?> </h6>
											<span>Instructor</span>
											<ul class="list-inline m-tb10">
												<li><a href="#" class="btn sharp-sm facebook"><i class="fa fa-facebook"></i></a></li>
												<li><a href="#" class="btn sharp-sm twitter"><i class="fa fa-twitter"></i></a></li>
												<li><a href="#" class="btn sharp-sm linkedin"><i class="fa fa-linkedin"></i></a></li>
												<li><a href="#" class="btn sharp-sm google-plus"><i class="fa fa-google-plus"></i></a></li>
											</ul>
											<!-- <p class="m-b0">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries</p> -->
										</div>
									</div>
								</div>
								<div class="" id="reviews">
									<h4>Reviews</h4>

									<div class="review-bx">
										<div class="all-review">
											<h2 class="rating-type">4.8</h2>
											<ul class="cours-star">
												<li class="active"><i class="fa fa-star"></i></li>
												<li class="active"><i class="fa fa-star"></i></li>
												<li class="active"><i class="fa fa-star"></i></li>
												<li class="active"><i class="fa fa-star"></i></li>
												<li><i class="fa fa-star"></i></li>
											</ul>
											<span>604 Rating</span>
										</div>
										<div class="review-bar">
											<div class="bar-bx">
												<div class="side">
													<div>5 star</div>
												</div>
												<div class="middle">
													<div class="bar-container">
														<div class="bar-5" style="width:90%;"></div>
													</div>
												</div>
												<div class="side right">
													<div>150</div>
												</div>
											</div>
											<div class="bar-bx">
												<div class="side">
													<div>4 star</div>
												</div>
												<div class="middle">
													<div class="bar-container">
														<div class="bar-5" style="width:70%;"></div>
													</div>
												</div>
												<div class="side right">
													<div>140</div>
												</div>
											</div>
											<div class="bar-bx">
												<div class="side">
													<div>3 star</div>
												</div>
												<div class="middle">
													<div class="bar-container">
														<div class="bar-5" style="width:50%;"></div>
													</div>
												</div>
												<div class="side right">
													<div>120</div>
												</div>
											</div>
											<div class="bar-bx">
												<div class="side">
													<div>2 star</div>
												</div>
												<div class="middle">
													<div class="bar-container">
														<div class="bar-5" style="width:40%;"></div>
													</div>
												</div>
												<div class="side right">
													<div>110</div>
												</div>
											</div>
											<div class="bar-bx">
												<div class="side">
													<div>1 star</div>
												</div>
												<div class="middle">
													<div class="bar-container">
														<div class="bar-5" style="width:20%;"></div>
													</div>
												</div>
												<div class="side right">
													<div>80</div>
												</div>
											</div>
										</div>

									</div>

									<p class="text-secondary">Based on Facebook and Google Reviews</p>
								</div>

							</div>

						</div>
					</div>
				</div>
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