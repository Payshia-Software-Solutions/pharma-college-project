<style>
    .action-box {
        min-height: 265px;
    }

    .info-bx {
        min-height: 130px;
    }
</style>

<div class="section-area section-sp2 popular-courses-bx mt-5" style="padding-top:120px">
    <div class="container">
        <div class="row">
            <div class="col-md-12 heading-bx left">
                <h2 class="title-head">Popular <span>Courses</span></h2>
                <p>It is a long established fact that a reader will be distracted by the readable
                    content of a page</p>
            </div>
        </div>
        <div class="row">
            <div class="courses-carousel owl-carousel owl-btn-1 col-12 p-lr0">

                <?php

                if (!empty($Courses)) {
                    $LoopCount = 0;
                    foreach ($Courses as $TopCourse) {


                ?>
                        <div class="item">
                            <div class="cours-bx">
                                <div class="action-box">
                                    <img src="<?= $baseUrl ?>/assets/content/lms-management/assets/images/course-img/<?= $TopCourse['course_code'] ?>/<?= $TopCourse['course_img'] ?>" alt="">
                                    <a href="./courses-details?id=<?= $TopCourse["course_code"] ?>" class="btn">Read More</a>
                                </div>
                                <div class="info-bx text-center">
                                    <h5><a href="./courses-details?id=<?= $TopCourse["course_code"] ?>"><?= $TopCourse["course_name"] ?></a></h5>
                                    <span><?= $TopCourse["course_code"] ?></span>
                                </div>
                                <div class="cours-more-info">
                                    <div class="review">
                                        <span>155 Review</span>
                                        <ul class="cours-star">
                                            <li class="active"><i class="fa fa-star"></i></li>
                                            <li class="active"><i class="fa fa-star"></i></li>
                                            <li class="active"><i class="fa fa-star"></i></li>
                                            <li class="active"><i class="fa fa-star"></i></li>
                                            <li class="active"><i class="fa fa-star"></i></li>
                                        </ul>
                                    </div>
                                    <div class="price">
                                        <del><?= number_format($TopCourse["course_fee"] + 10000, 2) ?></del>
                                        <h5><?= number_format($TopCourse["course_fee"], 2) ?></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                <?php
                        $LoopCount++;
                    }
                }
                ?>


            </div>
        </div>
    </div>
</div>