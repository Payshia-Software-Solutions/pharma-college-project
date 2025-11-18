<?php
require_once './include/configuration.php';
include './include/functions.php';


$CompanyInfo = GetCompanyInfo($link);
$UserDetails = GetUsers($link);
$Instructors = GetInstructors($link);
$PageName = "Our Courses";
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
		<!-- header END ==== -->
		<!-- Content -->
		<div class="page-content bg-white">
			<!-- inner page banner -->
			<div class="page-banner ovbl-dark" style="background-image:url(<?= $breadcrumbs_bg ?>);">
				<div class="container">
					<div class="page-banner-entry">
						<h1 class="text-white"><?= $PageName ?></h1>
					</div>
				</div>
			</div>
			<!-- Breadcrumb row -->
			<div class="breadcrumb-row">
				<div class="container">
					<ul class="list-inline">
						<li><a href="#">Home</a></li>
						<li>Our Courses</li>
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
								<div class="widget courses-search-bx placeani">
									<div class="form-group">
										<div class="input-group">
											<label>Search Courses</label>
											<input name="dzName" type="text" required class="form-control">
										</div>
									</div>
								</div>
								<div class="widget widget_archive">
									<h5 class="widget-title style-1">All Courses</h5>
									<ul>
										<li class="active"><a href="#">Pharmacist</a></li>
										<li><a href="#">English</a></li>
										<li><a href="#">IT & Software</a></li>
										<li><a href="#">Programming Language</a></li>
									</ul>
								</div>
								<div class="widget">
									<h4>Recommendation</h4>
									<a href="./courses-details?id=<?= reset($Courses)["course_code"] ?>">
										<img src="<?= $baseUrl ?>/assets/content/lms-management/assets/images/course-img/<?= reset($Courses)["course_code"] ?>/<?= reset($Courses)["course_img"] ?>" alt="CourseImg" class="rounded" />
									</a>
									<h5 class="mt-2"><a href="./courses-details?id=<?= reset($Courses)["course_code"] ?>"><?= reset($Courses)['course_name'] ?></a></h5>
								</div>
								<div class="widget recent-posts-entry widget-courses">
									<h5 class="widget-title style-1">Recent Courses</h5>
									<?php
									if (!empty($Courses)) {
										$Count = 1;
										foreach ($Courses as $Course) {
											if ($Count == 3) {
												break;
											}
									?>
											<div class="widget-post-bx">
												<div class="widget-post clearfix">
													<div class="ttr-post-media">

														<img src="<?= $baseUrl ?>/assets/content/lms-management/assets/images/course-img/<?= $Course['course_code'] ?>/<?= $Course['course_img'] ?>" width="200" height="143" alt="">
													</div>
													<div class="ttr-post-info">
														<div class="ttr-post-header">
															<h6 class="post-title"><a href="./courses-details?id=<?= $Course['course_code'] ?>"><?= $Course['course_name'] ?></a></h6>
														</div>
														<div class="ttr-post-meta">
															<ul>
																<li class="price">
																	<del>Rs <?= number_format($Course['course_fee'] + 10000, 2) ?></del>
																	<h5>Rs <?= number_format($Course['course_fee'], 2) ?></h5>
																</li>
															</ul>
														</div>
													</div>
												</div>
											</div>
									<?php
											$Count++;
										}
									}
									?>
								</div>
							</div>
							<div class="col-lg-9 col-md-8 col-sm-12">
								<div class="row">
									<?php
									if (!empty($Courses)) {
										foreach ($Courses as $Course) {
									?>

											<div class="col-md-6 col-lg-4 col-sm-6 m-b30">
												<div class="cours-bx">
													<div class="action-box">
														<img src="<?= $baseUrl ?>/assets/content/lms-management/assets/images/course-img/<?= $Course['course_code'] ?>/<?= $Course['course_img'] ?>" alt="">
														<a href="./courses-details?id=<?= $Course['course_code'] ?>" class="btn">Read More</a>
													</div>
													<div class="info-bx text-center">
														<h5><a href="./courses-details?id=<?= $Course['course_code'] ?>"><?= $Course['course_name'] ?></a></h5>
														<span>Pharmacist</span>
													</div>
													<div class="cours-more-info">
														<div class="review">
															<span>3 Review</span>
															<ul class="cours-star">
																<li class="active"><i class="fa fa-star"></i></li>
																<li class="active"><i class="fa fa-star"></i></li>
																<li class="active"><i class="fa fa-star"></i></li>
																<li><i class="fa fa-star"></i></li>
																<li><i class="fa fa-star"></i></li>
															</ul>
														</div>
														<div class="price">
															<del>Rs <?= number_format($Course['course_fee'] + 10000, 2) ?></del>
															<h5>Rs <?= number_format($Course['course_fee'], 2) ?></h5>
														</div>
													</div>
												</div>
											</div>
									<?php
										}
									}
									?>


									<div class="col-lg-12 m-b20">
										<div class="pagination-bx rounded-sm gray clearfix">
											<ul class="pagination">
												<li class="previous"><a href="#"><i class="ti-arrow-left"></i> Prev</a></li>
												<li class="active"><a href="#">1</a></li>
												<li class="next"><a href="#">Next <i class="ti-arrow-right"></i></a></li>
											</ul>
										</div>
									</div>
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