<style>
    html,
    body {
        scroll-behavior: smooth;
    }
</style>

<?php
$breadcrumbs_bg = 'assets/images/slider/slide-1.jpg';
?>

<header class="header rs-nav <?= ($PageName == "Home" || $PageName == "Careers") ? "header-transparent" : "" ?>">
    <div class="top-bar">
        <div class="container">
            <div class="row d-flex justify-content-between">
                <div class="topbar-left">
                    <ul>
                        <li><a href="#"><i class="fa fa-question-circle"></i>Ask a Question</a></li>
                        <li><a href="javascript:;"><i class="fa fa-envelope-o"></i>info@pharmacollege.lk</a></li>
                    </ul>
                </div>
                <div class="topbar-right">
                    <ul>
                        <li>
                            <select class="header-lang-bx">
                                <option data-icon="flag flag-uk">English UK</option>
                                <option data-icon="flag flag-lk">Sinhala LK</option>
                            </select>
                        </li>
                        <li><a href="#">Login</a></li>
                        <li><a href="./register">Apply Now</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="sticky-header navbar-expand-lg">
        <div class="menu-bar clearfix">
            <div class="container clearfix">
                <!-- Header Logo ==== -->
                <div class="menu-logo">
                    <a href="index"><img src="assets/images/logo.png" alt="" style="height: 60%;"></a>
                </div>
                <!-- Mobile Nav Button ==== -->
                <button class="navbar-toggler collapsed menuicon justify-content-end" type="button" data-toggle="collapse" data-target="#menuDropdown" aria-controls="menuDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
                <!-- Author Nav ==== -->
                <div class="secondary-menu">
                    <div class="secondary-inner">
                        <ul>
                            <li><a href="https://web.pharmacollege.lk/" target="_blank" class="btn p-2 student-login-button">Student Login</a></li>
                        </ul>
                    </div>
                </div>
                <!-- Search Box ==== -->
                <div class="nav-search-bar">
                    <form action="#">
                        <input name="search" value="" type="text" class="form-control" placeholder="Type to search">
                        <span><i class="ti-search"></i></span>
                    </form>
                    <span id="search-remove"><i class="ti-close"></i></span>
                </div>
                <!-- Navigation Menu ==== -->
                <div class="menu-links navbar-collapse collapse justify-content-start" id="menuDropdown">
                    <div class="menu-logo">
                        <a href="./"><img src="assets/images/logo.png" style="height: 60%;" alt=""></a>
                    </div>
                    <ul class="nav navbar-nav">
                        <li class="single-menu active"><a href="./">Home</a></li>
                        <li class="single-menu"><a href="<?= ($PageName == 'Home') ? '#search-grade' : './#search-grade' ?>" class="<?= ($PageName == 'Home') ? 'smooth-scroll' : './' ?>">Certificate</a></li>

                        <li class="single-menu"><a href="./about">About Us</a></li>
                        <li class="add-mega-menu"><a href="javascript:;">Our Courses <i class="fa fa-chevron-down"></i></a>
                            <ul class="sub-menu add-menu">
                                <li class="add-menu-left">
                                    <h5 class="menu-adv-title">Our Courses</h5>
                                    <ul>
                                        <?php
                                        if (!empty($Courses)) {
                                        ?>
                                            <li><a href="courses-details"><?= reset($Courses)["course_name"] ?></a></li>
                                        <?php
                                        }
                                        ?>
                                        <li><a href="courses">All Courses </a></li>
                                        <!-- <li><a href="profile">Instructors</a></li> -->
                                    </ul>
                                </li>
                                <li class="add-menu-right">
                                    <img src="<?= $baseUrl ?>/assets/content/lms-management/assets/images/course-img/<?= reset($Courses)["course_code"] ?>/<?= reset($Courses)['course_img']; ?>" alt="CourseImg" class="rounded" />

                                    <a href="./register" class="btn radius-xl mt-2">Apply Now</a>
                                </li>
                            </ul>
                        </li>
                        <li class="single-menu"><a href="./careers">Careers</a></li>
                        <li><a href="javascript:;">Blog & News <i class="fa fa-chevron-down"></i></a>
                            <ul class="sub-menu">
                                <li><a href="event">Upcoming Event</a></li>
                                <li><a href="post">Posts</a></li>
                            </ul>
                        </li>
                        <!-- <li class="nav-dashboard"><a href="javascript:;">My Profile <i class="fa fa-chevron-down"></i></a>
                            <ul class="sub-menu">
                                <li><a href="profile">My Profile</a></li>

                            </ul>
                        </li> -->
                    </ul>
                    <div class="nav-social-link">
                        <a href="javascript:;"><i class="fa fa-facebook"></i></a>
                        <a href="javascript:;"><i class="fa fa-google-plus"></i></a>
                        <a href="javascript:;"><i class="fa fa-linkedin"></i></a>
                    </div>
                </div>
                <!-- Navigation Menu END ==== -->
            </div>
        </div>
    </div>

</header>

<?php
// var_dump($Courses);
?>