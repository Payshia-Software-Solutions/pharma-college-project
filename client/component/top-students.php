<div class="section-area section-sp2 mb-4">
    <div class="container">
        <div class="row">
            <div class="col-md-12 heading-bx left">
                <h2 class="title-head">Top <span>Students</span></h2>
                <p>Certificate Course In Pharmacy Practice</p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="teachers mt-20">

                    <div class="row">

                        <div class="recent-news-carousel owl-carousel owl-btn-1 col-12 p-lr0 pb-3">
                            <div class="col-12">
                                <div class="alert alert-info">This Students will be announced soon</div>
                            </div>
                            <?php
                            $count = 0;
                            $place = 0;
                            $sql = "SELECT `content`, `imagepath`, `IndexNumber` FROM `top-student-img` ORDER BY `content` LIMIT 4";
                            $result = $link->query($sql);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $fullName = $result_fname = $result_lname = "";
                                    $imagepath = "No Image";
                                    $imagepath = $row["imagepath"];
                                    $IndexNumber = $row["IndexNumber"];
                                    $getStudentID = "SELECT `userid`, `username`,`fname`, `lname` FROM `users` WHERE username LIKE '$IndexNumber'";
                                    $getStudentIDResult = $link->query($getStudentID);

                                    while ($row = $getStudentIDResult->fetch_assoc()) {
                                        $result_user = $row["userid"];
                                        $result_fname = $row["fname"];
                                        $result_lname = $row["lname"];

                                        $Get_Course_SQL = "SELECT `id`, `course_code`, `student_id`, `enrollment_key`, `created_at` FROM `student_course` WHERE student_id LIKE '$result_user'";

                                        $Get_Course_SQL_Result = $link->query($Get_Course_SQL);
                                        while ($row = $Get_Course_SQL_Result->fetch_assoc()) {
                                            $course_code_get = $row["course_code"];
                                        }
                                    }

                                    $fullName = $result_fname . " " . $result_lname;

                                    $place += 1;

                            ?>
                                    <!-- <div class="item">
                                        <div class="singel-teachers text-center">
                                            <div class="image">
                                                <img src="https://pharmacollege.lk/uploads/top-students/<?php echo $imagepath; ?>" alt="Profile-Image-<?php echo $fullName; ?>">
                                            </div>
                                            <div class="cont shadow pt-1">
                                                <a href="result-view.php?CourseCode=<?php echo $course_code_get; ?>&LoggedUser=<?php echo $IndexNumber; ?>" target="_blank">
                                                    <h6><?php echo $fullName; ?></h6>
                                                </a>
                                                <span><?php echo $IndexNumber; ?></span>
                                            </div>
                                        </div> 
                        </div> -->
                            <?php
                                }
                            }
                            ?>

                        </div>

                    </div> <!-- row -->
                </div> <!-- teachers -->
            </div>
        </div> <!-- row -->
    </div> <!-- container -->
    </section>