<?php
$servicesArray = ['service_1', 'service_2', 'service_3', 'service_4'];
?>

<div class="section-area content-inner service-info-bx">
    <div class="container">
        <div class="row g-0">

            <?php
            if (!empty($servicesArray)) {
                foreach ($servicesArray as $key) {
            ?>
                    <div class="col-lg-3 col-md-3 col-6 d-flex">
                        <a class="d-flex" href="<?= $web_content[$key]['link'] ?>">
                            <div class="service-bx flex-fill p-2">
                                <div class="action-box">
                                    <img src="assets/images/our-services/<?= $web_content[$key]['cover_img'] ?>" alt="">
                                </div>
                                <h4 class="text-center"><?= $web_content[$key]['value'] ?></h4>
                            </div>
                        </a>
                    </div>
            <?php
                }
            }
            ?>

            <div class="col-12">
                <?php include './component/accredits.php'; ?>
            </div>
            <div class="col-12 mt-5">
                <div class="text-center mt-5 bg-light p-4" style="border-radius:15px">
                    <!-- <img src="./assets/images/man.gif" class="rounded-3 shadow-sm" style="width: 150px;border-radius:15px;"> -->
                    <iframe style="width: 100%; height: 450px;border-radius:15px" src="https://www.youtube.com/embed/pqPiXXjDyAE" title="විභාග ප්‍රතිඵල වලින් ජීවිතය අසමත් කර ගන්න එපා..." frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>

                    <p class="mt-3 mb-0">Unlock your Ceylon Pharma College experience! Complete our quick, secure registration for personalized services. Join us now!</p>
                    <p>ඔබේ Ceylon Pharma College අත්දැකීම විවෘත කරන්න! පුද්ගලාරෝපිත සේවාවන් සඳහා අපගේ ඉක්මන්, ආරක්ෂිත ලියාපදිංචිය සම්පූර්ණ කරන්න. දැන්ම අප හා එක්වන්න!"</p>
                    <p class="border-top pt-2 text-secondary mt-3 mb-0">Do you want to join with us?</p>
                    <a href="./register" class="btn button-md mt-2 p-4 px-5">Apply Now</a>
                </div>
            </div>
        </div>
    </div>
</div>