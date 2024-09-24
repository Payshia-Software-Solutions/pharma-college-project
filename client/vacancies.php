<?php
require_once './include/configuration.php';
include './include/functions.php';

$CompanyInfo = GetCompanyInfo($link);
$UserDetails = GetUsers($link);
$PageName = "Vacancies";

$id = "All";
if (isset($_GET['add_type'])) {
	$id = $_GET['add_type'];
}

if (isset($_GET['city'])) {
	$city = $_GET['city'];
}

$Vacancies = array_reverse(GetAdvertisements($link));
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<?php include './include/header.php'; ?>
	<style>
		select.form-control {
			-webkit-appearance: menulist;
			-moz-appearance: menulist;
			appearance: menulist;
		}

		.select2.select2-container {
			width: 100% !important;
		}

		.select2.select2-container .select2-selection {
			border: 1px solid #ccc;
			-webkit-border-radius: 3px;
			-moz-border-radius: 3px;
			border-radius: 3px;
			height: 34px;
			margin-bottom: 15px;
			outline: none !important;
			transition: all .15s ease-in-out;
		}

		.select2.select2-container .select2-selection .select2-selection__rendered {
			color: #333;
			line-height: 32px;
			padding-right: 33px;
		}

		.select2.select2-container .select2-selection .select2-selection__arrow {
			background: #f8f8f8;
			border-left: 1px solid #ccc;
			-webkit-border-radius: 0 3px 3px 0;
			-moz-border-radius: 0 3px 3px 0;
			border-radius: 0 3px 3px 0;
			height: 32px;
			width: 33px;
		}

		.select2.select2-container.select2-container--open .select2-selection.select2-selection--single {
			background: #f8f8f8;
		}

		.select2.select2-container.select2-container--open .select2-selection.select2-selection--single .select2-selection__arrow {
			-webkit-border-radius: 0 3px 0 0;
			-moz-border-radius: 0 3px 0 0;
			border-radius: 0 3px 0 0;
		}

		.select2.select2-container.select2-container--open .select2-selection.select2-selection--multiple {
			border: 1px solid #34495e;
		}

		.select2.select2-container .select2-selection--multiple {
			height: auto;
			min-height: 34px;
		}

		.select2.select2-container .select2-selection--multiple .select2-search--inline .select2-search__field {
			margin-top: 0;
			height: 32px;
		}

		.select2.select2-container .select2-selection--multiple .select2-selection__rendered {
			display: block;
			padding: 0 4px;
			line-height: 29px;
		}

		.select2.select2-container .select2-selection--multiple .select2-selection__choice {
			background-color: #f8f8f8;
			border: 1px solid #ccc;
			-webkit-border-radius: 3px;
			-moz-border-radius: 3px;
			border-radius: 3px;
			margin: 4px 4px 0 0;
			padding: 0 6px 0 22px;
			height: 24px;
			line-height: 24px;
			font-size: 12px;
			position: relative;
		}

		.select2.select2-container .select2-selection--multiple .select2-selection__choice .select2-selection__choice__remove {
			position: absolute;
			top: 0;
			left: 0;
			height: 22px;
			width: 22px;
			margin: 0;
			text-align: center;
			color: #e74c3c;
			font-weight: bold;
			font-size: 16px;
		}

		.select2-container .select2-dropdown {
			background: transparent;
			border: none;
			margin-top: -5px;
		}

		.select2-container .select2-dropdown .select2-search {
			padding: 0;
		}

		.select2-container .select2-dropdown .select2-search input {
			outline: none !important;
			border: 1px solid #34495e !important;
			border-bottom: none !important;
			padding: 4px 6px !important;
		}

		.select2-container .select2-dropdown .select2-results {
			padding: 0;
		}

		.select2-container .select2-dropdown .select2-results ul {
			background: #fff;
			border: 1px solid #34495e;
		}

		.select2-container .select2-dropdown .select2-results ul .select2-results__option--highlighted[aria-selected] {
			background-color: #3498db;
		}
	</style>

	<link rel="stylesheet" href="vendor/select2/dist/css/select2-bootstrap.min.css">
	<link rel="stylesheet" href="vendor/select2/dist/css/select2.min.css" />
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
						<h1 class="text-white">Job Vacancies</h1>
					</div>
				</div>
			</div>
			<!-- Breadcrumb row -->
			<div class="breadcrumb-row">
				<div class="container">
					<ul class="list-inline">
						<li><a href="#">Home</a></li>
						<li>Job Vacancies</li>
					</ul>
				</div>
			</div>
			<!-- Breadcrumb row END -->
			<!-- contact area -->
			<div class="content-block">
				<div class="section-area section-sp1">
					<div class="container">
						<div class="row">
							<!-- Left part start -->
							<div class="col-lg-8">

								<?php
								if (!empty($Vacancies)) {
									$Count = 0;
									foreach ($Vacancies as $Vacancy) {

										$dateTime = new DateTime($Vacancy['date_time']);
										$formattedDate = $dateTime->format("M d Y");

										if ($Vacancy['status_active'] != "Active") {
											continue;
										}

										if (isset($id)) {
											if ($Vacancy['add_for'] != $id && $id != "All") {
												continue;
											}
										}

										if (isset($city)) {
											if ($Vacancy['city'] != $city) {
												continue;
											}
										}

										$Count++;

								?>
										<div class="blog-post blog-md clearfix">
											<div class="ttr-post-media">
												<a href="./job-detail?id=<?= $Vacancy['quest_id'] ?>&title=<?= $Vacancy['display_name'] ?>"><img src="assets/images/vacancy/<?= $Vacancy['img_url'] ?>" alt=""></a>
											</div>
											<div class="ttr-post-info">
												<ul class="media-post">
													<li><a href="#"><i class="fa fa-calendar"></i><?= $formattedDate ?></a></li>
													<li><a href="./job-detail?id=<?= $Vacancy['quest_id'] ?>&title=<?= $Vacancy['display_name'] ?>"><i class="fa fa-user"></i>By <?= $Vacancy['f_name'] ?> <?= $Vacancy['l_name'] ?></a></li>
												</ul>
												<h5 class="post-title"><a href="./job-detail?id=<?= $Vacancy['quest_id'] ?>&title=<?= $Vacancy['display_name'] ?>"><?= $Vacancy['display_name'] ?></a></h5>
												<p>We are Looking for <?= $Vacancy['add_for'] ?></p>
												<p><?= nl2br(strip_tags(substr($Vacancy['description'], 0, 100))) ?>..</p>
												<div class="post-extra">
													<a href="./job-detail?id=<?= $Vacancy['quest_id'] ?>&title=<?= $Vacancy['display_name'] ?>" class="btn-link">READ MORE</a>
													<a href="#" class="comments-bx"><i class="fa fa-map-marker"></i><?= GetCityName($link, $Vacancy['city'])['name_en'] ?></a>
												</div>
											</div>
										</div>

									<?php
									}
								}

								if ($Count == 0) { ?>
									<h4>Sorry..! No jobs Found</h4>
								<?php
								} else { ?>
									<!-- Pagination start -->
									<div class="pagination-bx rounded-sm gray clearfix">
										<ul class="pagination">
											<li class="previous"><a href="#"><i class="ti-arrow-left"></i> Prev</a></li>
											<li class="active"><a href="#">1</a></li>
											<li class="next"><a href="#">Next <i class="ti-arrow-right"></i></a></li>
										</ul>
									</div>
									<!-- Pagination END -->
								<?php
								}
								?>


							</div>
							<!-- Left part END -->
							<!-- Side bar start -->
							<div class="col-lg-4 sticky-top">
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
									<hr>

									<div class="widget">
										<h6 class="widget-title">Filter</h6>
										<label>City</label>
										<form action="./vacancies" method="get">

											<select class="form-control" id="city-list" name="city">
												<?php
												$VacanciesByCity = VacanciesCountByCity($link);
												if (!empty($VacanciesByCity)) {
													foreach ($VacanciesByCity as $Vacancy) {
												?>
														<option <?php if (isset($_GET['city'])) {
																	echo ($city == $Vacancy['city']) ? "selected" : "";
																} ?> value="<?php echo $Vacancy['city']; ?>"><?php echo GetCityName($link, $Vacancy['city'])['name_en']; ?> - (<?php echo number_format($Vacancy['VacancyCount']); ?> Jobs Found)</option>
												<?php
													}
												}
												?>
											</select>

											<label>Add For</label>
											<select class="js-example-basic-single" style="width:100%" required="required" name="add_type" id="add_type">
												<option <?= ($id == "All") ? "selected" : "" ?> value="All">All</option>
												<option <?= ($id == "Pharmacist") ? "selected" : "" ?> value="Pharmacist">Pharmacist</option>
												<option <?= ($id == "Assistant") ? "selected" : "" ?> value="Assistant">Assistant</option>
												<option <?= ($id == "Assistant Trainee") ? "selected" : "" ?> value="Assistant Trainee">Assistant Trainee</option>

											</select>

											<button type="submit" onclick="" class="mt-2 btn btn-primary">Filter</button>
										</form>
									</div>
									<hr>


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
		<?php include './include/footer.php'; ?>
		<!-- Footer END ==== -->
		<button class="back-to-top fa fa-chevron-up"></button>
	</div>

	<?php include './include/footer-scripts.php'; ?>
	<script src="vendor/select2/template/select2.min.js"></script>
	<script src="vendor/select2/template/select2.js"></script>
	<script>
		$("#city-list").select2();
	</script>
</body>

</html>