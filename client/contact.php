<?php
require_once './include/configuration.php';
include './include/functions.php';


$CompanyInfo = GetCompanyInfo($link)[0];
$UserDetails = GetUsers($link);
$Instructors = GetInstructors($link);
$PageName = "Contact Us";

$UserCount = count($UserDetails);
$CourseCount = count($Courses);
$LearnValue = 20000;
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
						<li><?= $PageName ?></li>
					</ul>
				</div>
			</div>
			<!-- Breadcrumb row END -->

			<!-- inner page banner -->
			<div class="page-banner contact-page section-sp2">
				<div class="container">
					<div class="row">
						<div class="col-lg-5 col-md-5 m-b30">
							<div class="bg-primary text-white contact-info-bx">
								<h2 class="m-b10 title-head">Contact <span>Information</span></h2>
								<p>In a world where educational institutions faced unprecedented challenges, Ceylon Pharma College emerged as a light of innovative distance learning. We take pride in our dedicated team of professionals who ensured that our students continued to receive the best education even in trying times.
								</p>
								<div class="widget widget_getintuch">
									<ul>
										<li><i class="ti-location-pin"></i><?= $CompanyInfo['company_address'] ?>, <?= $CompanyInfo['company_address2'] ?>, <?= $CompanyInfo['company_city'] ?>, <?= $CompanyInfo['company_postalcode'] ?></li>
										<li><i class="ti-mobile"></i> <?= $CompanyInfo['company_telephone'] ?> (24/7 Support Line)</li>
										<li><i class="ti-email"></i>info@pharmacollege.com</li>
									</ul>
								</div>
								<h5 class="m-t0 m-b20">Follow Us</h5>
								<ul class="list-inline contact-social-bx">
									<li><a href="#" class="btn outline radius-xl"><i class="fa fa-facebook"></i></a></li>
									<li><a href="#" class="btn outline radius-xl"><i class="fa fa-twitter"></i></a></li>
									<li><a href="#" class="btn outline radius-xl"><i class="fa fa-linkedin"></i></a></li>
									<li><a href="#" class="btn outline radius-xl"><i class="fa fa-google-plus"></i></a></li>
								</ul>
							</div>
						</div>
						<div class="col-lg-7 col-md-7">
							<form class="contact-bx ajax-form" action="http://educhamp.themetrades.com/demo/assets/script/contact.php">
								<div class="ajax-message"></div>
								<div class="heading-bx left">
									<h2 class="title-head">Get In <span>Touch</span></h2>
									<p>It is a long established fact that a reader will be distracted by the readable content of a page</p>
								</div>
								<div class="row placeani">
									<div class="col-lg-6">
										<div class="form-group">
											<div class="input-group">
												<label>Your Name</label>
												<input name="name" type="text" required class="form-control valid-character">
											</div>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group">
											<div class="input-group">
												<label>Your Email Address</label>
												<input name="email" type="email" class="form-control" required>
											</div>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group">
											<div class="input-group">
												<label>Your Phone</label>
												<input name="phone" type="text" required class="form-control int-value">
											</div>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group">
											<div class="input-group">
												<label>Subject</label>
												<input name="subject" type="text" required class="form-control">
											</div>
										</div>
									</div>
									<div class="col-lg-12">
										<div class="form-group">
											<div class="input-group">
												<label>Type Message</label>
												<textarea name="message" rows="4" class="form-control" required></textarea>
											</div>
										</div>
									</div>
									<div class="col-lg-12">
										<div class="form-group">
											<div class="input-group">
												<div class="g-recaptcha" data-sitekey="6Lf2gYwUAAAAAJLxwnZTvpJqbYFWqVyzE-8BWhVe" data-callback="verifyRecaptchaCallback" data-expired-callback="expiredRecaptchaCallback"></div>
												<input class="form-control d-none" style="display:none;" data-recaptcha="true" required data-error="Please complete the Captcha">
											</div>
										</div>
									</div>
									<div class="col-lg-12">
										<button name="submit" type="submit" value="Submit" class="btn button-md"> Send Message</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			<!-- inner page banner END -->
		</div>
		<!-- Content END-->
		<!-- Footer ==== -->
		<?php include './include/footer.php'; ?>
		<!-- Footer END ==== -->
		<button class="back-to-top fa fa-chevron-up"></button>
	</div>

	<?php include './include/footer-scripts.php'; ?>