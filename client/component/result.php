wh<style>
    .company-name {
        margin: 0px;
        margin-top: 10px;
        padding: 0px;
        text-align: center;
        font-size: 35px;
    }

    .InstituteDescription {
        margin: 0px;
        padding: 0px;
        text-align: center;
        font-size: 20px;
    }

    .company-contact {
        margin: 0px;
        padding: 0px;
        text-align: center;
        font-size: 18px;
    }

    .report-name {
        margin-top: 25px;
        padding: 0px;
        text-align: center;
        font-size: 22px;
        font-weight: 600;
    }

    .report-name-other {
        margin: 0px;
        margin-bottom: 20px;
        padding: 0px;
        text-align: center;
        font-size: 20px;
        font-weight: 600;
    }

    td,
    th {
        text-align: start;
    }

    .result-table {
        /* width: 100%; */
        border-collapse: collapse;
        font-size: 18px;
    }

    .result-table thead th {
        /* border: 1px solid #343a40; */
        padding: 5px 10px;
        text-align: left;
    }

    .result-table thead td {
        /* border: 1px solid #343a40; */
        padding: 5px 10px;
        text-align: left;
    }

    .result-table tbody th {
        /* border: 1px solid #343a40; */
        padding: 5px 10px;
        text-align: left;
    }

    .result-table tbody td {
        /* border: 1px solid #343a40; */
        padding: 5px 10px;
        text-align: left;
    }

    .result-table thead th {
        background-color: #087f5b;
        color: #fff;
        width: 25%;
    }

    .result-table tbody tr:nth-child(even) {
        background-color: #f8f9fa;
    }

    .result-table tbody tr:nth-child(odd) {
        background-color: #e9ecef;
    }

    .text-center {
        text-align: center;
    }

    .footer {
        width: 100%;
        bottom: 1px;
        color: #087f5b;
        text-align: center;
        font-size: 12px;
    }

    .label-text {
        font-size: 16px;
        font-weight: 400;
        display: inline-block;
        width: 30%;
    }

    .label-data {
        font-size: 16px;
        font-weight: 600;
        display: inline-block;
    }

    .grade-table {
        width: 100% !important;
    }
</style>

