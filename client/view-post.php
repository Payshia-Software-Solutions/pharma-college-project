<?php
require_once './include/configuration.php';
include './include/functions.php';


$CompanyInfo = GetCompanyInfo($link);
$Posts = GetPublicPosts($link);
if (isset($_GET['PostID'])) {
	$PostID = $_GET['PostID'];
} else {
	$PostID = reset($Posts)["post_id"];
}

$Post = $Posts[$PostID];
$UserDetails = GetUsers($link);

$PageName = "View Post | " . $Posts[$PostID]["post_title"];

$post_description = $Post["post_description"];
if (strlen($post_description) > 150) {
	$post_description =  strip_tags(substr($post_description, 0, 150)) . "...";
}

$dateTime = new DateTime($Post['post_date']);
$newDateFormat = $dateTime->format('Y-m-d');
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
						<h1 class="text-white"><?= $Posts[$PostID]["post_title"] ?></h1>
					</div>
				</div>
			</div>
			<!-- Breadcrumb row -->
			<div class="breadcrumb-row">
				<div class="container">
					<ul class="list-inline">
						<li><a href="#">Home</a></li>
						<li><?= $Posts[$PostID]["post_title"] ?></li>
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
										<img src="./web-admin-2.0/assets/images/post/<?= $Post['post_id'] ?>/cover/<?= $Post['post_cover'] ?>" alt="">
									</div>
									<div class="info-bx">
										<ul class="media-post">
											<li><a href="#"><i class="fa fa-calendar"></i><?= $newDateFormat ?></a></li>
											<li><a href="#"><i class="fa fa-user"></i>By <?= $Post['created_by'] ?></a></li>
										</ul>
										<h5 class="post-title"><a href="#"><?= $Post["post_title"] ?></a></h5>
										<p><?= $Post["post_description"] ?></p>
										<div class="ttr-divider bg-gray"><i class="icon-dot c-square"></i></div>
										<div class="widget_tag_cloud">
											<h6>TAGS</h6>
											<div class="tagcloud">
												<?php
												$keywords = explode(',', $Post['keywords']);

												// Loop through the keywords and echo them
												foreach ($keywords as $keyword) { ?>
													<a href="#"><?= $keyword ?></a>
												<?php
												}
												?>
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
								<div class="clear" id="comment-list">
									<div class="comments-area" id="comments">
										<h2 class="comments-title">0 Comments</h2>
										<div class="clearfix m-b20">
											<!-- comment list END -->

											<!-- comment list END -->
											<!-- Form -->
											<div class="comment-respond" id="respond">
												<h4 class="comment-reply-title" id="reply-title">Leave a Reply <small> <a style="display:none;" href="#" id="cancel-comment-reply-link" rel="nofollow">Cancel reply</a> </small> </h4>
												<form class="comment-form" id="commentform" method="post">
													<p class="comment-form-author">
														<label for="author">Name <span class="required">*</span></label>
														<input type="text" value="" name="Author" placeholder="Author" id="author">
													</p>
													<p class="comment-form-email">
														<label for="email">Email <span class="required">*</span></label>
														<input type="text" value="" placeholder="Email" name="email" id="email">
													</p>
													<p class="comment-form-url">
														<label for="url">Website</label>
														<input type="text" value="" placeholder="Website" name="url" id="url">
													</p>
													<p class="comment-form-comment">
														<label for="comment">Comment</label>
														<textarea rows="8" name="comment" placeholder="Comment" id="comment"></textarea>
													</p>
													<p class="form-submit">
														<input type="submit" value="Submit Comment" class="submit" id="submit" name="submit">
													</p>
												</form>
											</div>
											<!-- Form -->
										</div>
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
										<h6 class="widget-title">Recent Posts</h6>
										<div class="widget-post-bx">
											<?php
											if (!empty($Posts)) {
												foreach ($Posts as $Post) {

													$post_description = $Post["post_description"];
													if (strlen($post_description) > 150) {
														$post_description =  strip_tags(substr($post_description, 0, 150)) . "...";
													}


													$dateTime = new DateTime($Post['post_date']);
													$newDateFormat = $dateTime->format('Y-m-d');
											?>


													<div class="widget-post clearfix">
														<div class="ttr-post-media"> <img src="./web-admin-2.0/assets/images/post/<?= $Post['post_id'] ?>/cover/<?= $Post['post_cover'] ?>" width="200" height="143" alt=""> </div>
														<div class="ttr-post-info">
															<div class="ttr-post-header">
																<h6 class="post-title"><a href="./view-post?PostID=<?= $Post['post_id'] ?>&PostTitle=<?= $Post['post_title'] ?>"><?= $Post['post_title'] ?></a></h6>
															</div>
															<ul class="media-post">
																<li><a href="#"><i class="fa fa-calendar"></i><?= $newDateFormat ?></a></li>
																<li><a href="#"><i class="fa fa-user"></i>By <?= $Post['created_by'] ?></a></li>
															</ul>
														</div>
													</div>
											<?php

												}
											} else {
												echo "No Posts Available";
											}
											?>

										</div>
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
											<?php
											// Loop through the keywords and echo them
											foreach ($keywords as $keyword) { ?>
												<a href="#"><?= $keyword ?></a>
											<?php
											}
											?>
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