<?php

$CompanyInfo = GetCompanyInfo($link)[0];
?>
<footer>
    <div class="footer-top">
        <div class="pt-exebar">
            <div class="container">
                <div class="d-flex align-items-stretch">
                    <div class="pt-logo mr-auto">
                        <a href="./"><img src="assets/images/logo.png" style="width: 110px;" alt="" /></a>
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
                        <a href="./register" class="btn ">Apply Now</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-12 col-sm-12 footer-col-4">
                    <div class="widget">
                        <h5 class="footer-title">Sign Up For A Newsletter</h5>
                        <p class="text-capitalize m-b20">Weekly Breaking news analysis and cutting edge advices
                            on job searching.</p>
                        <div class="subscribe-form m-b20">
                            <form class="subscription-form" action="#" method="post">
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
                <div class="col-12 col-lg-9 col-md-12 col-sm-12">
                    <div class="row">
                        <div class="col-4 col-lg-2 col-md-3 col-sm-4">
                            <div class="widget footer_widget">
                                <h5 class="footer-title">Company</h5>
                                <ul>
                                    <li><a href="index">Home</a></li>
                                    <li><a href="about">About</a></li>
                                    <li><a href="contact">Contact</a></li>
                                    <li><a href="post">Posts</a></li>
                                    <li><a href="event">Event</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-4 col-lg-2 col-md-3 col-sm-4">
                            <div class="widget footer_widget">
                                <h5 class="footer-title">Get In Touch</h5>
                                <ul>
                                    <li><a href="careers">Careers</a></li>
                                    <li><a href="courses">Courses</a></li>
                                    <li><a href="profile">Profile</a></li>
                                    <li><a href="<?= ($PageName == 'Home') ? '#search-grade' : './#search-grade' ?>" class="<?= ($PageName == 'Home') ? 'smooth-scroll' : './' ?>">Certificate</a></li>
                                </ul>
                            </div>
                        </div>


                        <div class="col-12 col-lg-8 col-md-6 col-sm-12">
                            <div class="widget footer_widget">
                                <h5 class="footer-title">Contact Us</h5>
                                <h5>Head Office</h5>
                                <p class="mb-0">Ceylon Pharma College (PVT) LTD</p>
                                <p class="mb-0"><i class="ti-location-pin pr-2"></i> L35, West Tower, World Trade Center, Colombo 01, Sri Lanka</p>
                                <p class="mb-0"><i class="ti-mobile pr-2"></i> 011 74 94 335</p>
                                <p class="mb-0"><i class="ti-email pr-2"></i> info@pharmacollege.com</p>


                                <h5 class="mt-2">Operation Branch</h5>
                                <p class="mb-0"><i class="ti-location-pin pr-2"></i> Midigahamulla, Rathnapura Rd, Pelmadulla, Sri Lanka</p>
                                <p class="mb-0"><i class="ti-mobile pr-2"></i> 0715 884 884</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 text-center"> <a target="_blank" href="https://www.payshia.cpm">InspireLK & Payshia</a></div>
            </div>
        </div>
    </div>
</footer>