<div class="section-area section-sp2 results-out">
    <div class="container">

        <center><img class="" src="./assets/images/logo.png" width="120px" alt="Cover Image"></center>
        <h1 class="company-name"><?php echo $company_name; ?></h1>
        <p class="InstituteDescription"><?php echo $company_address; ?>, <?php echo $company_address2; ?>, <?php echo $company_city; ?></p>
        <p class="company-contact">Tel : <?php echo $company_telephone; ?> / Email : <?php echo $company_email; ?> </p>
        <p class="company-contact">Visit us : <a href="https://pharmacollege.lk/">www.pharmacollege.lk</a></p>

        <div class="report-name">Academic Report</div>
        <div class="report-name-other"><?php echo $course_name; ?></div>
        <div class="row">
            <div class="col-md-6">
                <div>
                    <div class="label-text">Index Number</div>
                    <div class="label-data"> : <?php echo $LoggedUser; ?></div>
                </div>

                <div>
                    <div class="label-text">Name of Student</div>
                    <div class="label-data"> : <?php echo $first_name; ?> <?php echo $last_name; ?></div>
                </div>

                <div>
                    <div class="label-text">NIC</div>
                    <div class="label-data"> : <?php echo $nic; ?></div>
                </div>
            </div>
            <div class="col-md-6">
                <div>
                    <div class="label-text">Address</div>
                    <div class="label-data"> : <?php echo $address_line_1; ?>, <?php echo $address_line_2; ?>, <?php echo $city_name_en; ?></div>
                </div>

                <div>
                    <div class="label-text">Email</div>
                    <div class="label-data"> : <?php echo $e_mail; ?></div>
                </div>

                <div>
                    <div class="label-text">Complete Date</div>
                    <div class="label-data"> : <?php echo $completeDate; ?></div>
                </div>
            </div>
        </div>
    </div>

    <hr>
    <h1 class="text-center">Final Grade : <?php echo $finalGrade; ?></h1>
    <div class="container">
        <table class="table result-table">
            <thead>
                <tr>
                    <th scope="col">Focus Area</th>
                    <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>OverRall Grade</td>
                    <th><?php echo $finalGrade; ?></th>
                </tr>
                <?php
                $sql = "SELECT `id`, `title_id`, `course_code`, `active_status`, `created_at`, `created_by` FROM `certificate_course` WHERE `active_status` NOT LIKE 'Deleted' AND `course_code` LIKE '$CourseCode' ORDER BY `id`";
                $result = $link->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $result_user = "Result Not Submitted";
                        $course_code = $row['course_code'];
                        $title_id = $row['title_id'];
                        $title_active_status = $row['active_status'];


                        $sql_inner = "SELECT `title_name` FROM `certificate_title` WHERE `id` LIKE '$title_id'";
                        $result_inner = $link->query($sql_inner);
                        if ($result_inner->num_rows > 0) {
                            while ($row = $result_inner->fetch_assoc()) {
                                $title_name = $row['title_name'];
                            }
                        }

                        $sql_inner = "SELECT `result` FROM `certificate_user_result` WHERE `index_number` LIKE '$LoggedUser' AND `course_code` LIKE '$CourseCode' AND `title_id` LIKE '$title_id'";
                        $result_inner = $link->query($sql_inner);
                        if ($result_inner->num_rows > 0) {
                            while ($row = $result_inner->fetch_assoc()) {
                                $result_user = $row['result'];
                            }
                        }
                ?>

                        <tr>
                            <td><?php echo $title_name; ?></td>
                            <th><?php echo $result_user; ?></th>
                        </tr>


                <?php
                    }
                }
                ?>
            </tbody>


        </table>
    </div>
    <div class="footer container">
        <div class="table-responsive">
            <table class="table table-striped border grade-table rounded-2 mt-5 mb-3" align="center">
                <tr>
                    <th> Grade </th>
                    <th> Scale </th>
                    <th> Grade </th>
                    <th> Scale </th>
                    <th> Grade </th>
                    <th> Scale </th>
                    <th> Grade </th>
                    <th> Scale </th>
                </tr>
                <tr>
                    <td align="">A+</td>
                    <td style="white-space:nowrap;">90.00 - 100.00</td>

                    <td align=""> B+ </td>
                    <td style="white-space:nowrap;"> 70.00 - 74.00 </td>

                    <td align=""> C+ </td>
                    <td style="white-space:nowrap;"> 55.00 - 59.00 </td>

                    <td align=""> D+ </td>
                    <td style="white-space:nowrap;"> 35.00 - 39.00 </td>

                </tr>
                <tr>
                    <td align=""> A </td>
                    <td style="white-space:nowrap;"> 80.00 - 89.00 </td>

                    <td align=""> B </td>
                    <td style="white-space:nowrap;"> 65.00 - 69.00 </td>

                    <td align=""> C </td>
                    <td style="white-space:nowrap;"> 45.00 - 54.00 </td>

                    <td align=""> D </td>
                    <td style="white-space:nowrap;"> 30.00 - 34.00 </td>
                </tr>
                <tr>
                    <td align=""> A- </td>
                    <td style="white-space:nowrap;"> 75.00 - 79.00 </td>

                    <td align=""> B- </td>
                    <td style="white-space:nowrap;"> 60.00 - 64.00 </td>

                    <td align=""> C- </td>
                    <td style="white-space:nowrap;"> 40.00 - 44.00 </td>

                    <td align=""> E </td>
                    <td style="white-space:nowrap;"> 0.00 - 29.00 </td>
            </table>
        </div>
        <hr>
        Please note that this online result is provisional and should not be used as an official confirmation or a certification.
        <br>
        Copyright © 2020-2022 - Department of Examination - Ceylon Pharma College
    </div>

    <!-- <div class="text-center mt-3">
        <a href="https://lms.pharmacollege.lk/modules/certificate/content/view-certificate/result-print.php?CourseCode=<?php echo $CourseCode; ?>&LoggedUser=<?php echo $LoggedUser; ?>" target="_blank"><button class="btn btn-warning" type="button">Print</button></a>

    </div> -->
</div>
</div>