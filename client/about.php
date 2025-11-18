<?php
require_once './include/configuration.php';
include './include/functions.php';


$CompanyInfo = GetCompanyInfo($link);
$Courses = GetCourses($link);
$UserDetails = GetUsers($link);
$Instructors = GetInstructors($link);
$PageName = "About Us";

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
		<!-- header END ==== -->
		<!-- Inner Content Box ==== -->
		<div class="page-content bg-white">
			<!-- Page Heading Box ==== -->
			<div class="page-banner ovbl-dark" style="background-image:url(<?= $breadcrumbs_bg ?>);">
				<div class="container">
					<div class="page-banner-entry">
						<h1 class="text-white">About Us</h1>
					</div>
				</div>
			</div>
			<div class="breadcrumb-row">
				<div class="container">
					<ul class="list-inline">
						<li><a href="#">Home</a></li>
						<li>About Us</li>
					</ul>
				</div>
			</div>
			<!-- Page Heading Box END ==== -->
			<!-- Page Content Box ==== -->
			<div class="content-block">
				<!-- About Us ==== -->
				<div class="section-area section-sp1">
					<div class="container">
						<div class="row">
							<div class="col-lg-6 m-b30">
								<h2 class="title-head ">Learn a new skill online<br /> <span class="text-primary"> on your time</span></h2>
								<h4><span class="counter"><?= count($Courses) ?> </span> Online Courses</h4>
								<p>Our weekend course spans three months, led by industry professionals who cover both theory and practical aspects. You'll start with the fundamentals of pharmacy, learning how to effectively manage a pharmacy, read prescriptions, understand diseases, and choose the right medicines for patients. Moreover, you'll gain essential skills in medication control and quality maintenance.
								</p>
								<a href="#" class="btn button-md">Join Now</a>
							</div>
							<div class="col-lg-6">
								<div class="row">
									<div class="col-lg-6 col-md-6 col-sm-6 m-b30">
										<div class="feature-container">
											<div class="feature-md text-white m-b20">
												<a href="#" class="icon-cell"><img src="assets/images/icon/icon1.png" alt="" /></a>
											</div>
											<div class="icon-content">
												<h5 class="ttr-tilte">Our Mission</h5>
												<p>
													Our mission is simple yet impactful. It is to provide the best education through distance learning using online platforms. We are committed to empowering our community by equipping individuals with the knowledge and skills to shine as professionals. Our vision is to nurture excellence in every student.
												</p>
											</div>
										</div>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-6 m-b30">
										<div class="feature-container">
											<div class="feature-md text-white m-b20">
												<a href="#" class="icon-cell"><img src="assets/images/icon/icon4.png" alt="" /></a>
											</div>
											<div class="icon-content">
												<h5 class="ttr-tilte">Our Offering</h5>
												<p>At Ceylon Pharma College, our highly qualified educators do more than just teach, they train. We prepare you to be brilliant in the competitive field of pharmaceuticals. Our commitment doesn't end with education, we connect you with responsible employers, offering opportunities to kickstart your career in the private healthcare sector.
												</p>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- About Us END ==== -->
				<!-- Why Choose ==== -->
				<div class="section-area bg-gray section-sp2 choose-bx">
					<div class="container">
						<div class="row">
							<div class="col-md-12 heading-bx text-center">
								<h2 class="title-head text-uppercase m-b0">Why Choose <span> Our Institution</span></h2>
								<p>At Ceylon Pharma College, our highly qualified educators do more than just teach, they train. We prepare you to be brilliant in the competitive field of pharmaceuticals. Our commitment doesn't end with education, we connect you with responsible employers, offering opportunities to kickstart your career in the private healthcare sector.
								</p>
							</div>
						</div>


						<div class="row choose-bx-in">
							<div class="col-lg-4 col-md-4 col-sm-6">
								<div class="service-bx">
									<div class="action-box">
										<img src="assets/images/our-services/photo-1.png" alt="">
									</div>
									<div class="info-bx text-center">
										<div class="feature-box-sm radius bg-white">
											<i class="fa fa-bank text-primary"></i>
										</div>
										<h4><a href="#"><?= $web_content['service_1'] ?></a></h4>
										<!-- <a href="#" class="btn radius-xl">View More</a> -->
									</div>
								</div>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-6">
								<div class="service-bx">
									<div class="action-box">
										<img src="assets/images/our-services/photo-4.jpg" alt="">
									</div>
									<div class="info-bx text-center">
										<div class="feature-box-sm radius bg-white">
											<i class="fa fa-book text-primary"></i>
										</div>
										<h4><a href="#"><?= $web_content['service_2'] ?></a></h4>
										<!-- <a href="#" class="btn radius-xl">View More</a> -->
									</div>
								</div>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-12">
								<div class="service-bx m-b0">
									<div class="action-box">
										<img src="assets/images/our-services/photo-3.png" alt="">
									</div>
									<div class="info-bx text-center">
										<div class="feature-box-sm radius bg-white">
											<i class="fa fa-file-text-o text-primary"></i>
										</div>
										<h4><a href="#"><?= $web_content['service_3'] ?></a></h4>
										<!-- <a href="#" class="btn radius-xl">View More</a> -->
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- Why Choose END ==== -->
				<!-- Company Status ==== -->
				<div class="section-area content-inner section-sp1">
					<div class="container">
						<div class="section-content">
							<div class="row">
								<div class="col-lg-4 col-md-6 col-sm-6 col-6 m-b30">
									<div class="counter-style-1">
										<div class="text-primary">
											<span class="counter"><?= $UserCount ?></span><span>+</span>
										</div>
										<span class="counter-text">Over <?= $UserCount ?> student</span>
									</div>
								</div>
								<div class="col-lg-4 col-md-6 col-sm-6 col-6 m-b30">
									<div class="counter-style-1">
										<div class="text-black">
											<span class="counter"><?= $CourseCount ?></span><span>+</span>
										</div>
										<span class="counter-text"><?= $CourseCount ?> Courses.</span>
									</div>
								</div>
								<div class="col-lg-4 col-md-6 col-sm-6 col-6 m-b30">
									<div class="counter-style-1">
										<div class="text-primary">
											<span class="counter"><?= ThousandDivider($LearnValue) ?></span><?= ($LearnValue > 1000) ? "K" : "" ?></span><span>+</span>
										</div>
										<span class="counter-text">Learn Anything Online.</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- Company Stats END ==== -->
				<!-- Our Story ==== -->
				<div class="section-area bg-gray section-sp1 our-story">
					<div class="container">
						<div class="row align-items-center d-flex">
							<div class="col-lg-5 col-md-12 heading-bx">
								<h2 class="m-b10">Welcome to Ceylon Pharma College!</h2>
								<h5 class="fw4">It is a long established fact that a reade.</h5>
								<p>

									In a world where educational institutions faced unprecedented challenges, Ceylon Pharma College emerged as a light of innovative distance learning. We take pride in our dedicated team of professionals who ensured that our students continued to receive the best education even in trying times.

									Our mission is simple yet impactful. It is to provide the best education through distance learning using online platforms. We are committed to empowering our community by equipping individuals with the knowledge and skills to shine as professionals. Our vision is to nurture excellence in every student.
								</p>
								<a href="#" class="btn">Read More</a>
							</div>
							<div class="col-lg-7 col-md-12 heading-bx p-lr">

								<div class="video-bx">
									<video controls="" autoplay="" muted="" width="100%" style="border-radius: 10px;">
										<source src="./assets/video/home-video.mp4" type="video/mp4">
										Your browser does not support HTML video.
									</video>

								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- Our Story END ==== -->
				<!-- Testimonials ==== -->
				<div class="section-area section-sp2">
					<div class="container">
						<div class="row">
							<div class="col-md-12 heading-bx left">
								<h2 class="title-head text-uppercase">what people <span>say</span></h2>
								<p>It is a long established fact that a reader will be distracted by the readable content of a page</p>
							</div>
						</div>
						<div class="testimonial-carousel owl-carousel owl-btn-1 col-12 p-lr0">
							<div class="item">
								<div class="testimonial-bx">
									<div class="testimonial-thumb">
										<img src="assets/images/testimonials/no-profile.png" alt="">
									</div>
									<div class="testimonial-info">
										<h5 class="name">Gaguli Ashinshana
										</h5>
										<p>-Student</p>
									</div>
									<div class="testimonial-content">
										<p>Ceylon Pharma College is the best place to learn about medicine. A most successful course that can be done without fear. You can get knowledge through the latest methods and you don't have to study to death. You can learn quickly. The best place that gives knowledge worth more than the money charged. Even those without a purpose get a purpose. Another good meaningful way to win in life. Thank you sir for giving us this knowledge.
										</p>
									</div>
								</div>
							</div>
							<div class="item">
								<div class="testimonial-bx">
									<div class="testimonial-thumb">
										<img src="assets/images/testimonials/no-profile.png" alt="">
									</div>
									<div class="testimonial-info">
										<h5 class="name">Dimuthu Ishara</h5>
										<p>-Student</p>
									</div>
									<div class="testimonial-content">
										<p>Excellent course I have met. Very good sir and nice class. I have no words to say. I got lots of experience in this class. If you like to learn midecine and pharmacy this is the right place. Please join this course. So i invite all my friends and make your future beautiful.. we Love you soo much sir❤❤❤</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- Testimonials END ==== -->
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