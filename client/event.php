<?php
require_once './include/configuration.php';
include './include/functions.php';


$CompanyInfo = GetCompanyInfo($link);
$Courses = GetCourses($link);
$UserDetails = GetUsers($link);
$Instructors = GetInstructors($link);
$PageName = "Our Courses";

$Events =  GetPublicEvents($link);
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
						<h1 class="text-white">Events</h1>
					</div>
				</div>
			</div>
			<!-- Breadcrumb row -->
			<div class="breadcrumb-row">
				<div class="container">
					<ul class="list-inline">
						<li><a href="#">Home</a></li>
						<li>Events</li>
					</ul>
				</div>
			</div>
			<!-- Breadcrumb row END -->
			<!-- contact area -->
			<div class="content-block">
				<!-- Portfolio  -->
				<div class="section-area section-sp1 gallery-bx">
					<div class="container">
						<div class="feature-filters clearfix center m-b40">
							<ul class="filters" data-toggle="buttons">
								<li data-filter="" class="btn active">
									<input type="radio">
									<a href="#"><span>All</span></a>
								</li>
								<li data-filter="happening" class="btn">
									<input type="radio">
									<a href="#"><span>Happening</span></a>
								</li>
								<li data-filter="upcoming" class="btn">
									<input type="radio">
									<a href="#"><span>Upcoming</span></a>
								</li>
								<li data-filter="expired" class="btn">
									<input type="radio">
									<a href="#"><span>Expired</span></a>
								</li>
							</ul>
						</div>
						<div class="clearfix">
							<ul id="masonry" class="ttr-gallery-listing magnific-image row">
								<?php

								if (!empty($Events)) {
								?>

									<?php
									foreach ($Events as $Event) {

										$post_description = $Event["post_description"];
										if (strlen($post_description) > 150) {
											$post_description =  strip_tags(substr($post_description, 0, 150)) . "...";
										}

										$dateTime = new DateTime($Event['post_date']);
										$newDateFormat = $dateTime->format('Y-m-d');

										$date = new DateTime($Event["post_date"]);
										$SubDate = $date->format("Y-m-d");
										$EventDate = $date->format("d");
										$EventMonth = $date->format("F");
									?>
										<li class="action-card col-lg-6 col-md-6 col-sm-12 upcoming">
											<div class="event-bx m-b30">
												<div class="action-box">
													<img src="./web-admin-2.0/assets/images/event/<?= $Event['post_id'] ?>/cover/<?= $Event['post_cover'] ?>" alt="">
												</div>
												<div class="info-bx d-flex">
													<div>
														<div class="event-time">
															<div class="event-date"><?= $EventDate ?></div>
															<div class="event-month"><?= $EventMonth ?></div>
														</div>
													</div>
													<div class="event-info">
														<h4 class="event-title"><a href="#"><?= $Event["post_title"] ?></a></h4>
														<ul class="media-post">
															<li><a href="#"><i class="fa fa-clock-o"></i> 7:00am 8:00am</a></li>
															<li><a href="#"><i class="fa fa-map-marker"></i> <?= $Event["location"] ?></a></li>
														</ul>
														<p><?= $post_description ?></p>
													</div>
												</div>
											</div>
										</li>
								<?php
									}
								} else {
									$noPosts = "No Upcoming Events";
									echo $noPosts;
								}
								?>
							</ul>
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