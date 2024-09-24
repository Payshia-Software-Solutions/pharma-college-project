<?php
require_once './include/configuration.php';
include './include/functions.php';

$CompanyInfo = GetCompanyInfo($link);
$UserDetails = GetUsers($link);

$PageName = "Job Profiles";


$VacanciesAll = Vacancies($link);
$JobProfiles = GetJobApplications($link);
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
		<!-- header END -->
		<!-- Inner Content Box ==== -->
		<div class="page-content bg-white">
			<!-- Page Heading Box ==== -->
			<div class="page-banner ovbl-dark" style="background-image:url(<?= $breadcrumbs_bg ?>);">
				<div class="container">
					<div class="page-banner-entry">
						<h1 class="text-white">Job Profiles</h1>
					</div>
				</div>
			</div>
			<div class="breadcrumb-row">
				<div class="container">
					<ul class="list-inline">
						<li><a href="#">Home</a></li>
						<li>Job Profiles</li>
					</ul>
				</div>
			</div>
			<!-- Page Heading Box END ==== -->
			<!-- Page Content Box ==== -->
			<div class="content-block">
				<!-- Blog Grid ==== -->
				<div class="section-area section-sp1">
					<div class="container">
						<div class="ttr-blog-grid-3 row" id="masonry">

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
									<div class="post action-card col-lg-3 col-md-4 col-sm-12 col-xs-12 m-b40 d-flex">
										<div class="item flex-fill">
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
									</div>
							<?php
								}
							}
							?>
						</div>
						<!-- Pagination ==== -->
						<div class="pagination-bx rounded-sm gray clearfix">
							<ul class="pagination">
								<li class="previous"><a href="#"><i class="ti-arrow-left"></i> Prev</a></li>
								<li class="active"><a href="#">1</a></li>
								<li class="next"><a href="#">Next <i class="ti-arrow-right"></i></a></li>
							</ul>
						</div>
						<!-- Pagination END ==== -->
					</div>
				</div>
				<!-- Blog Grid END ==== -->
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
</body>

</html>