<?php
$UserCount = count($UserDetails);
$CourseCount = count($Courses);
$LearnValue = 20000;
?>
<style>

</style>
<div id="search-grade" class="section-area section-sp1 ovpr-dark bg-fix online-cours" style="background-image:url(assets/images/background/bg1.jpg);">
    <div class="container">

        <div class="row">
            <div class="col-md-12 text-center text-white">
                <h2>Certificate Verification</h2>
                <form class="cours-search">
                    <div class="input-group">
                        <input type="text" autocomplete="off" class="form-control" placeholder="Enter Index Number or Your Name? Eg - PA07454 or A. K. D. Jayesinghe" id="search-input">
                        <div class="input-group-append d-none">
                            <button type="button" class="btn">Search</button>
                        </div>
                    </div>
                    <div id="search-result"></div>
                </form>

            </div>
        </div>
        <div class="mw800 m-auto">
            <div class="row">
                <div class="col-md-4 col-sm-6">
                    <div class="cours-search-bx m-b30">
                        <div class="icon-box">
                            <h3><i class="ti-user"></i><span class="counter"><?= $UserCount ?></span></h3>
                        </div>
                        <span class="cours-search-text">Over <?= $UserCount ?> student</span>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="cours-search-bx m-b30">
                        <div class="icon-box">
                            <h3><i class="ti-book"></i><span class="counter"><?= $CourseCount ?></span></h3>
                        </div>
                        <span class="cours-search-text"><?= $CourseCount ?> Courses.</span>
                    </div>
                </div>
                <div class="col-md-4 col-sm-12">
                    <div class="cours-search-bx m-b30">
                        <div class="icon-box">
                            <h3><i class="ti-layout-list-post"></i><span class="counter"><?= ThousandDivider($LearnValue) ?></span><?= ($LearnValue > 1000) ? "K" : "" ?></h3>
                        </div>
                        <span class="cours-search-text">Learn Anything Online.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>