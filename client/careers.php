<?php
require_once './include/configuration.php';
include './include/functions.php';

$CompanyInfo = GetCompanyInfo($link);
$UserDetails = GetUsers($link);
$PageName = "Careers";

$VacanciesAll = Vacancies($link);
$JobProfiles = GetJobApplications($link);
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<?php include './include/header.php'; ?>
</head>
<style>
	.tp-caption {
		background-color: none !important;

	}
</style>

<body id="bg">
	<div class="page-wraper">
		<div id="loading-icon-bx"></div>
		<!-- Header Top ==== -->
		<?php include './component/header.php'; ?>
		<!-- header END ==== -->
		<!-- Content -->


		<div class="page-content bg-white">
			<img src="assets/images/slider/slider.png" alt="" style="width: 100%;" />

			<div class="section-area section-sp1">
				<div class="container">
					<div class="row">
						<div class="col-lg-6 m-b30">
							<h2 class="title-head ">Browse the Biggest Job Market<br> <span class="text-primary"> on your finger tips</span></h2>
							<h4><span class="counter"><?= count($VacanciesAll) ?></span> Vacancies & <span class="counter"><?= count($JobProfiles) ?></span> Employees</h4>
							<p>Welcome to Sri Lanka's largest pharmaceutical job market! Whether you're a job seeker or an employer, our platform is ideal for finding employment or hiring talented professionals. Explore a wide range of job listings from top pharmaceutical companies and boost your career to new heights.</p>

							<p>Attract top talent by posting job advertisements on our user-friendly platform. Easily search and apply for jobs with our seamless interface. Use the "Post Ad" button to reach qualified candidates and showcase your company.</p>
							<a href="#" class="btn button-md">Post Your Ad</a>
						</div>
						<div class="col-lg-6">
							<div class="row">
								<div class="col-lg-6 col-md-6 col-sm-6 m-b30">
									<div class="feature-container">
										<div class="feature-md text-white m-b20">
											<a href="#" class="icon-cell"><img src="assets/images/icon/icon1.png" alt=""></a>
										</div>
										<div class="icon-content">
											<h5 class="ttr-tilte">Increase Job Listings</h5>
											<p>Attract diverse pharmaceutical job listings in Sri Lanka as your website's primary goal.</p>
										</div>
									</div>
								</div>
								<div class="col-lg-6 col-md-6 col-sm-6 m-b30">
									<div class="feature-container">
										<div class="feature-md text-white m-b20">
											<a href="#" class="icon-cell"><img src="assets/images/icon/icon2.png" alt=""></a>
										</div>
										<div class="icon-content">
											<h5 class="ttr-tilte">Build a Strong User Base</h5>
											<p>Build a large, active user base of job seekers and employers in the pharmaceutical industry.</p>
										</div>
									</div>
								</div>
								<div class="col-lg-6 col-md-6 col-sm-6 m-b30">
									<div class="feature-container">
										<div class="feature-md text-white m-b20">
											<a href="#" class="icon-cell"><img src="assets/images/icon/icon3.png" alt=""></a>
										</div>
										<div class="icon-content">
											<h5 class="ttr-tilte">Foster Engagement and Interactions</h5>
											<p>Promote interaction and networking among pharmaceutical professionals through messaging and forums.</p>
										</div>
									</div>
								</div>
								<div class="col-lg-6 col-md-6 col-sm-6 m-b30">
									<div class="feature-container">
										<div class="feature-md text-white m-b20">
											<a href="#" class="icon-cell"><img src="assets/images/icon/icon4.png" alt=""></a>
										</div>
										<div class="icon-content">
											<h5 class="ttr-tilte">Enhance User Experience</h5>
											<p>Focus on creating a user-friendly interface and intuitive navigation for job seekers and employers.</p>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- Main Slider -->
			<div class="section-area section-sp1 ovpr-dark bg-fix online-cours" style="background-image:url(assets/images/background/bg1.jpg);">
				<div class="container">
					<div class="row">
						<div class="col-md-12 text-center text-white">
							<h2>Just Search & get Your Job!</h2>
							<h5>Sri Lanka's No #01 Job Market for Grab Pharmaceutical jobs Island wide</h5>
							<form class="cours-search">
								<div class="input-group">
									<input type="text" class="form-control" placeholder="What you are Looking for?	">
									<div class="input-group-append">
										<button class="btn" type="submit">Search</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>

			<!-- Main Slider -->
			<div class="content-block">
				<!-- Popular Courses -->
				<div class="section-area section-sp2 popular-courses-bx">
					<div class="container">
						<?php

						?>
						<div class="row">
							<div class="col-md-12 heading-bx left">
								<h2 class="title-head">We Have Fully Trained <span><span class="counter"><?= count($JobProfiles) ?></span> Employees</span></h2>
								<p>You can Hire them. Explore more</p>
							</div>
						</div>
						<div class="row">
							<div class="courses-carousel owl-carousel owl-btn-1 col-12 p-lr0">
								<?php
								if (!empty($JobProfiles)) {
									foreach ($JobProfiles as $JobProfile) {
										$JobTitle = "Job Seeker";
										if ($JobProfile['job_id_phamacist'] == "Applied") {
											$JobTitle = "Pharmacist";
										} else if ($JobProfile['job_id_assistant'] == "Applied") {
											$JobTitle = "Pharmacy Assistant";
										} else if ($JobProfile['job_id_assistant_trainee'] == "Applied") {
											$JobTitle = "Assistance Pharmacy Trainee";
										}

										$FullUserDetails = GetFullUserDetails($link, $JobProfile['index_number']);
										$img_name = "no-profile.png";
										if ($FullUserDetails['gender'] == "Female") {
											$img_name = "no-profile-lady.png";
										}

								?>
										<div class="item">
											<div class="profile-bx text-center">
												<div class="user-profile-thumb">
													<a href="view-profile?id=<?= $JobProfile['index_number'] ?>&ref=<?= $UserDetails[$JobProfile['index_number']]['full_name'] ?>"><img src="assets/images/testimonials/<?= $img_name ?>" alt="" /></a>
												</div>
												<div class="profile-info" style="min-height: 80px;">
													<a href="view-profile?id=<?= $JobProfile['index_number'] ?>&ref=<?= $UserDetails[$JobProfile['index_number']]['full_name'] ?>">
														<h4><?= $UserDetails[$JobProfile['index_number']]['full_name'] ?></h4>
													</a>
													<span><?= $JobTitle ?></span>
												</div>
												<div class="profile-social">
													<ul class="list-inline m-a0">
														<li><a href="#"><i class="fa fa-linkedin"></i></a></li>
														<li><a href="#"><i class="fa fa-google-plus"></i></a></li>
														<li><a href="#"><i class="fa fa-facebook"></i></a></li>
														<li><a href="#"><i class="fa fa-twitter"></i></a></li>
													</ul>
												</div>
											</div>
										</div>
								<?php
									}
								}
								?>
							</div>
						</div>
						<div class="text-center">

							<a href="./job-profiles" class="btn button mt-4">View More</a>
						</div>
					</div>
				</div>
				<!-- Popular Courses End-->

			</div>
			<!-- contact area END -->

			<div class="section-area p-4 bg-fix ovbl-dark join-bx text-center mt-5" style="background-image:url(assets/images/background/bg1.jpg);">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<div class="join-content-bx text-white">
								<h2>Explore Island Wide</h2>
								<h4><span class="counter"><?= count($VacanciesAll) ?></span> Vacancies</h4>
								<a href="./vacancies" class="btn">View All</a>
							</div>
						</div>
					</div>
				</div>
			</div>


			<!-- Vacancies -->
			<div class="section-area section-sp2 popular-courses-bx">
				<div class="container">
					<?php
					$Vacancies = VacanciesCountByCity($link);
					?>
					<div class="row">
						<div class="col-md-12 heading-bx left">
							<h2 class="title-head">Browse Vacancies by City</span>
							</h2>
							<p>You can find them. Explore more</p>
						</div>
					</div>
					<div class="row">
						<?php
						if (!empty($Vacancies)) {
							foreach ($Vacancies as $Vacancy) {

						?>
								<div class="col-6 col-md-4 pb-4 item">
									<div class="profile-bx text-center">

										<div class="profile-info pt-3">
											<a href="./vacancies?city=<?= $Vacancy['city'] ?>">
												<h4><?= GetCityName($link, $Vacancy['city'])['name_en'] ?></h4>
											</a>
											<span><?= number_format($Vacancy['VacancyCount']) ?> ads</span>
										</div>
									</div>
								</div>
						<?php
							}
						}
						?>
					</div>
				</div>
			</div>
			<!-- Vacancies End-->

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