<div class="results-out">
    <?php
    require_once "../include/configuration.php"; // Include config file   
    $LoggedUser = $_GET['q'];

    $sql = "SELECT `userid`, `fname`, `lname`, `username`, `userlevel`, `userid` FROM `users` WHERE `username` LIKE '$LoggedUser'";
    $result = $link->query($sql);
    while ($row = $result->fetch_assoc()) {
        $first_name = $row['fname'];
        $last_name = $row['lname'];
        $selected_id = $row['userid'];
    }
    if (isset($selected_id)) { ?>

        <style>
            .enroll-item {
                margin-bottom: 10px;
                background-color: rgba(255, 255, 255, 0.15);
                padding: 10px;
                min-height: 380px;
                border-radius: 10px;
                overflow: hidden;
            }

            .course-item {
                cursor: pointer;
                border-radius: 10px !important;
            }

            .course-item img {
                border-radius: 10px 10px 0 0 !important;
            }

            .course-item .card-body {
                padding: 8px;
                font-size: 1rem;
            }
        </style>
        <div class="enroll-item">
            <h4 class="border-bottom pb-2 mt-4 text-center">Select the course to view Result </h4>
            <div class="row">
                <?php
                $sql = "SELECT `course_code` FROM `student_course` WHERE `student_id` LIKE '$selected_id'";
                $result = $link->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $paid_amount = $discount_amount = $base_amount = 0;
                        $payment_status = "Not Paid";
                        $course_code = $row['course_code'];

                        $sql_inner = "SELECT `course_name`, `course_code`, `course_description`, `course_fee`, `registration_fee` FROM `course` WHERE `course_code` LIKE '$course_code'";
                        $result_inner = $link->query($sql_inner);
                        while ($row = $result_inner->fetch_assoc()) {
                            $course_name = $row['course_name'];
                            $course_fee = $row['course_fee'];
                            $registration_fee = $row['registration_fee'];
                            $base_amount = $registration_fee + $course_fee;
                            $due_amount = $course_fee + $registration_fee;
                        }

                        $sql_inner = "SELECT `payment_status`, `paid_amount`, `discount_amount` FROM `student_payment` WHERE `student_id` LIKE '$selected_id' AND `course_code` LIKE '$course_code'";
                        $result_inner = $link->query($sql_inner);
                        while ($row = $result_inner->fetch_assoc()) {
                            $payment_status = $row['payment_status'];
                            $paid_amount += $row['paid_amount'];
                            $discount_amount += $row['discount_amount'];
                            $due_amount -= ($paid_amount + $discount_amount);
                        }

                        $sql_inner = "SELECT `img_path` FROM `img_course` WHERE `course_code` LIKE '$course_code'";
                        $result_inner = $link->query($sql_inner);
                        while ($row = $result_inner->fetch_assoc()) {
                            $img_path = $row["img_path"];
                        }

                ?>
                        <div class="col-6 col-sm-6 col-md-6 col-xl-4 mb-0 py-2 grid-margin stretch-card d-flex">
                            <div class="card shadow-sm course-item flex-fill" onclick="GetResult('<?php echo $course_code; ?>', '<?php echo $LoggedUser; ?>')">
                                <img class="course-img" src="https://lms.pharmacollege.lk/<?php echo $img_path; ?>" alt="Cover Image" width="100%">
                                <div class="card-body text-center p-1">
                                    <p class=" course-title p-0 mb-0" style=" color:black"><?php echo $course_name; ?></p>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                } else { ?>
                    <div class="col-12">
                        <div class="alert alert-warning" role="alert">Not Enrolled to Any Course</div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    <?php
    } else {
        echo '<div class="alert alert-warning" role="alert">Invalid Index Number</div>';
    }
    ?>
</div>