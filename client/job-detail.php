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
$UserDetails = GetUsers($link);
$PageName = "Vacancies";

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

		<!-- Header Top ==== -->
		<?php include './component/header.php'; ?>
		<!-- header END ==== -->
		<!-- Content -->
		<div class="page-content bg-white">
			<!-- inner page banner -->
			<div class="page-banner ovbl-dark" style="background-image:url(<?= $breadcrumbs_bg ?>);">
				<div class="container">
					<div class="page-banner-entry">
						<h1 class="text-white"><?= $Vacancy['display_name'] ?></h1>
					</div>
				</div>
			</div>
			<!-- Breadcrumb row -->
			<div class="breadcrumb-row">
				<div class="container">
					<ul class="list-inline">
						<li><a href="#">Home</a></li>
						<li><a href="./vacancies">Vacancies</a></li>
						<li><?= $Vacancy['display_name'] ?></li>
					</ul>
				</div>
			</div>
			<!-- Breadcrumb row END -->
			<div class="content-block">
				<div class="section-area section-sp1">
					<div class="container">
						<div class="row">
							<!-- Left part start -->
							<div class="col-lg-8 col-xl-8">
								<!-- blog start -->
								<div class="recent-news blog-lg">
									<div class="action-box blog-lg">
										<img src="assets/images/vacancy/<?= $Vacancy['img_url'] ?>" alt="">
									</div>
									<div class="info-bx">
										<ul class="media-post">
											<li><i class="fa fa-calendar"></i> <?= $formattedDate ?></li>
											<li><a href="./vacancies?city=<?= $Vacancy['city'] ?>"><i class="fa fa-map-marker"></i> <?= GetCityName($link, $Vacancy['city'])['name_en'] ?></a></li>
										</ul>
										<h5 class="post-title"><?= $Vacancy['display_name'] ?></h5>
										<?= $Vacancy['description'] ?>

										<hr>
										<h4>Contact Information</h4>
										<p>Tel : <a href="tel:<?= $Vacancy['whatsapp_number'] ?>"><?= $Vacancy['whatsapp_number'] ?></a></p>
										<p>Mail : <a href="mailto:<?= $Vacancy['email_address'] ?>"><?= $Vacancy['email_address'] ?></a></p>
										<div class="ttr-divider bg-gray"><i class="icon-dot c-square"></i></div>
										<div class="widget_tag_cloud">
											<h6>TAGS</h6>
											<div class="tagcloud">
												<a href="#">Pharmacist</a>
												<a href="#">Pharmacy Assistant</a>
												<a href="#">Assistant Pharmacy Trainee</a>
											</div>
										</div>
										<div class="ttr-divider bg-gray"><i class="icon-dot c-square"></i></div>
										<h6>SHARE </h6>
										<ul class="list-inline contact-social-bx">
											<li><a href="#" class="btn outline radius-xl"><i class="fa fa-facebook"></i></a></li>
											<li><a href="#" class="btn outline radius-xl"><i class="fa fa-twitter"></i></a></li>
											<li><a href="#" class="btn outline radius-xl"><i class="fa fa-linkedin"></i></a></li>
											<li><a href="#" class="btn outline radius-xl"><i class="fa fa-google-plus"></i></a></li>
										</ul>
										<div class="ttr-divider bg-gray"><i class="icon-dot c-square"></i></div>
									</div>
								</div>
								<!-- blog END -->
							</div>
							<!-- Left part END -->
							<!-- Side bar start -->
							<div class="col-lg-4 col-xl-4">
								<aside class="side-bar sticky-top">
									<div class="widget">
										<h6 class="widget-title">Search</h6>
										<div class="search-bx style-1">
											<form role="search" method="post">
												<div class="input-group">
													<input name="text" class="form-control" placeholder="Enter your keywords..." type="text">
													<span class="input-group-btn">
														<button type="submit" class="fa fa-search text-primary"></button>
													</span>
												</div>
											</form>
										</div>
									</div>
									<div class="widget recent-posts-entry">
										<h6 class="widget-title">Sponsored</h6>
										<?php
										if (!empty($Vacancies)) {
											$Count = 1;
											foreach ($Vacancies as $Vacancy) {

												$dateTime = new DateTime($Vacancy['date_time']);
												$formattedDate = $dateTime->format("M d Y");

												if ($Vacancy['status_active'] != "Active") {
													continue;
												}

												if ($Count++ >= 4) {
													break;
												}
										?>

												<div class="widget-post-bx">
													<div class="widget-post clearfix">
														<div class="ttr-post-media"> <img src="assets/images/vacancy/<?= $Vacancy['img_url'] ?>" width="200" height="143" alt=""> </div>
														<div class="ttr-post-info">
															<div class="ttr-post-header">
																<h6 class="post-title"><a href="./job-detail?id=<?= $Vacancy['quest_id'] ?>&title=<?= $Vacancy['display_name'] ?>">We are Looking for <?= $Vacancy['add_for'] ?></a></h6>
															</div>
															<ul class="media-post">
																<li><a href="#"><i class="fa fa-calendar"></i><?= $formattedDate ?></a></li>
																<li><a href="#"><i class="fa fa-user"></i><?= $Vacancy['display_name'] ?></a></li>
															</ul>
														</div>
													</div>
												</div>

										<?php
											}
										}
										?>
									</div>
									<div class="widget widget-newslatter">
										<h6 class="widget-title">Newsletter</h6>
										<div class="news-box">
											<p>Enter your e-mail and subscribe to our newsletter.</p>
											<form class="subscription-form" action="http://educhamp.themetrades.com/demo/assets/script/mailchamp.php" method="post">
												<div class="ajax-message"></div>
												<div class="input-group">
													<input name="dzEmail" required="required" type="email" class="form-control" placeholder="Your Email Address" />
													<button name="submit" value="Submit" type="submit" class="btn black radius-no">
														<i class="fa fa-paper-plane-o"></i>
													</button>
												</div>
											</form>
										</div>
									</div>
									<div class="widget widget_tag_cloud">
										<h6 class="widget-title">Tags</h6>
										<div class="tagcloud">
											<a href="#">Pharmacist</a>
											<a href="#">Pharmacy Assistant</a>
											<a href="#">Assistant Pharmacy Trainee</a>
										</div>
									</div>
								</aside>
							</div>
							<!-- Side bar END -->
						</div>
					</div>
				</div>
			</div>
		</div>
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
		<!-- scroll top button -->
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