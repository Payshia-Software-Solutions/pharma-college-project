<?php
$Events =  GetEvents($link);
$Posts = GetPublicPosts($link);
?>

<div class="section-area section-sp2">
    <div class="container">
        <div class="row">
            <div class="col-md-12 heading-bx left">
                <h2 class="title-head">Recent <span>Posts</span></h2>
                <p>It is a long established fact that a reader will be distracted by the readable
                    content of a page</p>
            </div>
        </div>
        <div class="recent-news-carousel owl-carousel owl-btn-1 col-12 p-lr0">

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

                    <div class="item">
                        <div class="recent-news">
                            <div class="action-box">
                                <img src="./web-admin-2.0/assets/images/post/<?= $Post['post_id'] ?>/cover/<?= $Post['post_cover'] ?>" alt="">
                            </div>
                            <div class="info-bx">
                                <ul class="media-post">
                                    <li><a href="#"><i class="fa fa-calendar"></i><?= $newDateFormat ?></a></li>
                                    <li><a href="#"><i class="fa fa-user"></i>By <?= $Post['created_by'] ?></a></li>
                                </ul>
                                <h5 class="post-title"><a href="./view-post?PostID=<?= $Post['post_id'] ?>&PostTitle=<?= $Post['post_title'] ?>"><?= $Post['post_title'] ?></a></h5>
                                <p><?= $post_description ?></p>
                                <div class="post-extra">
                                    <a href="./view-post?PostID=<?= $Post['post_id'] ?>&PostTitle=<?= $Post['post_title'] ?>" class="btn-link">READ MORE</a>
                                    <a href="#" class="comments-bx"><i class="fa fa-comments-o"></i>20
                                        Comment</a>
                                </div>
                            </div>
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
</div>