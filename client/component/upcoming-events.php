<?php
$Events =  GetPublicEvents($link);
?>

<div class="section-area section-sp2">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center heading-bx">
                <h2 class="title-head m-b0">Upcoming <span>Events</span></h2>
                <p class="m-b0">Upcoming Education Events To Feed Brain. </p>
            </div>
        </div>
        <div class="row">
            <?php

            if (!empty($Events)) {
            ?>
                <div class="upcoming-event-carousel owl-carousel owl-btn-center-lr owl-btn-1 col-12 p-lr0  m-b30">
                    <?php
                    foreach ($Events as $Event) {

                        $post_description = $Event["post_description"];
                        if (strlen($post_description) > 150) {
                            $post_description =  strip_tags(substr($post_description, 0, 150)) . "...";
                        }

                        $dateTime = new DateTime($Event['post_date']);
                        $newDateFormat = $dateTime->format('Y-m-d');

                        $date = new DateTime($Event["post_date"]);
                        $SubDate = $date->format("Y-m-d");
                        $EventDate = $date->format("d");
                        $EventMonth = $date->format("F");
                    ?>
                        <div class="item">
                            <div class="event-bx">
                                <div class="action-box">
                                    <img src="./web-admin-2.0/assets/images/event/<?= $Event['post_id'] ?>/cover/<?= $Event['post_cover'] ?>" alt="">
                                </div>
                                <div class="info-bx d-flex">
                                    <div>
                                        <div class="event-time">
                                            <div class="event-date"><?= $EventDate ?></div>
                                            <div class="event-month"><?= $EventMonth ?></div>
                                        </div>
                                    </div>
                                    <div class="event-info">
                                        <h4 class="event-title"><a href="#"><?= $Event["post_title"] ?></a></h4>
                                        <ul class="media-post">
                                            <li><a href="#"><i class="fa fa-calendar"></i> <?= $SubDate ?></a></li>
                                            <li><a href="#"><i class="fa fa-map-marker"></i> <?= $Event["location"] ?></a>
                                            </li>
                                        </ul>
                                        <p><?= $post_description ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php
                    }
                    ?>
                </div>
            <?php
            } else {
                $noPosts = "No Upcoming Events";
                echo $noPosts;
            }
            ?>




        </div>
        <div class="text-center">
            <a href="#" class="btn">View All Event</a>
        </div>
    </div>
</div>