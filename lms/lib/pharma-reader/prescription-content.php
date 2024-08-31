<?php
require_once '../../include/configuration.php';
include '../../php_handler/function_handler.php';
include '../../php_handler/course_functions.php';
include './php_methods/pharma-reader-methods.php';


$userLevel = $_POST['UserLevel'];
$loggedUser = $_POST['LoggedUser'];
$courseCode = $_POST['defaultCourseCode']; // Course will be taken as Batch

$prescriptionId = $_POST['prescriptionId'];
$answer_1 = $answer_2 = $answer_3 = $answer_4 = $prescription_question  = $prescriptionName = $difficultyMode = $helpText = $fileName = "";
$prescriptionDetailedList = GetPrescriptions();

if ($prescriptionId != '0') {
    $questionArray = GetPrescriptions()[$prescriptionId];

    $answer_1 = $questionArray['answer_1'];
    $answer_2 = $questionArray['answer_2'];
    $answer_3 = $questionArray['answer_3'];
    $answer_4 = $questionArray['answer_4'];
    $correct_answer = $questionArray['correct_answer'];
    $prescription_question = $questionArray['prescription_question'];
    $prescriptionName = $questionArray['pres_name'];
    $fileName = $questionArray['image_path'];
    $difficultyMode = $questionArray['difficulty'];
    $helpText = $questionArray['PresHelp'];
    $baseFileName = basename($questionArray['image_path']);
}

?>

<style>
    .dropify-wrapper .dropify-message .file-icon p {
        font-size: 15px !important;
    }

    .inner-popup-container {
        max-height: calc(100vh - 450px);
        overflow-y: auto;
        padding: 10px;
    }


    @media (max-width: 600px) {
        .inner-popup-container {
            max-height: calc(100vh - 150px);
        }
    }

    .itemName {
        min-width: 250px;
    }
</style>

<div class="row">
    <div class="col-9 col-xl-10">
        <h4 class="mb-2 card-title fw-bold question-name border-bottom pb-2"><?= ($prescriptionName != '') ? $prescriptionName : "New Prescription" ?></h4>
    </div>
    <div class="col-3 col-xl-2 text-end">
        <button onclick="NewPrescription()" type="button" class="btn btn-light"><i class="fa-solid fa-arrow-left"></i> Back</button>
    </div>
</div>
<div class="inner-popup-container">

    <div class="row g-3">
        <div class="col-md-12">


            <form method="post" id="submit-form">
                <div class="row g-3">

                    <div class="col-md-6">
                        <div class="row g-2">
                            <div class="col-12">
                                <label class="fw-bold">Prescription Name</label>
                                <input type="text" class="form-control" name="presName" id="presName" placeholder="Prescription Name" value="<?= $prescriptionName ?>">
                            </div>
                            <div class="col-12">
                                <label class="fw-bold">Prescription File</label>
                                <input type="file" class="form-control" name="prescriptionFile" id="prescriptionFile">
                                <input type="hidden" name="item_image_tmp" id="item_image_tmp" value="<?= $fileName ?>">
                            </div>
                            <div class="col-12">
                                <label class="fw-bold">Select Difficulty</label>
                                <select class="form-control" name="difficultyMode" id="difficultyMode">
                                    <option <?= ($difficultyMode == 'Basic') ? 'selected' : '' ?> value="Basic">Basic</option>
                                    <option <?= ($difficultyMode == 'Intermediate') ? 'selected' : '' ?> value="Intermediate">Intermediate</option>
                                    <option <?= ($difficultyMode == 'Advanced') ? 'selected' : '' ?> value="Advanced">Advanced</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="fw-bold">Help Text</label>
                                <textarea class="form-control" rows="4" name="helpText" id="helpText"><?= $helpText ?></textarea>
                            </div>
                            <div class="col-12">
                                <img class="w-100 rounded-2" src="./lib/pharma-reader/assets/reader-images/<?= $baseFileName ?>" alt="<?= $prescriptionName ?> - <?= $fileName ?>">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="row g-2">


                            <div class="col-12 mb-2">
                                <label class="fw-bold">Question</label>
                                <textarea class="form-control" rows="4" name="question" id="question"><?= $prescription_question; ?></textarea>
                            </div>

                            <?php
                            $answerLabels = array("Answer 1", "Answer 2", "Answer 3", "Answer 4");
                            $answerKeys = array("answer_1", "answer_2", "answer_3", "answer_4");
                            $answers = array($answer_1, $answer_2, $answer_3, $answer_4);

                            for ($i = 0; $i < 4; $i++) {
                                $label = $answerLabels[$i];
                                $key = $answerKeys[$i];

                                $answer = ($prescriptionId != '0') ? $questionArray[$key] : '';
                            ?>
                                <div class="col-12 col-md-6">
                                    <p class="mb-0"><?= $label ?></p>
                                    <input class="form-control p-3" type="text" name="answer<?= $i + 1 ?>" id="answer<?= $i + 1 ?>" placeholder="Enter <?= $label ?>" onblur="AddOption();" value="<?= $answer; ?>" required>
                                </div>
                            <?php
                            }
                            ?>

                            <div class="col-12">
                                <p class="mb-0 ">Correct Answer</p>
                                <select class="form-control p-3" name="correct_answer" id="correct_answer">
                                    <option value="">Select Answer</option>
                                    <?php
                                    foreach ($answers as $answer) {
                                        if ($answer == "") {
                                            continue;
                                        }
                                    ?>
                                        <option <?= ($answer == $correct_answer) ? "selected" : "" ?> value="<?= $answer ?>"><?= $answer ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>


                        </div>
                    </div>



                </div>
            </form>
        </div>

    </div>
</div>
<div class="row">
    <div class="col-12 text-end mt-3">
        <?php
        if ($prescriptionId != '0' && $questionArray['active_status'] == "Active") {
        ?>
            <button onclick="" class="btn btn-danger" type="button"><i class="fa-solid fa-trash"></i> Disable</button>
        <?php
        } else if ($prescriptionId != '0' && $questionArray['active_status'] == "Deleted") {
        ?>
            <button onclick="" class="btn btn-primary" type="button"><i class="fa-solid fa-pencil"></i> Active</button>
        <?php } ?>

        <button onclick="SavePrescription('<?= $prescriptionId ?>')" class="btn btn-dark" type="button"><i class="fa-solid fa-floppy-disk"></i> Save Changes</button>
    </div>
</div>


<script>
    tinymce.remove()
    tinymce.init({
        selector: 'textarea#helpText',
        height: 250,
        plugins: 'fullscreen anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
        toolbar: 'fullscreen undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
    });

    tinymce.init({
        selector: 'textarea#question',
        height: 250,
        plugins: 'fullscreen anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
        toolbar: 'fullscreen undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
    });

    $('#prescriptionFile').dropify()
</script>