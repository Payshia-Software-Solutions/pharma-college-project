<?php
require_once './include/configuration.php';
include './include/functions.php';

$CompanyInfo = GetCompanyInfo($link);
$UserDetails = GetUsers($link);
$courseModules = GetCourseModules($link);


$PageName = "Certificate Verification";

$studentNumber = $_GET["LoggedUser"];
$courseCode = $_GET["CourseCode"];
$courseCode = 'CS0001';

$pageUrl = 'https://pharmacollege.lk/certificate-verification';

$shareUrlArray = array(
	'linkedin' => array(
		'url' => 'https://www.linkedin.com/shareArticle?url=',
		'icon' => 'linkedin.png',
		'alt' => 'Share on LinkedIn'
	),
	'facebook' => array(
		'url' => 'https://www.facebook.com/sharer/sharer.php?u=',
		'icon' => 'facebook.png',
		'alt' => 'Share on Facebook'
	),
	'twitter' => array(
		'url' => 'https://twitter.com/intent/tweet?url=',
		'icon' => 'twitter.png',
		'alt' => 'Share on Twitter'
	)
);
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<?php include './include/header.php'; ?>

	<meta prefix="og: http://ogp.me/ns#" property="og:type" content="website" />
	<meta prefix="og: http://ogp.me/ns#" property="og:title" content="Completion Certificate for <?= $Courses[$courseCode]["course_name"] ?>" />
	<meta prefix="og: http://ogp.me/ns#" property="og:description" content="This certificate verifies my successful completion of Ceylon Pharma College's &quot;<?= $Courses[$courseCode]["course_name"] ?>&quot; on Ceylon Pharma College" />
	<meta prefix="og: http://ogp.me/ns#" property="og:image" content="<?= $baseUrl ?>/assets/content/lms-management/assets/images/student-certificates/<?= $studentNumber ?>/CeylonPharmaCollege-e-Certificate-<?= $studentNumber ?>.jpg" />
	<meta prefix="og: http://ogp.me/ns#" property="og:url" content="https://pharmacollege.lk/certificate-verification?studentNumber=<?= $studentNumber ?>" />

	<!--Insert Twitter Card Markup -->

	<meta name="twitter:card" content="summary_large_image" />
	<meta name="twitter:site" content="@YourTwitterUsername" />
	<meta name="twitter:domain" content="https://pharmacollege.lk/certificate-verification" />
	<meta name="twitter:title" content="Completion Certificate for <?= $Courses[$courseCode]["course_name"] ?>" />
	<meta name="twitter:description" content="This certificate verifies my successful completion of Ceylon Pharma College's &quot;<?= $Courses[$courseCode]["course_name"] ?>&quot; on Ceylon Pharma College" />
	<meta name="twitter:image" content="<?= $baseUrl ?>/assets/content/lms-management/assets/images/student-certificates/<?= $studentNumber ?>/CeylonPharmaCollege-e-Certificate-<?= $studentNumber ?>.jpg" />


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
						<h1 class="text-white">Certificate Verification</h1>
					</div>
				</div>
			</div>
			<!-- Breadcrumb row -->
			<div class="breadcrumb-row">
				<div class="container">
					<ul class="list-inline">
						<li><a href="#">Home</a></li>
						<li><a href="./courses">Courses</a></li>
						<li>Certificate Verification</li>
					</ul>
				</div>
			</div>

			<style>
				.user-photo-container {
					position: relative;
				}

				.user-photo-container__icon-background {
					position: absolute;
					border-radius: 150px;
					top: 1px;
					right: 3px;
					z-index: 99;
					height: 20px;
					width: 20px;
					background-color: #fff;
				}

				.profile-img-certificate {
					border-radius: 50%;
				}

				.e-certificate {
					border: 8px double #8c968f;
				}

				.social-share-icon {
					width: 40px;
					margin: 0 5px 0 0;
				}

				.social-share-box {
					margin-top: 15px;
				}
			</style>

			<?php
			$module_list = explode(",", $Courses[$courseCode]['module_list']);
			?>

			<!-- Breadcrumb row END -->
			<!-- inner page banner END -->
			<div class="content-block">
				<!-- About Us -->
				<div class="section-area section-sp1">
					<div class="container">
						<div class="row d-flex flex-row-reverse mb-5">
							<div class="col-lg-6 ">
								<img class="e-certificate" src="<?= $baseUrl ?>/assets/content/lms-management/assets/images/student-certificates/<?= $studentNumber ?>/CeylonPharmaCollege-e-Certificate-<?= $studentNumber ?>.jpg">


								<div class="social-share-box">
									<h6>Share this Certification on</h6>
									<?php
									foreach ($shareUrlArray as $urlArray) {
									?>
										<a href="<?= $urlArray['url'] ?><?= $pageUrl ?>" target="_blank" rel="noopener noreferrer">
											<img src="./assets/images/social/<?= $urlArray['icon'] ?>" alt="<?= $urlArray['alt'] ?>" class="social-share-icon">
										</a>
									<?php
									}
									?>


								</div>
							</div>

							<div class="col-lg-6 mt-5 mt-lg-3">
								<p class="mb-0 text-muted">Course Certificate</p>
								<h4><?= $Courses[$courseCode]["course_name"] ?></h4>

								<div class="bg-light p-4 mt-4">
									<div class="row">
										<div class="col-3">
											<div class="user-photo-container">
												<img src="<?= $baseUrl ?>/assets/content/lms-management/assets/images/profile-img/all.jpg" alt="All" class="profile-img-certificate">
												<svg class="_ufjrdd" aria-hidden="true" focusable="false" style="fill:#0d00ff;height:24px;width:24px;position:absolute;right:0;z-index:100" viewBox="0 0 48 48" role="img" aria-labelledby="SolidCheck9e3f210f-c8ab-4e47-c74e-e2e60e651e0f SolidCheck9e3f210f-c8ab-4e47-c74e-e2e60e651e0fDesc" xmlns="http://www.w3.org/2000/svg">
													<path d="M1 24C1 11.318375 11.318375 1 24 1s23 10.318375 23 23-10.318375 23-23 23S1 36.681625 1 24zm20.980957 4.2558594l-7.7418213-7.0596924L12 23.5592041l9.980957 9.6016846 15.2832032-16.4852295L34.9130859 14 21.980957 28.2558594z" role="presentation"></path>
												</svg>


											</div>
										</div>
										<div class="col-9">
											<h4>Completed by Gamage Thilina Ruwan Kumara Doloswala</h4>
											<h6>March 25, 2024</h6>
											<p>Gamage Thilina Ruwan Kumara Doloswala's account is verified. Ceylon Pharma College certifies their successful completion of <?= $Courses[$courseCode]["course_name"] ?></p>
										</div>
									</div>
								</div>

								<div class="mt-5">
									<div class="row">
										<div class="col-8">
											<h5 class="mb-0"><a href="/courses-details?id=<?= $courseCode ?>"><?= $Courses[$courseCode]["course_name"] ?></a></h5>
											<p class="mb-0">Ceylon Pharma College</p>
										</div>
										<div class="col-4">
											<a href="/courses-details?id=<?= $courseCode ?>"><button class="btn btn-primary w-100">View Course</button>
											</a>
										</div>
										<div class="col-12">
											<div class="review d-flex flex-row">
												<span class="mr-2">45 Review</span>
												<ul class="cours-star">
													<li class="active"><i class="fa fa-star"></i></li>
													<li class="active"><i class="fa fa-star"></i></li>
													<li class="active"><i class="fa fa-star"></i></li>
													<li class="active"><i class="fa fa-star"></i></li>
													<li><i class="fa fa-star"></i></li>
												</ul>
												<div class="mx-2">
													| 2154 Students Enrolled
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="col-12 mt-5">
								<div class="border-1 bg-light p-4 mt-3">
									<h4>What you learn in <?= $Courses[$courseCode]["course_name"] ?></h4>
									<div class="row">

										<?php
										if (!empty($module_list)) {
											foreach ($module_list as $moduleCode) {
												$Module = $courseModules[$moduleCode];
										?>
												<div class="col-6">
													<li>
														<?= $Module['module_name'] ?>

													</li>
												</div>
										<?php
											}
										}
										?>
									</div>



									<h4 class="mt-4 mb-2">About this Course</h4>
									<p class="mb-0"><?= $Courses[$courseCode]["mini_description"] ?></p>
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