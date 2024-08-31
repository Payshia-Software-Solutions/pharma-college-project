<?php
if ($courseCode != null) {
?>
    <div class="row">
        <div class="col-12">
            <div class="alert alert-warning border-2 shadow-sm" id="courseAlert">

                Your Default course is <b><?= $courseCode ?> - <?= GetCourseDetails($courseCode)['course_name'] ?></b>
                <div class="text-start">
                    <button onclick="SetDefaultCourse(1)" type="button" class="btn btn-dark btn-sm">
                        <i class="fa-brands fa-slack"></i> Change Default Course
                    </button>
                    <button class="btn btn-danger btn-sm" onclick="$('#courseAlert').hide(500)">
                        <i class="fa-solid fa-xmark"></i> Close
                    </button>
                </div>


            </div>
        </div>
    </div>
<?php
} else {
    exit;
}
